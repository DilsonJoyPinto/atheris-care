import json
import tempfile
import unittest
from pathlib import Path
from app import create_app


class AtherisApiTests(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.app = create_app({"TESTING": True, "DATABASE": str(Path(self.tmp.name) / "test.sqlite3")})
        self.client = self.app.test_client()

    def tearDown(self):
        self.tmp.cleanup()

    def test_health(self):
        response = self.client.get('/api/health')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.get_json()['status'], 'ok')

    def test_profile_and_assessment_persist(self):
        profile = self.client.post('/api/astronauts', json={
            'astronaut_id': 'SIM-TEST-01', 'full_name': 'Test Astronaut',
            'mission_id': 'TEST-MISSION', 'mission_day': 5, 'profile': {}
        })
        self.assertEqual(profile.status_code, 201)
        saved = self.client.post('/api/assessments', json={
            'astronautId': 'SIM-TEST-01', 'missionId': 'TEST-MISSION', 'missionDay': 5,
            'type': 'Full Vital Scan', 'measurements': {'heart_rate': '72', 'chest_pain': 'yes'},
            'notes': 'Fictional test entry', 'metadata': {'method': 'manual'}
        })
        self.assertEqual(saved.status_code, 201)
        record_id = saved.get_json()['assessment']['id']
        fetched = self.client.get('/api/assessments/' + record_id)
        self.assertEqual(fetched.status_code, 200)
        self.assertEqual(fetched.get_json()['measurements']['heart_rate'], '72')
        self.assertEqual(len(self.client.get('/api/alerts').get_json()), 1)
        self.assertEqual(len(self.client.get('/api/assessments').get_json()), 1)

    def test_invalid_numeric_value_rejected(self):
        response = self.client.post('/api/assessments', json={
            'astronautId': 'SIM-TEST-02', 'measurements': {'heart_rate': 'fast'}
        })
        self.assertEqual(response.status_code, 400)

    def test_assessment_is_append_only(self):
        payload = {'astronautId': 'SIM-TEST-03', 'measurements': {'sleep_hours': '7.5'}}
        first = self.client.post('/api/assessments', json=payload)
        second = self.client.post('/api/assessments', json=payload)
        self.assertEqual(first.status_code, 201)
        self.assertEqual(second.status_code, 201)
        self.assertNotEqual(first.get_json()['assessment']['id'], second.get_json()['assessment']['id'])
        self.assertEqual(len(self.client.get('/api/assessments').get_json()), 2)


if __name__ == '__main__':
    unittest.main()

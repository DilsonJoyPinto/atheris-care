<footer class="footer">
    <img src="img/images/ftr-bg.webp" alt="" class="fr-img">

    <div class="container">
        <div class="footer-main">

            <div class="ftr-logo">
                <a href="index.php" class="ftr-add">
                    <img src="logo/atheriswhite.png" alt="">
                </a>

            </div>

            <div class="ftr2main">

                <div class="ftrbx1">
                    <h2>Quick Links</h2>
                    <a href="index.php">Home</a>
                    <a href="about-us.php">About Us</a>
                    <a href="#">Our Services</a>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="connect-us.php">Contact Us</a>
                </div>

                <div class="ftrbx2">
                    <h2>Our Services</h2>
                    <a href="healthinfo.php">Vital Scan</a>
                    <a href="history.php">Health History</a>
                    <a href="analytics.php">Health Analytics</a>
                    <a href="alerts.php">Alerts &amp; Recommendations</a>
                    <a href="reports.php">Medical Reports</a>
                </div>

                <div class="ftrbx3">
                    <h2>Research Focus</h2>
                    <a href="https://www.nature.com/articles/s41433-026-04651-6" target="_blank" rel="noopener">SANS research and clinical consensus</a>
                    <a href="https://doi.org/10.1038/s41526-020-0103-2" target="_blank" rel="noopener">Bone loss in space travellers</a>
                    <a href="https://www.nasa.gov/hrp/" target="_blank" rel="noopener">NASA Human Research Program</a>
                    <a href="https://science.nasa.gov/biological-physical/data/osdr/" target="_blank" rel="noopener">NASA Open Science Data Repository</a>

                    <p>
                        Project note
                        <a href="about-us.php">A research prototype, not a diagnostic tool</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</footer>

<div class="copy">
    <div class="container">
        <div class="copyright">
            <h2>© 2026 Atheris Care</h2>
            <h3>
                Designed by
                <a href="https://www.spaceappschallenge.org/2026/find-a-team/i-show-slow/?tab=details" target="_blank">
                    I Show Slow
                </a>
            </h3>
        </div>
    </div>
</div>


<script src="js/health-platform.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src='js/bootstrap.bundle.min.js'></script>
<script src="js/owl.carousel.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/script.js"></script>
<script src="js/intlTelInput-jquery.min.js"></script>
<script src="js/classie.js"></script>
<script src="js/pathLoader.js"></script>
<script src="js/main.js"></script>


<script type="text/javascript">
$(window).on('load', function() { // <-- CHANGE IS HERE
    AOS.init({
        easing: 'ease-out-back',
        duration: 500,
        once: true
    });
});
</script>

<script>
$(document).ready(function() {
    $('.banner-carousel').owlCarousel({
        nav: false,
        // navContainer: ".title-head",
        navText: ["<img src=''>","<img src=''>"],
        loop: true,
        margin: 0,
        dots: false,
        autoplay: true,
        animateIn: 'fadeInRight', // Class for incoming slide
    animateOut: 'fadeOutLeft',
        responsive: {
            0: {
                items: 1
            },
            575: {
                items: 1
            },
            767: {
                items: 1
            },
            1000: {
                items: 1
            }
        },
        onInitialized: function() {
            AOS.refresh(); // Refresh AOS after the carousel initializes
        }
    });
});
</script>

<script>
$(document).ready(function() {
    $('.sec4-carousel').owlCarousel({
        nav: false,
        // navContainer: ".title-head",
        navText: ["<img src='images/s3-1.png'>","<img src='images/s3-2.png'>"],
        loop: true,
        margin: 15,
        dots: false,
        autoplay: true,
        responsive: {
            0: { items: 1 },
            500: { items: 2 },
            780: { items: 3 },
            900: { items: 3 },
            1000: { items: 4 }
        },
        onInitialized: function() {
            AOS.refresh(); // Refresh AOS after the carousel initializes
        }
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $(".mision-carousel").owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        autoplay: true,
        autoplayTimeout: 3000,
        smartSpeed: 800,
        nav: false,
        dots: true,
        // Vertical Animation Settings
        animateOut: 'slideOutDown', // Current slide moves down
        animateIn: 'slideInUp',      // Next slide comes from bottom up
        mouseDrag: false,
        touchDrag: false
    });
});
</script>

<script>
    function updateTimer() {
    let now = new Date();

    let hours = String(now.getHours()).padStart(2, '0');
    let minutes = String(now.getMinutes()).padStart(2, '0');
    let seconds = String(now.getSeconds()).padStart(2, '0');

    var timerElement = document.getElementById("timer");
    if (timerElement) {
        timerElement.innerHTML = hours + ":" + minutes + ":" + seconds;
    }
}

updateTimer();
setInterval(updateTimer, 1000);
</script>
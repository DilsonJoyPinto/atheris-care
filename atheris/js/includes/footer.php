<footer class="footer">
    <img src="img/images/ftr-bg.webp" alt="" class="fr-img">

    <div class="container">
        <div class="footer-main">

            <!-- Logo + Social -->
            <div class="ftr-logo">
                <a href="index.php" class="ftr-add">
                    <img src="img/logos/logo.webp" alt="Atheris Care logo">
                </a>

                <div class="social-media">
                    <a href="#" class="fb-img"><img src="img/icons/fb.png" alt="Facebook"></a>
                    <a href="#"><img src="img/icons/insta.png" alt="Instagram"></a>
                    <a href="#"><img src="img/icons/x.png" alt="X"></a>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="ftr2main">

                <div class="ftrbx1">
                    <h2>Quick Links</h2>
                    <a href="index.php">Home</a>
                    <a href="aboutus.php">About Us</a>
                    <a href="#">Health Monitoring</a>
                    <a href="projects.php">Research Areas</a>
                    <a href="careers.php">Research Approach</a>
                    <a href="connect-us.php">Contact Us</a>
                </div>

                <div class="ftrbx2">
                    <h2>Health Monitoring</h2>
                    <a href="electricals.php">CardioScan</a>
                    <a href="sanitary.php">RespiraScan</a>
                    <a href="plumbing.php">BoneScan</a>
                    <a href="building-materials.php">VisionScan</a>
                    <a href="locks.php">MindScan</a>
                </div>

                <div class="ftrbx3">
                    <h2>Research Areas</h2>
                    <a href="projects.php#pro1">Bone health in microgravity</a>
                    <a href="projects.php#pro2">SANS and vision research</a>
                    <a href="projects.php#pro3">Longitudinal health monitoring</a>
                    <a href="projects.php#pro4">Pre-flight, in-flight and post-flight assessment</a>

                    <p>
                        Project information
                        <a href="tel:Project prototype">Project prototype</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</footer>

<!-- Copyright -->
<div class="copy">
    <div class="container">
        <div class="copyright">
            <h2>© 2026 Atheris Care</h2>
            <h3>
                Original template credit:
                <a href="https://www.tnmonlinesolutions.com/" target="_blank">
                    TNM Online Solutions
                </a>
            </h3>
        </div>
    </div>
</div>


<!--Start Sticky Icon--> 
<div class="sticky-icon">
  <div class="button">

</div>
   <a href="mailto:" class="Google"><img src="img/icons/st3.png"alt=""> Project email </a>
   <a href="tel:" class="Facebook"><img src="img/icons/st2.png"alt=""> Project information </a>
</div>
<!--End Sticky Icon-->

<div class="whatsapp-btn">
    <a href="#"><span><img src="img/icons/st1.png" alt=""></span><h5>Research updates</h5></a>
</div>

<!--popup-->
<div class="modal-overlay" id="joinModal">
    <div class="modal-content animate__animated animate__zoomIn">
        <span class="close-button" id="closeModal">&times;</span>
        <div class="modal-header-form">
            <h2>About Atheris Care <span class="moving-gradient-word"> </span></h2>
            <p style="color: black;">A student research prototype exploring astronaut health monitoring during spaceflight.</p>
        </div>
        <form class="join-form enquiry-form"  action="enquiry_mail.php"
        method="POST">
            <div class="form-group">
                <label for="fullName"><i class="fas fa-user"></i>  Name</label>
                <input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">
                <input type="text" id="fullName" name="fname" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email </label>
                 <!-- <input id="username" type="text" class="hidden-input-field" name="username" value="" autocomplete="false" tabindex="-1"> -->
                     
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            </div>
            <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> Contact number</label>
 <input type="hidden" name="dial_code" class="dial_code" value="+971">
    <input type="tel" name="phone" class="e-input num1 phone numbers " placeholder="Enter your number" required
           onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 43) || (event.charCode == 32)">
  </div>
          
            <div class="form-group">
                <label for="password"><i class="fa fa-map-marker"></i> Location</label>
                     <input type="hidden" name="type" value="rapid_query">
                <input type="text" id="password" name="location" placeholder="Enter your location" required>
            </div>
            <div class="frm-btn">
                <button class="mybtn-secondary">Submit</button>
            </div>
        </form>
    </div>
</div>
<!--popup-->


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
    $('.pdt-carousel').owlCarousel({
        nav: false,
        navText: ["<img src=''>","<img src=''>"],
        loop: true,
        margin: 37,
        dots: true,
        autoplay: true,
        easeIn: 'scrollLeft',
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        autoplaySpeed: 3000,
        responsive: {
            0: { items: 1 },
            767: { items: 1 },
            768: { items: 2 },
            1000: { items: 3 }
        },
        onInitialized: function() {
            AOS.refresh();
        }
    });
});
</script>

<script>
$(".phone").intlTelInput({
    
separateDialCode:false,
initialCountry:"",
preferredCountries: ["uae","ae","sa"  ],

});
</script>

<script>
// Select all modal open buttons
const openModalBtns = document.querySelectorAll('.openModalBtn');
const joinModal = document.getElementById('joinModal');
const closeModal = document.getElementById('closeModal');

// OPEN MODAL
function openJoinModal(e) {
    e.preventDefault();
    joinModal.classList.add('is-visible');
    document.body.style.overflow = 'hidden'; // Disable scroll
}

// CLOSE MODAL
function closeJoinModal() {
    joinModal.classList.remove('is-visible');
    document.body.style.overflow = ''; // Enable scroll
}

// Add click event to all open buttons
openModalBtns.forEach(btn => {
    btn.addEventListener('click', openJoinModal);
});

// Close button click
closeModal.addEventListener('click', closeJoinModal);

// Click outside to close
window.addEventListener('click', event => {
    if (event.target === joinModal) {
        closeJoinModal();
    }
});

// ESC key to close
document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        closeJoinModal();
    }
});
</script>
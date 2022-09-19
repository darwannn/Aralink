/* Remove Confirm Form Resubmission  */
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

/* Index---------------------------------------- */
function removeButtonAni (removeAni) {
    removeAni.classList.remove("enter-animation");
};
function addButtonAni(addAni) {
    addAni.classList.add("enter-animation");
}

/* Account---------------------------------------- */

/* Toggle Password */
function togglePass (toggleCick, selectPassword) {
    const password = document.querySelector('#' + selectPassword);
    let togglePassword = document.querySelector("#" + toggleCick);
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        togglePassword.classList.toggle('fa-eye');
        togglePassword.classList.toggle('fa-eye-slash');
    }

/* Button Loading */
function hidebutton() {
    document.querySelector("#button-hide").style.display = "none";
    document.querySelector("#button-show").style.display = "block";
}

/* Home---------------------------------------- */

/* Navbar */
function navToggler() {
    document.querySelector('#selection').classList.toggle("shrink");
}

/* Store Scroll Position */
document.addEventListener("DOMContentLoaded", function (event) {
    var scrollpos = sessionStorage.getItem('scrollpos');
    if (scrollpos) {
        window.scrollTo(0, scrollpos);
        sessionStorage.removeItem('scrollpos');
    }
});

window.addEventListener("beforeunload", function (e) {
    sessionStorage.setItem('scrollpos', window.scrollY);
});

 /* Copy Class Code */
 $('#copy-code').click(function (e) {
    $('#copied').fadeIn(1000);
    $('#copied').delay(2000).fadeOut(1000);
});

function copy_data(containerid) {
    var range = document.createRange();
    range.selectNode(containerid);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand("copy");
    window.getSelection().removeAllRanges();
}

/* Selection (Owl Carousel) */ 
$('.radio-buttons input[type="radio"]').click(function () {
    var subject = $(this).val();
    $.ajax({
        url: 'php/controller',
        type: 'POST',
        data: {
            subject: subject
        },
        success: function (response) {
            /* Reload div */
            $(".video-show").load(" .video-show > *");
        }
    });
});

$('.owl-carousel').owlCarousel({
    margin: 0,
    loop: false,
    autoWidth: true,
    items: 1,
    nav: true,
    navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"]
});

/* Hides Warning */
/* jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
  }; */
jQuery(document).ready(function() {
    jQuery('#LocationSelect, #CoursesSelect, #ExperienceSelect, #ActivitySelect').select2();
});


jQuery(document).ready(function(){
    jQuery('.programSlider').owlCarousel({
        items: 1, 
        margin: 5,
        smartSpeed: 700,
        loop: true,
        autoplay: false,
        autoplayTimeout: 7000,
        autoplayHoverPause: false,
        nav: true,
        dots: false,
        navText: ["<span class=\"fas fa-chevron-left\"></span>","<span class=\"fas fa-chevron-right\"></span>"],
    });
});

jQuery(document).ready(function(){
    jQuery('.chooseSlider').owlCarousel({
        items: 1, 
        margin: 5,
        smartSpeed: 700,
        loop: true,
        autoplay: true,
        autoplayTimeout: 7000,
        autoplayHoverPause: false,
        nav: false,
        dots: true,
    });
});

jQuery(document).ready(function(){
    jQuery('.aboutSlider').owlCarousel({
        items: 1, 
        margin: 5,
        smartSpeed: 700,
        loop: true,
        autoplay: true,
        autoplayTimeout: 7000,
        autoplayHoverPause: false,
        nav: true,
        dots: false,
        navText: ["<span class=\"fas fa-chevron-left\"></span>","<span class=\"fas fa-chevron-right\"></span>"],
    });
});


jQuery(document).ready(function(){
    jQuery('.gallerySlider').owlCarousel({
        items: 5, 
        margin: 10,
        smartSpeed: 700,
        loop: true,
        autoplay: true,
        autoplayTimeout: 7000,
        autoplayHoverPause: false,
        nav: false,
        dots: false,
        stagePadding: 300,
        navText: ["<span class=\"fas fa-chevron-left\"></span>","<span class=\"fas fa-chevron-right\"></span>"],
        responsive: {
            0: {
                items: 1,
                stagePadding: 50,
            },
            576: {
                items: 1,
                stagePadding: 150,
            },
            767: {
                items: 2,
                stagePadding: 100,
            },
            991: {
                items: 3,
                stagePadding: 100,
            },
            1024: {
                items: 3,
                stagePadding: 120,
            },
            1199: {
                items: 3,
                stagePadding: 150,
            }
        }
    });
});



jQuery(document).ready(function(){
    jQuery('.relatedCities, .relatedschool, .relatedCourses').owlCarousel({
        items: 3,
        margin: 30,
        smartSpeed: 1000,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: false,
        dots: false,
        navText: ["<span class=\"fas fa-chevron-left\"></span>","<span class=\"fas fa-chevron-right\"></span>"],
        responsive: {
            0: {
                items: 1
            },
            767: {
                items: 2
            },
            1024: {
                items: 2
            },
            1100: {
                items: 3
            }
        }
    });
});


document.addEventListener("scroll", function() {
    const header = document.getElementsByClassName("header_wrapper")[0];
    if (window.scrollY > 0) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
});


var swiper = new Swiper('.swiper_country_menu', {
    slidesPerView: 'auto',
    spaceBetween: 30,
    freeMode: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});


jQuery(document).ready(function(){
    jQuery('.schoolImgs').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.schoolNav',
    });

    jQuery('.schoolNav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        asNavFor: '.schoolImgs', 
    });
});


/* Validation JS code */
jQuery(document).ready(function () {
    var forms = jQuery("#contact_us_form form, #contact_us_form2 form");
  
    var submitbtn = jQuery(forms).find("input[type=submit]");
    jQuery(forms).validate({
        rules: {
          'your-name': {
            required: true,
            no_url: true,
            lettersonly: true,
            noSpace: true,
            HtmlTag: true,
          },
          'your-email': {
            required: true,
            no_url: true,
            noSpace: true,
          },
          'your-phone': {
            required: true,
            no_url: true,
            noSpace: true,
            isphone: true,
            HtmlTag: true,
          },
          'your-subject': {
            required: true,
            no_url: true,
            lettersonly: true,
            noSpace: true,
            HtmlTag: true,
          },
          'your-message': {
            no_url: true,
            noSpace: true,
            HtmlTag: true,
          },
          'acceptance-59': {
            // required: true,
          },
        },
        messages: {
          'your-name': {
            required: "Enter your name",
            no_url: "URLs are not allowed in this field.",
            lettersonly: "Enter a valid name.",
            noSpace: "No space please and don't leave it empty",
            HtmlTag: "HTML tags are not allowed",
          },
          'your-email': {
            required: "Enter your email",
            no_url: "URLs are not allowed in this field.",
            noSpace: "No space please and don't leave it empty",
          },
          'your-message': {
            required: "Enter your message",
            no_url: "URLs are not allowed in this field.",
            noSpace: "No space please and don't leave it empty",
            HtmlTag: "HTML tags are not allowed",
          },
          'your-phone': {
            required: "Enter your phone no.",
            no_url: "URLs are not allowed in this field.",
            noSpace: "No space please and don't leave it empty",
            HtmlTag: "HTML tags are not allowed",
          },
          'your-subject': {
            required: "Enter your subject",
            no_url: "URLs are not allowed in this field.",
            noSpace: "No space please and don't leave it empty",
            HtmlTag: "HTML tags are not allowed",
          },
          'acceptance-59': {
            required: "Please accept terms",
          },
        },
        submitHandler: function (form) {
          submitbtn.prop("disabled", true);
        },
      });  
    submitbtn.on("click", function (event) {
      var errors = forms.find(":input.error").length;
      console.log(errors);
  
      if (errors > 0) {
        return false;
      } else {
        document.addEventListener(
          "wpcf7mailsent",
          function (event) {
            var form = event.target;
            if (jQuery(form).is(forms)) {
              setTimeout(function () {
                window.location.href = "/thank-you";
              }, 1000);
            }
          },
          false
        );
      }
    });
  
    // Custom Validation Methods
    var customMethods = {
      no_url: [
        function (value, element) {
          var re =
            /^[a-zA-Z0-9\-\.\:\\]+\.(com|org|net|mil|edu|COM|ORG|NET|MIL|EDU)$/;
          var re1 =
            /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
          var trimmed = jQuery.trim(value);
          if (trimmed === "") {
            return true;
          }
          if (trimmed.match(re) === null && !re1.test(trimmed)) {
            return true;
          }
          return false; // Return false if URL is found
        },
        "URLs are not allowed in this field.",
      ],
  
      lettersonly: [ function (value, element) { return this.optional(element) || /^[a-zA-Z\s]+$/.test(value); }, "Enter a valid name.", ],
      noSpace: [ function (value, element) { return value === "" || value.trim().length !== 0; }, "No space please and don't leave it empty", ],
      HtmlTag: [ function (value, element) { return this.optional(element) || !/<[^>]*>/g.test(value); }, "HTML tags are not allowed.", ],
      isphone: [ function (value, element) { return this.optional(element) || /^[0-9\-\+\(\)\s]+$/.test(value); }, "Enter a valid phone number.", ],
    };
  
    jQuery.each(customMethods, function (name, params) {
      jQuery.validator.addMethod(name, params[0], params[1]);
    });
  });
  
  jQuery(document).ready(function ($) {
    // Check if the user is logged in using the localized data
  
    if (userData.isLoggedIn) {
      $("li.menu_login").remove();
    } else {
      $("li.menu_my_account").remove();
    }
  });
!(function ($) {
  "use strict";
  let $window = $(window);
  var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

  var isMobile = {
    Android: function () {
      return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
      return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
      return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
      return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
      return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
      return (
        isMobile.Android() ||
        isMobile.BlackBerry() ||
        isMobile.iOS() ||
        isMobile.Opera() ||
        isMobile.Windows()
      );
    },
  };

  //PAGE LOADER
  $(window).on("load", function () {
    "use strict";
    $(".loader").fadeOut(800);
    $(".side-menu").removeClass("opacity-0");
  });
  $(window).on("load", function () {
    $("#filter-form-hideable_link").on("click", function () {
      $("body").find("#filter-form-hideable").slideToggle("slow");
      return false;
    });
  });

  $(".announcements-slider").slick({
    infinite: true,
    speed: 1500,
    slidesToShow: 1,
    arrows: true,
    prevArrow:
      '<div class="carousel-slider-left"><i class="icon feather icon-chevron-left"></i></div>',
    nextArrow:
      '<div class="carousel-slider-right"><i class="icon feather icon-chevron-right"></i></div>',
    autoplay: true,
    dots: false,
    useTransform: true,
    autoplaySpeed: 4000,
    // adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 600,
        settings: {
          autoplay: false,
        },
      },
    ],
  });

  activatePopup();
  eventPopup();
  studentPopup();
  //custom code here
  /*------ Sticky MENU Fixed ------*/
  // let headerHeight = $("header").outerHeight();
  // let navbar = $("nav.navbar");
  // if (navbar.not('.fixed-bottom').hasClass("static-nav")) {
  //     $window.scroll(function () {
  //         let $scroll = $window.scrollTop();
  //         let $navbar = $(".static-nav");
  //         let nextSection = $(".section-nav-smooth");
  //         if ($scroll > 400) {
  //             $navbar.addClass("fixedmenu");
  //             nextSection.css("margin-top", headerHeight);
  //         } else {
  //             $navbar.removeClass("fixedmenu");
  //             nextSection.css("margin-top", 0);
  //         }
  //         if ($scroll > 125) {
  //             $('.header-with-topbar nav').addClass('mt-0');
  //         } else {
  //             $('.header-with-topbar nav').removeClass('mt-0');
  //         }
  //     });
  //     $(function () {
  //         if ($window.scrollTop() >= $(window).height()) {
  //             $(".static-nav").addClass('fixedmenu');
  //         }
  //     })
  // }
  // call our plugin
  const wg_menu_image = document.createElement("img");
  wg_menu_image.setAttribute("src", ajaxObj.mobileLogo);
  var logoLink = document.createElement("a");
  logoLink.setAttribute("href", ajaxObj.HomeURL);
  logoLink.setAttribute("class", "sidebar-custom-logo-link");
  logoLink.append(wg_menu_image);
  $("#main-nav").hcOffcanvasNav({
    disableAt: 991,
    customToggle: $("#menu-icon"),
    levelOpen: "overlap",
    navTitle: logoLink,
    closeOnClick: false,
    levelSpacing: 0,
    insertBack: true,
    levelTitles: true,
    labelBack: "",
    levelTitleAsBack: "",
  });

  /*Menu Onclick*/
  let sideMenuToggle = $("#sidemenu_toggle");
  let sideMenu = $(".side-menu");
  if (sideMenuToggle.length) {
    sideMenuToggle.on("click", function () {
      $("body").addClass("overflow-hidden");
      sideMenu.addClass("side-menu-active");
      $(function () {
        setTimeout(function () {
          $("#close_side_menu").fadeIn(300);
        }, 300);
      });
    });
    $("#close_side_menu , #btn_sideNavClose , .side-nav .nav-link").on(
      "click",
      function () {
        $("body").removeClass("overflow-hidden");
        sideMenu.removeClass("side-menu-active");
        $("#close_side_menu").fadeOut(200);
        $(() => {
          setTimeout(() => {
            $(".sideNavPages").removeClass("show");
            $(".fas").removeClass("rotate-180");
          }, 400);
        });
      }
    );
    $(document).keyup((e) => {
      if (e.keyCode === 27) {
        // escape key maps to keycode `27`
        if (sideMenu.hasClass("side-menu-active")) {
          $("body").removeClass("overflow-hidden");
          sideMenu.removeClass("side-menu-active");
          $("#close_side_menu").fadeOut(200);
        }
      }
    });
  }

  /*
   * Side menu collapse opener
   * */
  $(".collapsePagesSideMenu").on("click", function () {
    $(this).children().toggleClass("rotate-180");
  });

  // Add active state to sidebar nav links

  let loggedin = document.body.classList.contains("logged-in");
  if (loggedin == true) {
    const sidebarToggle = document.body.querySelector("#sidebarToggle");
    const menu_icon = document.body.querySelector("#menu-icon");
    if (sidebarToggle) {
      // Uncomment Below to persist sidebar toggle between refreshes
      // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
      //     document.body.classList.toggle('sidenav-toggled');
      // }
      sidebarToggle.addEventListener("click", (event) => {
        event.preventDefault();
        // document.body.classList.toggle('sidenav-toggled');
        menu_icon.classList.toggle("icon-x-square");
        localStorage.setItem(
          "sb|sidebar-toggle",
          document.body.classList.contains("sidenav-toggled")
        );
      });
    }

    let activatedPath = window.location.href;

    if (activatedPath === base_url + "dashboard/") {
      activatedPath = base_url;
    }

    const targetAnchors = document.body.querySelectorAll(
      '[href="' + activatedPath + '"].nav-link '
    );
    targetAnchors.forEach((targetAnchor) => {
      let parentNode = targetAnchor.parentNode;
      while (parentNode !== null && parentNode !== document.documentElement) {
        if (parentNode.classList.contains("collapse")) {
          parentNode.classList.add("show");

          const parentNavLink = document.body.querySelector(
            '[data-bs-target="#' + parentNode.id + '"]'
          );
          parentNavLink.classList.remove("collapsed");
          parentNavLink.classList.add("active");
        }
        parentNode = parentNode.parentNode;
      }
      targetAnchor.classList.add("active");
    });
  }

  function activatePopup() {
    $(".ajax-popup").each(function (e) {
      e.preventDefault;
      $(this).magnificPopup({
        type: "ajax",
        removalDelay: 500,
        // mainClass: "mfp-fade mfp-zoom-in",
        closeOnBgClick: true,
        preloader: true,
        tLoading: "loading...",
        callbacks: {
          open: function () {
            jQuery("body").addClass("noscroll");
          },
          close: function () {
            jQuery("body").removeClass("noscroll");
          },
        },
      });
    });
  }
  function eventPopup() {
    $(".popup-link").each(function (e) {
      e.preventDefault;
      $(this).magnificPopup({
        type: "ajax",
        removalDelay: 500,
        preloader: true,
        tLoading: "loading...",
        callbacks: {
          beforeOpen: function () {
            this.st.mainClass = this.st.el.attr("data-effect");
          },
        },
      });
    });
  }

  function studentPopup() {
    $(".student-link").each(function (e) {
      e.preventDefault;
      $(this).magnificPopup({
        type: "ajax",
        removalDelay: 500,
        preloader: true,
        tLoading: "loading...",
        callbacks: {
          beforeOpen: function () {
            this.st.mainClass = this.st.el.attr("data-effect");
          },
          change: function () {
            let title = this.st.el.attr("data-title");
            let email = this.st.el.attr("data-email");
            jQuery("body .mfp-move-from-right .student_ajax_body h4").html(
              title
            );
            jQuery("body .mfp-move-from-right .student_ajax_body p").html(
              email
            );
            console.log(this.st.mainClass);
          },
        },
      });
    });
  }

  //On input focus move the label
  $("input, textarea").focus(function () {
    $(this).parent().siblings("label").addClass("move");
  });

  //On focusout check if there is a value, else remove the .move class.
  $("input, textarea").focusout(function () {
    if ($(this).val().length == 0) {
      $(this).parent().siblings("label").removeClass("move");
    }
  });

  //If the user clicks on the label itself, activate the corresponding input.
  // var labelID;
  // $('label').click(function () {
  // labelID = $(this).attr('for');
  // $('#' + labelID).trigger('click');
  // });

  //In case there is a prefill value
  $("input, textarea").each(function () {
    if ($(this).val().length != 0) {
      $(this).parent().siblings("label").addClass("move");
    } else {
      $(this).parent().siblings("label").removeClass("move");
    }
  });

  $("body").on("click", "#make_course_request", function (t) {
    t.preventDefault(),
      $("#make_course_request").hide(),
      $(".course-request-form-wrapper").fadeIn().css("display", "block");
  });

  $("body").on("click", "#change_course_cancel", function (t) {
    t.preventDefault(),
      $("#make_course_request").show(),
      $(".course-request-form-wrapper").hide();
  });

  $("body").on("click", "#make_instructor_request", function (t) {
    t.preventDefault(),
      $("#make_instructor_request").hide(),
      $(".instructor-request-form-wrapper").fadeIn().css("display", "block");
  });

  $("body").on("click", "#change_instructor_cancel", function (t) {
    t.preventDefault(),
      $("#make_instructor_request").show(),
      $(".instructor-request-form-wrapper").hide();
  });

  ///var your_reason_for_instructor = $('#your_reason_for_instructor');
  let oldCourseValue = "";
  let oldInstructorValue = "";

  $("body").on("change paste keyup", "#your_reason_for_course", function () {
    var currentVal = $(this).val();
    if (currentVal == oldCourseValue) {
      return; //check to prevent multiple simultaneous triggers
    }
    oldCourseValue = currentVal;
    //action to be performed on textarea changed
    if (currentVal === "") {
      $('button[name="change_course"]').addClass("disabled");
    } else {
      $('button[name="change_course"]').removeClass("disabled");
    }
  });

  $("body").on(
    "change paste keyup",
    "#your_reason_for_instructor",
    function () {
      var currentVal = $(this).val();
      if (currentVal == oldInstructorValue) {
        return; //check to prevent multiple simultaneous triggers
      }
      oldInstructorValue = currentVal;
      //action to be performed on textarea changed
      if (currentVal === "") {
        $('button[name="change_instructor"]').addClass("disabled");
      } else {
        $('button[name="change_instructor"]').removeClass("disabled");
      }
    }
  );

  document.addEventListener("DOMContentLoaded", function () {
    // make it as accordion for smaller screens
    if (window.innerWidth > 992) {
      document
        .querySelectorAll(".navbar .nav-item")
        .forEach(function (everyitem) {
          everyitem.addEventListener("mouseover", function (e) {
            let el_link = this.querySelector("a[data-bs-toggle]");

            if (el_link != null) {
              let nextEl = el_link.nextElementSibling;
              el_link.classList.add("show");
              nextEl.classList.add("show");
            }
          });
          everyitem.addEventListener("mouseleave", function (e) {
            let el_link = this.querySelector("a[data-bs-toggle]");

            if (el_link != null) {
              let nextEl = el_link.nextElementSibling;
              el_link.classList.remove("show");
              nextEl.classList.remove("show");
            }
          });
        });
    }
    // end if innerWidth
  });
  // DOMContentLoaded  end
  function set_heights() {
    var divHeight = $("header").height();
    $(".landing-page-full-height").css({
      height: `calc(100vh - ${divHeight}px)`,
    });
  }
  function set_course_progress_box_heights() {
    var divHeight = $(".get-height-box").height();
    $(".dashboard-course-progress-box").css({ height: `${divHeight}px` });
  }
  var windowsize = $window.width();
  if (windowsize > 767) {
    //if the window is greater than 440px wide then turn on jScrollPane..
    set_course_progress_box_heights();
  }

  set_heights();
  $(window).resize(function () {
    if (windowsize > 767) {
      //if the window is greater than 440px wide then turn on jScrollPane..
      set_course_progress_box_heights();
    }
  });
  if (!isMobile.any()) {
    $(window).resize(function () {
      set_heights();
      set_width_contact_popup();
    });
    set_width_contact_popup();
  }
  if (isMobile.any()) {
    $(".user-profile-menu-wrapper .navbar-nav .dropdown").click(function (e) {
      var dropdownMenu = $(this).children(".dropdown-menu");
      dropdownMenu.toggleClass("open");
    });
  }

  function set_width_contact_popup() {
    var divWidth = $("#layoutSidenav_nav").width();
    $("#contactModalToggle").css({ width: `calc(100% + ${divWidth}px)` });
    console.log("test");
  }

  $(".custom-select").each(function () {
    var classes = $(this).attr("class"),
      id = $(this).attr("id"),
      selectionClass = "",
      name = $(this).attr("name");
    var template = '<div class="' + classes + '">';
    template +=
      '<span class="custom-select-trigger"><img src="' +
      $(this).find("option:selected").data("src") +
      '"/></span>';
    template += '<div class="custom-options">';
    $(this)
      .find("option")
      .each(function () {
        var selectedAttr = $(this).attr("selected");
        if (typeof selectedAttr !== "undefined" && selectedAttr !== false) {
          selectionClass = "selection";
        } else {
          selectionClass = "";
        }
        template +=
          '<span class="custom-option ' +
          selectionClass +
          " " +
          $(this).attr("class") +
          '" data-value="' +
          $(this).attr("value") +
          '"><img src="' +
          $(this).data("src") +
          '" alt="' +
          $(this).html() +
          '"/>' +
          $(this).html() +
          "</span>";
      });
    template += "</div></div>";

    $(this).wrap('<div class="custom-select-wrapper"></div>');
    $(this).hide();
    $(this).after(template);
  });
  $(".custom-option:first-of-type").hover(
    function () {
      $(this).parents(".custom-options").addClass("option-hover");
    },
    function () {
      $(this).parents(".custom-options").removeClass("option-hover");
    }
  );
  $(".custom-select-trigger").on("click", function () {
    $("html").one("click", function () {
      $(".custom-select").removeClass("opened");
    });
    $(this).parents(".custom-select").toggleClass("opened");
    event.stopPropagation();
  });
  $(".custom-option").on("click", function () {
    $(this)
      .parents(".custom-select-wrapper")
      .find("select")
      .val($(this).data("value"));
    $(this)
      .parents(".custom-options")
      .find(".custom-option")
      .removeClass("selection");
    $(this).addClass("selection");
    $(this).parents(".custom-select").removeClass("opened");
    $(this)
      .parents(".custom-select")
      .find(".custom-select-trigger")
      .html(
        '<img src="' +
          $(this).find("img").attr("src") +
          '" alt="' +
          $(this).text() +
          '"/>'
      );
  });

  $(".magnific-popup").magnificPopup({
    type: "iframe",
    iframe: {
      markup:
        '<div class="mfp-iframe-scaler">' +
        '<div class="mfp-close"></div>' +
        '<iframe class="mfp-iframe" frameborder="0" allow="autoplay;" allowfullscreen></iframe>' +
        "</div>", // HTML markup of popup, `mfp-close` will be replaced by the close button

      patterns: {
        youtube: {
          index: "youtube.com/", // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

          id: "v=", // String that splits URL in a two parts, second part should be %id%
          // Or null - full URL will be returned
          // Or a function that should return %id%, for example:
          // id: function(url) { return 'parsed id'; }

          src: "//www.youtube.com/embed/%id%?autoplay=1", // URL that will be set as a source for iframe.
        },
        vimeo: {
          index: "vimeo.com/",
          id: "/",
          src: "//player.vimeo.com/video/%id%?autoplay=1",
        },
        gmaps: {
          index: "//maps.google.",
          src: "%id%&output=embed",
        },

        // you may add here more sources
      },

      srcAction: "iframe_src", // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".
    },
  });
  $("#instructor_msg_submit").on("submit", function (e) {
    e.preventDefault();
    if (jQuery("#subject").val() == "" || jQuery("#message").val() == "") {
      if ($("#subject").val() === "") {
        jQuery("#subject").addClass("border border-danger");
      }
      if ($("#message").val() === "") {
        jQuery("#message").addClass("border border-danger");
      }
    } else {
      var data = {
        action: "rp_send_message",
        name: $("#student_name").val(),
        subject: $("#subject").val(),
        email: $("#email_to").val(),
        ins_id: $("#instructor_id").val(),
        student_email: $("#student_email").val(),
        message: $("#message").val(),
        nonce: ajaxObj.nonce,
      };

      $.ajax({
        url: ajaxObj.ajaxurl,
        method: "POST",
        data: data,
        beforeSend: function (response) {
          jQuery("#instructor_msg_submit").addClass("submitting");
          jQuery(".error-handling-msg-box").hide();
        },
        success: function (data) {
          alert("Message Sent Successfully!");
          $("#subject").val("");
          $("#message").val("");
        },
        error: function (errorThrown) {
          console.log(errorThrown);
        },
      });
    }
  });
  jQuery("#subject").keyup(function () {
    jQuery(this).removeClass("border border-danger");
  });
  jQuery("#message").keyup(function () {
    jQuery(this).removeClass("border border-danger");
  });

  $('button[data-bs-toggle="pill"]').on("shown.bs.tab", function (e) {
    var target = this.href.split("#");
    $(".nav a")
      .filter('[href="#' + target[1] + '"]')
      .tab("show");
  });

  $(".change-password-table-wrapper, .custom_form_login")
    .find(".form-control")
    .each(function (index, input) {
      var $input = $(input);
      $input
        .parent()
        .find(".password-visibility")
        .click(function () {
          var change = "";
          if ($(this).find("i").hasClass("fa-eye")) {
            $(this).find("i").removeClass("fa-eye");
            $(this).find("i").addClass("fa-eye-slash");
            change = "text";
          } else {
            $(this).find("i").removeClass("fa-eye-slash");
            $(this).find("i").addClass("fa-eye");
            change = "password";
          }

          // var rep = $("<input type='" + change + "' required/>")
          // 	.attr('id', $input.attr('id'))
          // 	.attr('name', $input.attr('name'))
          // 	.attr('placeholder', $input.attr('placeholder'))
          // 	.attr('class', $input.attr('class'))
          // 	.val($input.val())
          // 	.insertBefore($input);

          $(this).parent().find("input").attr("type", change);

          //$input.remove();
          //$input = rep;
        });
    });

  function checkPasswordStrength(
    $pass1,
    $pass2,
    $strengthResult,
    $submitButton,
    blacklistArray,
    $curr
  ) {
    var pass1 = $pass1.val();
    var pass2 = $pass2.val();

    console.log(pass1, pass2);

    // Reset the form & meter
    $submitButton.attr("disabled", "disabled");
    $strengthResult.removeClass("short bad good strong");

    // Extend our blacklist array with those from the inputs & site data
    blacklistArray = blacklistArray.concat(
      wp.passwordStrength.userInputDisallowedList()
    );

    //console.log(blacklistArray, "arrayblacklist");
    // Get the password strength
    var strength = wp.passwordStrength.meter(pass1, blacklistArray, pass2);

    // Add the strength meter results
    //strength = $pass1;

    switch (strength) {
      case 2:
        $strengthResult
          .addClass("bad")
          .html("Very weak - Please enter a stronger password.");
        $strengthResult.removeClass("empty");
        break;

      case 3:
        $strengthResult.addClass("good").html(pwsL10n.good);
        $strengthResult.removeClass("empty");
        break;

      case 4:
        $strengthResult.addClass("strong").html(pwsL10n.strong);
        $strengthResult.removeClass("empty");
        break;

      case 5:
        $strengthResult.addClass("short").html(pwsL10n.mismatch);
        $strengthResult.removeClass("empty");
        break;

      default:
        $strengthResult
          .addClass("short")
          .html("Very weak - Please enter a stronger password.");
        $strengthResult.removeClass("empty");
    }

    if (pass1 == "" && pass2 == "") {
      $strengthResult.addClass("empty").html("&nbsp;");
    }

    // The meter function returns a result even if pass2 is empty,
    // enable only the submit button if the password is strong and
    // both passwords are filled up
    if (4 >= strength && pass2 !== "") {
      $submitButton.removeAttr("disabled");
    }

    return strength;
  }

  // Binding to trigger checkPasswordStrength
  $("body").on(
    "keyup",
    "input[name=new_password], input[name=confirm_password]",
    function (event) {
      var curr = $(this).attr("data-main");
      checkPasswordStrength(
        $(curr + " input[name=new_password]"), // First password field
        $(curr + " input[name=confirm_password]"), // Second password field
        $("#password-strength"), // Strength meter
        $("button[type=submit]"), // Submit button
        ["black", "listed", "word"] // Blacklisted words
      );
    }
  );

  const inputs = document.querySelectorAll(".form-control");

  inputs.forEach((input) => {
    input.addEventListener("input", function handleClick(event) {
      input.value = input.value ? input.value.trimStart() : "";
    });
  });

  $(".report_input").each(function () {
    $(this).change(function () {
      var max = parseInt($(this).attr("max"));
      var min = parseInt($(this).attr("min"));
      if ($(this).val() > max) {
        $(this).val(max);
      } else if ($(this).val() < min) {
        $(this).val(min);
      }
    });
  });

  /*activate/deactivate user by instructor*/
  $("#user_act_deact_btn").on("click", function (e) {
    e.preventDefault();
    var user_id = $(this).attr("data_id");
    var user_status = $(this).attr("data_status");
    jQuery.ajax({
      url: ajaxObj.ajaxurl,
      data: {
        action: "activate_deactivate_user",
        user_id: user_id,
        user_status: user_status,
      },
      beforeSend: function (xhr) {
        $(".ajax-loading").addClass("active");
      },
      success: function (data) {
        $(".ajax-loading").removeClass("active");
        $("#user_act_deact_btn").attr("data_status", data);
        if (data == "approved") {
          $("#user_act_deact_btn").text("Deactivate");
        }
        if (data == "decline") {
          $("#user_act_deact_btn").text("Activate");
        }
      },
      error: function (errorThrown) {
        console.log(errorThrown);
        console.log("fail");
      },
    });
  });
  if (isMobile.any()) {
    $(".summary-section-wrapper").hide();
    $(".hide-show-btn a").on("click", function (e) {
      e.preventDefault();
      if ($(".summary-section-wrapper").is(":hidden")) {
        $(".summary-section-wrapper").slideDown("slow");
        $(this).text("(Collapse)");
      } else {
        $(".summary-section-wrapper").slideUp("slow");
        $(this).text("(Expand)");
      }
      return false;
    });
  }
  /*resources video preview*/
  window.addEventListener("load", (event) => {
    let media_btn = document.querySelectorAll(".media_btn img");
    if (media_btn) {
      media_btn.forEach((cc) => {
        cc.addEventListener("click", function (e) {
          let video_box = cc.closest(".media").nextElementSibling;
          if (video_box) {
            video_box.classList.toggle("video_file_show");
          }
        });
      });
    }
  });

  $(document).on("click", ".update_status", function (e) {
    e.preventDefault();
    let $this = jQuery(this);
    let htmlval = $this.html();
    var data = {
      action: "save_update_status_info",
      user: jQuery(this).attr("data-sid"),
      status: jQuery(this).attr("data-status"),
    };

    var currentstatus = jQuery(this).attr("data-status");
    var $newstatus = "activate";
    if (currentstatus == "activate") {
      $newstatus = "deactivate";
    } else {
      $newstatus = "activate";
    }

    $.confirm({
      title:
        "Are you sure you want to " + htmlval.toLowerCase() + " this student?",
      content: "",
      icon: "fas fa-exclamation-triangle",
      theme: "modern",
      closeIcon: true,
      closeAnimation: "scale",
      opacity: 1,
      buttons: {
        confirm: {
          text: "Confirm ",
          btnClass: "btn-red",
          action: function () {
            $this.html("Saving...");
            let newval = "Activate";
            if (htmlval == "Deactivate") {
              newval = "Activate";
            } else {
              newval = "Deactivate";
            }
            jQuery.ajax({
              url: ajaxObj.ajaxurl,
              method: "POST",
              data: data,
              success: function (data) {
                $this.html(newval);
                $this.attr("data-status", $newstatus);
                const myTimeout = setTimeout(function () {
                  $this.html(newval);

                  if (newval == "Activate") {
                    $this.removeClass("btn-danger").addClass("btn-success");
                  } else {
                    $this.removeClass("btn-success").addClass("btn-danger");
                  }
                }, 2000);
              },
              error: function (errorThrown) {
                console.log(errorThrown);
              },
            });
          },
        },
        cancel: {
          text: "Cancel ",
          action: function () {},
        },
      },
    });
  });

  //  back-to-top
  const backToTop = document.querySelector(".backtotop");

  window.addEventListener("scroll", () => {
    if (window.scrollY > 500) {
      backToTop.classList.add("backtotop-active");
    } else {
      backToTop.classList.remove("backtotop-active");
    }
  });

  $(".open-popup-link").on("click", function (e) {
    e.preventDefault();
    $.magnificPopup.close();
    var _this = $(this);
    setTimeout(function () {
      $.magnificPopup.open({
        items: {
          src: _this.attr("href"),
          type: "image",
        },
        closeOnContentClick: true,
        image: {
          verticalFit: true,
        },
      });
    }, 500);
  });
  // Fancybox.bind("data-fancybox='videopop']", {
  // 	afterLoad : function( instance, current ) {

  // 		// Remove scrollbars and change background
  // 	   current.$content.css({
  // 			   overflow   : 'visible',
  // 			 background : '#000'
  // 		   });

  // 	 },
  // 	 onUpdate : function( instance, current ) {
  // 	   var width,
  // 		   height,
  // 		   ratio = 16 / 9,
  // 		   video = current.$content;

  // 	   if ( video ) {
  // 		 video.hide();

  // 		 width  = current.$slide.width();
  // 		 height = current.$slide.height() - 100;

  // 		 if ( height * ratio > width ) {
  // 		   height = width / ratio;
  // 		 } else {
  // 		   width = height * ratio;
  // 		 }

  // 		 video.css({
  // 		   width  : width,
  // 		   height : height
  // 		 }).show();

  // 	   }
  // 	 }
  //   });

  let category_tag = document.querySelector(".wel a");

  if (category_tag) {
    category_tag.href = "javascript:void(0)";
  }

  var open_btn = document.querySelectorAll(".btn-default");
  var open_btn_array = Array.from(open_btn);
  console.log(open_btn_array);
  open_btn_array.map((button) => {
    button.addEventListener("click", () => {
      setTimeout(() => {
        var modal_close = document.querySelector(".modal-footer button");
        modal_close.addEventListener("click", () => {
          var modal = document.querySelector("#__bootModal");
          modal.style.display = "none";
          document.body.classList.remove("modal-open");
          var modal_back = document.querySelector(".modal-backdrop");
          modal_back.remove();
          document.body.style.overflow = "scroll";
          // console.log(modal);
        });
      }, 2000);
    });
  });

  jQuery(document).ready(function() {
    
    /*export search filter report*/
    jQuery(document).on('click','#download_instructor_student', function()
    {
      let $this = jQuery(this);
      let uid = $this.attr('data-uid'); 
      // alert("button is pressed and instructor id is "+uid);
        jQuery(this).html('Downloading...');
        var data = {
            'action': 'ngondro_gar_instructor_student_download',
            'id' : uid,
        };

        jQuery.post(ajaxObj.ajaxurl, data, function(response) {
          // console.log(response);
            $this.html("Export");
        //     jQuery('.export_user_link a').attr("href",response);
            window.open(
                window.location.href=response,
                '_blank' 
            );

        });

    })

});
})(jQuery);

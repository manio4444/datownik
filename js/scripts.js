$(function() {


  $("[href]").each(function() {
    if (this.href == window.location.href) $(this).addClass("activeUrl");
  });


  $(".hamburger, .hamburger_close").click(function() {
    $('body').toggleClass("nav_open");
  });

  $(document).on('click', '', function(event) {
    var target = $(event.target);
    if (
      $('body').hasClass("nav_open")
      && target.closest('header').length === 0
      && target.closest('.hamburger').length === 0
    ) {
      $('body').removeClass("nav_open");
    }
  });

  $('.dropdown').dropdown();

  Flatpickr.l10ns.default.firstDayOfWeek = 1; // Monday
  $(".flatpickr").flatpickr({
    enableTime:true,
    locale: 'pl',
    altInput: true,
    altFormat: "j F Y, H:i",
    time_24hr: true,
  });

  // Flatpickr.l10ns.default.firstDayOfWeek = 1; // Monday
  $(".flatpickr-dateonly").flatpickr({
    // enableTime:true,
    locale: 'pl',
    altInput: true,
    altFormat: "j F Y",
    time_24hr: true,
  });


  $('.checkbox_switcher').change(function() {
    var nodes = document.querySelectorAll('.reszta');
    if (document.querySelector('.reszta').style.display === 'inline-block') {
      for (var i = 0; i < nodes.length; i++) {
        nodes[i].style.display = 'none';
      }
    } else {
      for (var i = 0; i < nodes.length; i++) {
        nodes[i].style.display = 'inline-block';
      }
    }
  });


}); //end document ready

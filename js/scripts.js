$(function() {


  $("[href]").each(function() {
    if (this.href == window.location.href) $(this).addClass("active");
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

  // timer();
  var tasksCounter = setInterval(timer, 1000); //1000 will  run it every 1 second

  $('[data-task-check]').click(function() {
  });

  $('[data-task-details]').click(function() {
    var task = $(this).parents('[data-task]');
    if (task.length>0 && task.hasClass('details_open')) {
      task.find('.field.disabled').slideUp();
      task.removeClass('details_open');
    } else if (task.length>0) {
      task.find('.field.disabled').slideDown();
      task.addClass('details_open');
    }
  });


}); //end document ready

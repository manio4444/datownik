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

  $('[data-task-deadlock]').click(function() {
    var task = $(this).parents('[data-task]');
    var deadlocker = task.find('[name="no_deadline"]');
    var field_deadline = task.find('.field.deadline');

    if (!deadlocker) {
      return;
    }

    if (deadlocker.val() === '1') {
      deadlocker.val(0);
      field_deadline.removeClass('no-deadline');
    } else {
      deadlocker.val(1);
      field_deadline.addClass('no-deadline');
    }
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

  $('[data-task-save]').click(function() {
    var task = $(this).parents('[data-task]');
    var deadlocker = task.find('[name="no_deadline"]');

    console.log('######### SAVE #########');


  });

}); //end document ready

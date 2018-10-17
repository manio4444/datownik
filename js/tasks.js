$(function() {


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
    var task = $(this).closest('[data-task]');
    var deadlocker = task.find('[name="no_deadline"]');

    console.log('######### SAVE #########');

    task.submit();

  });

  $('[data-task-delete]').click(function() {

    var deleteContainer = $(this).closest('.field.delete');
    var task = $(this).closest('[data-task]');
    var id = task.attr('[data-task]');

    deleteContainer.addClass('loading');

    $.ajax({
      url: '?ajax_action=tasksAjax',
      method: 'POST',
      data: {
        operation   :'delTask',
        id          : id,
      }
    }).done(function(data) {

      deleteContainer.removeClass('loading');

      if (data.data.status !== 200) {
        console.log(data);
        return;
      }

      // TODO tutaj usuwanie

    });

  });

  var tasksModal = $('.ui.modal')
  tasksModal.modal();

  $('[data-task-done]').click(function(ev) {
    var task = $(this).closest('[data-task]');
    ev.preventDefault();
    tasksModal.find('.tasks__modal_content').text(task.find('.content .header').text());
    tasksModal.modal({
      onApprove: function () {
        $.ajax({
          url: '?ajax_action=tasksAjax',
          method: 'POST',
          data: {
            operation   :'doneTask',
            id          : task.data('id'),
          }
        }).done(function(data) {

          console.log(data);




          if (data.data.status !== 200) {
            console.log(data);
            return;
          }

        });
      },
      onDeny: function () {
      }
    });
    tasksModal.modal('show');
  });


}); //end document ready

function ajax_notes_send(note_operation, this_note) {
  $.ajax({
    type: 'post',
    data: {
      'note_ajax': true,
      'note_id': this_note.attr('data-note'),
      'note_txt': this_note.val(),
      'note_operation': note_operation,
     },
     dataType : 'text',
     success: function(data){
       if ($.isNumeric(data)) {
         this_note.attr('data-note', data);
         console.log('Nowy wpis numer: '+data);
       } else if (data=='deleted') {
         this_note.parents('.note_element').remove();
         console.log('Usunięto wpis numer: '+this_note.attr('data-note'));
       } else if (data=='edit') {
         console.log('Edytowano wpis numer: '+this_note.attr('data-note'));
       } else console.log(data);
     }
  });
}

function notesListener(this_note) {
  $(this_note).off('input'); //najpierw usuwa listenery
  $(this_note).on('input', function() {
    if ($(this).val()) {
      if (!$(this).attr('data-note')) {
        $(this).parents('.note_element').parent().prepend(new_note);
        // $('#notepad').prepend(new_note);
        $(this).attr('data-note', 'waiting');
        ajax_notes_send('note_new', $(this));
        notesListener(this_note);
      }
      // console.log($(this));
      ajax_notes_send('note_edit', $(this));
    }
  });

  $(this_note).off('focusout'); //najpierw usuwa listenery
  $(this_note).focusout(function() {
    console.log('focusout: '+$(this).attr('data-note'));

    if (!$(this).val() && $(this).attr('data-note')) {
      console.log('Wysłano prośbę o usunięcie wpisu: '+$(this).attr('data-note'));
      ajax_notes_send('note_delete', $(this));
    }
  });

} //function notesListener

var new_note = $('.note_element').outerHTML(); //dodanie do zmiennej czystej notatki w html

notesListener( '.note_element textarea' ); //pierwsze uruchomienie

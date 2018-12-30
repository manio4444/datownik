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
       } else console.log(data); //TODO - przy nowym wpisie backend nic nie zwraca
     }
  });
}


var notes = {

  parentContainer: '.notes_container',
  elementContainer: '.note_element textarea',
  newElementHTML: '',
  objInstanceFired: false,
  debug: false,

  create: function (note) {

    let $note = $(note);

    $(this.parentContainer).prepend(this.newElementHTML);
    $note.attr('data-note', 'waiting');
    ajax_notes_send('note_new', $note);

  },

  delete: function (note) {

  },


  edit: function (note) {

    let $note = $(note);

    ajax_notes_send('note_edit', $note);

  },

  listenerInput: function (note) {

    let $note = $(note);

    if ($note.length === 0) {
      console.error('Note do not exist');
      return;
    }

    if (!$note.val()) {
      if (this.debug) console.warn('Note has no text, request blocked');
      return;
    }

    if (!$note.attr('data-note')) {

      this.create($note);

    } else {

      this.edit($note);

    }

  },

  listenerfocusOut: function (note) {

    let $note = $(note);

    if (this.debug) console.log('listenerfocusOut: '+$note.attr('data-note'));


    if (!$note.val() && $note.attr('data-note')) {
      if (this.debug) console.log('Wysłano prośbę o usunięcie wpisu: '+$note.attr('data-note'));
      ajax_notes_send('note_delete', $note);
    }

  },

  init: function() {

    if (this.objInstanceFired === true) {
      console.warn('object instance was fired before');
      return;
    } else {
      this.objInstanceFired = true;
      if (this.debug) console.info('object instance fired properly');
    }

    this.newElementHTML = $('.note_element').outerHTML();

    $(this.parentContainer).on('input', this.elementContainer, (event) => {
      let note = event.currentTarget;
      this.listenerInput(note);
    });

    $(this.parentContainer).on('focusout', this.elementContainer, (event) => {
      let note = event.currentTarget;
      this.listenerfocusOut(note);
    });

  },

}

$(function() {

  /*
  * Input event
  */
  notes.init();


  /*
  * Search event
  */
  $('[data-note-search]').on('input', function() {
    var input = $(this);
    $('.note_element textarea').each(function() {
      var noteDiv = $(this).closest('.note_element');
      if (input.val() === '') {
        noteDiv.show();
      } else if ($(this).text().toLowerCase().indexOf(input.val().toLowerCase()) !== -1) {
        noteDiv.show();
      } else {
        noteDiv.hide();
      }
    });
  });

}); //end document ready

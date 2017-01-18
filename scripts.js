$(document).ready(function() {


$("[href]").each(function() {
if (this.href == window.location.href) $(this).addClass("active");
});


$('.dropdown').dropdown();

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


$.fn.outerHTML = function() {  return (this[0]) ? this[0].outerHTML : '';  };

function ajax_notes_send(this_note, note_delete) {
  $.ajax({
    type: 'post',
    data: {
      'note_ajax': true,
      'note_id': this_note.attr('data-note'),
      'note_txt': this_note.val(),
      'note_delete': note_delete,
     },
     dataType : 'text',
     success: function(data){
       if ($.isNumeric(data)) {
         this_note.attr('data-note', data);
         console.log('Nowy wpis numer: '+data);
       } else if (data=='deleted') {
         this_note.parent().remove();
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
        $('#notepad').prepend(new_note);
        ajax_notes_send( $(this) );
        $(this).attr('data-note', 'waiting');
        notesListener(this_note);
      }
      ajax_notes_send( $(this) );
    }
  });

  $(this_note).off('focusout'); //najpierw usuwa listenery
  $(this_note).focusout(function() {
    console.log('focusout: '+$(this).attr('data-note'));

    if (!$(this).val() && $(this).attr('data-note')) {
      console.log('Wysłano prośbę o usunięcie wpisu: '+$(this).attr('data-note'));
      ajax_notes_send( $(this), true );
    }
  });

} //function notesListener

var new_note = $('.note_area').outerHTML(); //dodanie do zmiennej czystej notatki w html

notesListener( '.note_area textarea' ); //pierwsze uruchomienie




//###############################################################
//###############################################################
//###############################################################



function ajaxBookmarkSend(this_bookmark, bookmark_delete) {
  $.ajax({
    type: 'post',
    data: {
      'bookmark_ajax': true,
      'bookmark_id': this_bookmark.attr('data-note'),
      'bookmark_href': this_bookmark.val(),
      'bookmark_delete': bookmark_delete,
     },
     dataType : 'text',
     success: function(data){
       if ($.isNumeric(data)) {
         this_bookmark.attr('data-note', data);
         console.log('Nowy wpis numer: '+data);
       } else if (data=='deleted') {
         this_bookmark.parent().remove();
       } else if (data=='edit') {
         console.log('Edytowano wpis numer: '+this_bookmark.attr('data-note'));
       } else console.log(data);
     }
  });
}

function bookmarkListener(this_bookmark) {
  $(this_bookmark).off('input'); //najpierw usuwa listenery
  $(this_bookmark).on('input', function() {
    if ($(this).val()) {
      if (!$(this).attr('data-note')) {
        $('#bookmarks').prepend(new_bookmark);
        ajaxBookmarkSend( $(this) );
        $(this).attr('data-note', 'waiting');
        bookmarkListener(this_bookmark);
      }
      ajaxBookmarkSend( $(this) );
    }
  });
  $(this_bookmark).off('focusout'); //najpierw usuwa listenery
  $(this_bookmark).focusout(function() {
    console.log('focusout');
    if (!$(this).val() && $(this).attr('data-note')) {
      console.log('do usuniecia');
      ajaxBookmarkSend( $(this), true );
    }
  });

} //function bookmarkListener

var new_bookmark = $('.url_container').outerHTML(); //dodanie do zmiennej czystej notatki w html

bookmarkListener( '.url_container .href' ); //pierwsze uruchomienie

//###############################################################
//###############################################################
//###############################################################

var lck_btn = $('#lockscreen .row_btn button');
var input = $('#lockscreen #code_input');
var dots_ctn = $('#lockscreen #row_input'); //konterner kropek


lck_btn.click(function() {
  input.val(input.val()+$(this).html());
  input.trigger('change'); //zmusza dany element do "zasymulowania eventu"
});

input.change(function() {
  console.log($(this).val().length);
  if ($(this).val().length==1) dots_ctn.find('[data-input="1"]').addClass('filled');
  if ($(this).val().length==2) dots_ctn.find('[data-input="2"]').addClass('filled');
  if ($(this).val().length==3) dots_ctn.find('[data-input="3"]').addClass('filled');
  if ($(this).val().length==4) {
    dots_ctn.find('[data-input="4"]').addClass('filled');
    if ($(this).val()==1712) window.location.href = "?code=1234";
    else location.reload();
  }
});








}); //end document ready

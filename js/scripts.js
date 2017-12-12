$(document).ready(function() {


$("[href]").each(function() {
if (this.href == window.location.href) $(this).addClass("active");
});


$(".hamburger, .hamburger_close").click(function() {
  $('body').toggleClass("nav_open");
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


function bookmarkErrorLock(this_bookmark, data) {
    this_bookmark.addClass('error');
    this_bookmark.find('input, select').prop('disabled', true);
    this_bookmark.find('.dropdown').addClass('disabled');
    console.log(data);
}

function bookmarkPrependNew(this_bookmark, error, data) {
  if ($.isNumeric(data['id']) && error!==true) {
    this_bookmark.attr('data-bookmark', data['id']);
    this_bookmark.find('.name').val(data['title']);
    console.log('Nowy wpis numer: '+data['id']);
    this_bookmark.find('input, select').prop('disabled', false);
    this_bookmark.find('.dropdown').removeClass('disabled');
    this_bookmark.find('.name').focus();
  }
  else bookmarkErrorLock(this_bookmark, data);
  $('#bookmarks').prepend(new_bookmark);
  bookmarkAddListener($('section#bookmarks .url_container').first()); //pierwsze uruchomienie
}

function bookmarkEditReturn(this_bookmark, data) {
  if (data=='edit') {
    console.log('Edytowano wpis numer: '+this_bookmark.attr('data-bookmark'));
  } else bookmarkErrorLock(this_bookmark, data);
}
function bookmarkDeleteReturn(this_bookmark, data) {
  if (data=='deleted') {
         console.log('Usunięto wpis numer: '+this_bookmark.attr('data-bookmark'));
         this_bookmark.remove();
       } else bookmarkErrorLock(this_bookmark, data);
}

function bookmarkAddListener(this_bookmark) {
  this_bookmark.find('.href').on('input', function() {
    if ($(this).val() && !this_bookmark.attr('data-bookmark')) {
      $(this).prop('disabled', true);
      $.ajax({
        type: 'post', dataType : 'json', data: {
          'bookmark_ajax': true,
          'bookmark_href': $(this).val(),
         },
         success: function(data){ bookmarkPrependNew(this_bookmark, false, data); },
         error: function(data){ bookmarkPrependNew(this_bookmark, true, data); },
      });
    } else if ($(this).val() && this_bookmark.attr('data-bookmark')) {
      $.ajax({
        type: 'post', dataType : 'text', data: {
          'bookmark_ajax': true,
          'bookmark_id': this_bookmark.attr('data-bookmark'),
          'bookmark_href': $(this).val(),
         },
         success: function(data){ bookmarkEditReturn(this_bookmark, data); },
         error: function(data){ bookmarkErrorLock(this_bookmark, data); },
      });
    }
  });
  this_bookmark.find('.name').on('input', function() {
    if ($(this).val() && this_bookmark.attr('data-bookmark')) {
      $.ajax({
        type: 'post', dataType : 'text', data: {
          'bookmark_ajax': true,
          'bookmark_id': this_bookmark.attr('data-bookmark'),
          'bookmark_title': $(this).val(),
         },
         success: function(data){ bookmarkEditReturn(this_bookmark, data); },
         error: function(data){ bookmarkErrorLock(this_bookmark, data); },
      });
    }
  });
  this_bookmark.find('.href, .name').focusout(function() {
    console.log('focusout');
    if (this_bookmark.attr('data-bookmark') && !this_bookmark.find('.href').val() && !this_bookmark.find('.name').val()) {
      console.log('Trwa usuwanie wpisu nr: '+this_bookmark.attr('data-bookmark'));
        $.ajax({
          type: 'post', dataType : 'text', data: {
            'bookmark_ajax': true,
            'bookmark_id': this_bookmark.attr('data-bookmark'),
            'bookmark_delete': true,
           },
           success: function(data){ bookmarkDeleteReturn(this_bookmark, data); },
           error: function(data){ bookmarkErrorLock(this_bookmark, data); },
        });
    }
  });


} //function bookmarkListener

var new_bookmark = $('.url_container').outerHTML(); //dodanie do zmiennej czystej notatki w html

// bookmarkListener( '.url_container .href' ); //pierwsze uruchomienie

$('section#bookmarks .url_container').each( function(){ bookmarkAddListener($(this)); }); //pierwsze uruchomienie

var tasks = document.querySelectorAll('#todo .task');

if (tasks) {
  var counter = setInterval(timer, 1000); //1000 will  run it every 1 second
  function timer() {
    tasks.forEach(function(t){
      // t.querySelector('');
    });
  }
}

}); //end document ready

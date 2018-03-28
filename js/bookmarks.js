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

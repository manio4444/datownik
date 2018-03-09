if (window.dat === undefined) {
  window.dat = {};
}

dat.docs = {

  edit: function (id, content, name, callback) {

    $.ajax({
        url: '?ajax_action=docsAjax',
        method: 'POST',
        data: {
            operation   :'editText',
            id          : id,
            text        : content,
            name        : name,
        }
    }).done(function(data) {

        console.log(data);

        if (callback !== undefined) {
          callback();
        }

    });

  },

  new: function (content, name, callback) {

    $.ajax({
        url: '?ajax_action=docsAjax',
        method: 'POST',
        data: {
            operation   :'newDoc',
            text        : content,
            name        : name,
        }
    }).done(function(data) {

        console.log(data);

        if (callback !== undefined) {
          callback();
        }

    });

  },

  init: function () {

    var _this = this;

    tinymce.init({
      selector: 'textarea.tinymce',
      height: "200",
      menubar: false,
      plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists code textcolor wordcount imagetools contextmenu colorpicker textpattern help',
      toolbar: 'undo redo | bold italic underline strikethrough | bullist numlist | outdent indent | blockquote subscript superscript | image link insert | removeformat code fullscreen',
      init_instance_callback: function (editor) {
        editor.on('change', function (e) {
          editor.save(); //hack for textarea live updates
        });
      }
    });

    $(document).on("submit", ".js-docs--element", function (e) {
      e.preventDefault();
    });

    $(document).on("click", ".js-docs--save", function (e) {
      e.preventDefault();
      var textarea    = $(this).parents('.js-docs--element').find('.docs-textarea textarea.js-docs--txt');
      var id          = $(this).parents('.js-docs--element').attr('data-docs');
      var name        = $(this).parents('.js-docs--element').find('.js-docs--title').val();
      var text        = textarea.val();
      var _this_btn   = $(this);
      // console.log(Boolean(id));
      // return;
      if (_this_btn.hasClass('loading')) {
        return false;
      }
      _this_btn.addClass('loading');
      var callback = function() {
        _this_btn.removeClass('loading');
      }
      if (id) {
        _this.edit(id, text, name, callback);
      } else {
        _this.new(text, name, callback);
      }
    });

    $(document).on("click", ".docs-title .icon, .js-docs--editname", function () {
      $(this).parents('.js-docs--element').find('.js-docs--title').focus();
    });

  }

}

$(function() { //document ready

  dat.docs.init();

}); //end document ready

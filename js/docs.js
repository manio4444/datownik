if (window.dat === undefined) {
  window.dat = {};
}

dat.docs = {

  edit: function (id, content) {

    $.ajax({
        url: '?ajax_action=docsAjax',
        method: 'POST',
        data: {
            operation   :'editText',
            id          : id,
            text        : content,
        }
    }).done(function(data) {

        console.log(data);

    });

  },

  new: function (content) {

    $.ajax({
        url: '?ajax_action=docsAjax',
        method: 'POST',
        data: {
            operation   :'newDoc',
            text        : content,
        }
    }).done(function(data) {

        console.log(data);

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
      var textarea = $(this).parents('.js-docs--element').find('.docs-textarea textarea.js-docs--txt');
      var id = $(this).parents('.js-docs--element').attr('data-docs');
      var text = textarea.val();
      // console.log(Boolean(id));
      // return;
      if (id) {
        _this.edit(id, text);
      } else {
        _this.new(text);
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

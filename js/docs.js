if (window.dat === undefined) {
  window.dat = {};
}

dat.docs = {

  init: function () {

    tinymce.init({
      selector: 'textarea.tinymce',
      height: "200",
      // plugins: "",
      init_instance_callback: function (editor) {
        editor.on('input', function () {
          console.log('asdasdasdasdasdsa');
        });
      }
    });

    $(document).on("input keypress paste change", "textarea.tinymce", function () {
      console.log("input entered");
    });

    $(document).on("submit", ".js-docs--element", function (e) {
      console.log("form submit");
      e.preventDefault();

    });

  }

}










$(function() {

  dat.docs.init();

}); //end document ready

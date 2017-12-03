var lockscreen = {

  buttons: $('#lockscreen .row_btn button'),
  input: $('#lockscreen #code_input'),
  dotsContainer: $('#lockscreen #row_input'), //konterner kropek
  clicksNumber: 0,

  clickButton: function (button) {

    lockscreen.clicksNumber++;
    console.log(lockscreen.clicksNumber);
    lockscreen.input.val(lockscreen.input.val()+button.html());
    lockscreen.fillDot(lockscreen.clicksNumber);

      if (lockscreen.clicksNumber===4) {
        if (lockscreen.input.val()==1712) {
          window.location.href = "?code=1234";
        } else {
          this.resetLockscreen();
          // location.reload();
        }
      }

  },

  fillDot: function (dotNumber) {

    lockscreen.dotsContainer.find('[data-input="' + dotNumber + '"]').addClass('filled');

  },

  resetLockscreen: function () {

    lockscreen.dotsContainer.addClass('animated shake');
    setTimeout (function () {
      lockscreen.dotsContainer.find('[data-input]').removeClass('filled'); //clear dots
      lockscreen.clicksNumber = 0;
      lockscreen.input.val('');
      lockscreen.dotsContainer.removeClass('animated shake');
    }, 1000);

},

  init: function () {

    lockscreen.buttons.click(function() {
      lockscreen.clickButton($(this));
    });

  }

}

$(document).ready(lockscreen.init);

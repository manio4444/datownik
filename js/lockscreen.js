var lockscreen = {

  buttons:          $('[data-button]'),
  input:            $('[name="lockscreen_code"]'),
  dotsContainer:    $('.lockscreen__inputs'), //konterner kropek
  lockscreenForm:   $('#lockscreen__form'),
  clicksNumber: 0,

  clickButton: function (button) {

    var _this = lockscreen;

    _this.clicksNumber++;
    lockscreen.input.val(lockscreen.input.val()+button);
    _this.fillDot(_this.clicksNumber);

      if (_this.clicksNumber===4) {
        _this.tryLogin();
      }

  },

  fillDot: function (dotNumber) {

    var _this = lockscreen;

    _this.dotsContainer.find('[data-input="' + dotNumber + '"]').addClass('filled');

  },

  resetLockscreen: function () {

    var _this = lockscreen;

    _this.dotsContainer.addClass('animated shake');
    setTimeout (function () {
      _this.dotsContainer.find('[data-input]').removeClass('filled'); //clear dots
      _this.clicksNumber = 0;
      _this.input.val('');
      _this.dotsContainer.removeClass('animated shake');
    }, 1000);

  },

  tryLogin: function () {

    var _this = lockscreen;

    $.ajax({
      type: 'post',
      dataType : 'json',
      data: {
        'ajax_action': 'lockscreenAjax',
        'operation': 'tryPasscode',
        'code': _this.input.val(),
      },
    })
    .done(function(data) {
      if (data.result.isValid) {
        location.reload();
      } else {
        _this.resetLockscreen();
      }
    })
    .catch(function (error) {
      _this.resetLockscreen();
    });

  },

  init: function () {

    var _this = lockscreen;

    _this.buttons.click(function() {
      _this.clickButton($(this).data('button'));
    });

    $('body').keydown(function (e) {
      switch (e.keyCode) {

        case 48: //0
        _this.clickButton("0"); break;
        case 49: //1
        _this.clickButton("1"); break;
        case 50: //2
        _this.clickButton("2"); break;
        case 51: //3
        _this.clickButton("3"); break;
        case 52: //4
        _this.clickButton("4"); break;
        case 53: //5
        _this.clickButton("5"); break;
        case 54: //6
        _this.clickButton("6"); break;
        case 55: //7
        _this.clickButton("7"); break;
        case 56: //8
        _this.clickButton("8"); break;
        case 57: //9
        _this.clickButton("9"); break;
        case 96: //numpad 0
        _this.clickButton("0"); break;
        case 97: //numpad 1
        _this.clickButton("1"); break;
        case 98: //numpad 2
        _this.clickButton("2"); break;
        case 99: //numpad 3
        _this.clickButton("3"); break;
        case 100: //numpad 4
        _this.clickButton("4"); break;
        case 101: //numpad 5
        _this.clickButton("5"); break;
        case 102: //numpad 6
        _this.clickButton("6"); break;
        case 103: //numpad 7
        _this.clickButton("7"); break;
        case 104: //numpad 8
        _this.clickButton("8"); break;
        case 105: //numpad 9
        _this.clickButton("9"); break;

      }
    });

  }

}

$(document).ready(lockscreen.init);

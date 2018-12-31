/**
* Functions only
*/

$.fn.outerHTML = function() {
  return (this[0]) ? this[0].outerHTML : '';
};

function timer(tasksAll) {
  var tasksAll = document.querySelectorAll('[data-task]');
  if (tasksAll) {
    for (var i = 0; i < tasksAll.length; i++) {
      var task = tasksAll[i];
      var deadline = tasksAll[i].querySelector('[data-timer-deadline]');
      var output = tasksAll[i].querySelector('[data-timer-output]');

      if (!deadline) {
        continue;
      }

      if (deadline.value == '' || deadline.value == '0000-00-00 00:00:00' || task.classList.contains('no-deadline')) {
        returnValue = null;
      } else {

        var nowTs = new Date().getTime();
        var deadlineTs = new Date(deadline.value).getTime();

        if (deadlineTs > nowTs) {
          outputReturn = getTimerCounted(nowTs, deadlineTs);
          output.parentNode.classList.remove('error');
        } else {
          outputReturn = getTimerCounted(nowTs, deadlineTs);
          output.parentNode.classList.add('error');
        }

        var returnValue = ''
        + outputReturn.days + ' Dni, '
        + outputReturn.hours + ' Godz. '
        + outputReturn.minutes + ' Min. '
        + outputReturn.seconds + ' Sek.';
      }

      if (output.tagName.toLowerCase() === 'input') {
        output.value = returnValue;
      } else {
        output.innerHTML = returnValue;
      }
    }
  }
}

function getTimerCounted(startTimestamp, endTimestamp) {
  var t = endTimestamp - startTimestamp;
  var seconds = Math.floor( (t/1000) % 60 );
  var minutes = Math.floor( (t/1000/60) % 60 );
  var hours = Math.floor( (t/(1000*60*60)) % 24 );
  var days = Math.floor( t/(1000*60*60*24) );
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

function urlify(text) {
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    return text.replace(urlRegex, function(url) {
        return '<a href="' + url + '">' + url + '</a>';
    })
}

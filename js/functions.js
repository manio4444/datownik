$.fn.outerHTML = function() {
  return (this[0]) ? this[0].outerHTML : '';
};

function timer(tasksAll) {
  console.log('second');
  var tasksAll = document.querySelectorAll('[data-task]');
  if (tasksAll) {
    for (var i = 0; i < tasksAll.length; i++) {
      var deadline = tasksAll[i].querySelector('[data-timer-deadline]');
      var output = tasksAll[i].querySelector('[data-timer-output]');

      var nowTs = new Date().getTime();
      var deadlineTs = new Date(deadline.value).getTime();

      if (deadlineTs > nowTs) {
        outputReturn = getTimerCounted(nowTs, deadlineTs);
        console.log(outputReturn);
        output.parentNode.classList.remove('error');
      } else {
        outputReturn = getTimerCounted(nowTs, deadlineTs);
        console.log(outputReturn);
        output.parentNode.classList.add('error');
      }
      output.value = ''
      + outputReturn.days + 'Dni, '
      + outputReturn.hours + 'Godz. '
      + outputReturn.minutes + 'Min. '
      + outputReturn.seconds + 'Sek.';
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

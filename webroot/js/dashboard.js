window.addEvent('domready', function() {
    $$('.timestamp').each(function(element) {
        var timestamp = element.get('rel');
        var id = element.get('id').replace('_timestamp', '');
        countdown(timestamp, id);
    });
});

function countdown(timestamp, id) {
    var curtime = parseInt(new Date().getTime()  / 1000);
    var diff = timestamp - curtime;
    
    if (diff<0) {
        var neg = true;
        diff = diff * -1;
    } else {
        var neg = false;
    }
    
    var days = parseInt(diff / 60 / 60 / 24);
    diff = diff - (days * 60 * 60 * 24);
    var hours = parseInt(diff / 60 / 60);
    diff = diff - (hours * 60 * 60);
    var mins = parseInt(diff / 60);
    diff = diff - (mins * 60);
    var secs = parseInt(diff);

    var text = ((hours<=9) ? '0'+hours : hours) + ':' + ((mins<=9) ? '0'+mins : mins) + ':' + ((secs<=9) ? '0'+secs : secs);
    
    if (($(id + '_startTime')!=null) && (parseInt($(id + '_startTime').get('rel'))>curtime)) {
        $(id + '_remaining').removeClass('remainingtime');
        $(id + '_remaining').addClass('pending');
        $(id + '_remaining').set('title', 'Pending');
    } else {
        $(id + '_remaining').removeClass('pending');
        $(id + '_remaining').addClass('remainingtime');
        $(id + '_remaining').set('title', 'In progress');
    }
    
    if (neg) {
        text = '-' + text;
        $(id + '_remaining').removeClass('remainingtime');
        $(id + '_remaining').addClass('completed');
        $(id + '_remaining').set('title', 'Completed');
    }
    
    if (days>0) {
        text = days + 'd ' + text;
    }    
    
    $(id + '_remaining').set('text', text);
    window.setTimeout("countdown('" + timestamp + "','" + id + "')", 1000);
    
}

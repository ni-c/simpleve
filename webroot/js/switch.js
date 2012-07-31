window.addEvent('domready', function() {
    $$('.switch').each(function(element) {
        element.addEvent('click', function(event) {
            toggle(element);
        });
    });
    
    $$('.toggleall').each(function(element) {
        element.addEvent('click', function(event) {
            var c = '.' + element.get('rel');
            $$(c).each(function(element) {
                toggle(element);
            });
        });
    });
});

function toggle(element) {
    var rel = element.get('rel');
    if ($(rel).hasClass('hidden')) {
        $(rel).removeClass('hidden');
        element.set('src', element.get('src').replace('theme/plus.gif', 'theme/minus.gif'));
        if ($(rel + '_tr')!=null) {
            $(rel + '_tr').addClass('switchbg');
        }
        setSaveOption(element, 0, 1);
    } else {
        $(rel).addClass('hidden');
        element.set('src', element.get('src').replace('theme/minus.gif', 'theme/plus.gif'));
        if ($(rel + '_tr')!=null) {
            $(rel + '_tr').removeClass('switchbg');
        }
        setSaveOption(element, 1, 0);
    }
    parseCallbacks(element);
}

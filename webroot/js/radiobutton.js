window.addEvent('domready', function() {
    $$('.radiobutton').each(function(element) {
        element.addEvent('click', function(event) {
            if (!element.hasClass('selected')) {
                var rel = element.get('rel');
                element.getParent('table').getElements('span[rel=' + rel + ']').each(function(radiobutton) {
                    radiobutton.removeClass('selected');
                });
                element.addClass('selected');
            } else {
            }
            parseCallbacks(element);
        });
    });
});
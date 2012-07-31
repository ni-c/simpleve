window.addEvent('domready', function() {
    $$('.checkbox').each(function(element) {
        element.addEvent('click', function(event) {
            if (element.hasClass('checked')) {
                element.removeClass('checked');
                setSaveOption(element, 1, 0);
            } else {
                element.addClass('checked');
                setSaveOption(element, 0, 1);
            }
            parseCallbacks(element);
        });
    });
});
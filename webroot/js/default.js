window.addEvent('domready', function() {
    $$('.customvalue').each(function(element) {
        saveValue(element); 
    });
    
    $$('.linkbox').each(function(element) {
       createLinkbox(element); 
    });
    
    $$('.formsubmit').each(function(element) {
        createFormSubmit(element);
    })
    
    $$('.optionselect').each(function(element) {
        createOptionSelect(element);
    });
});

function createOptionSelect(element) {
    element.addEvent('change', function(e) {
        var value = element.getElements('option')[element.selectedIndex].get('value');
        var key = element.get('id');
        saveOption(key, value);
    });
}

function createFormSubmit(element) {
    if (element!=null) {
        var form = $(element.get('rel'));
        if (form!=null) {
            element.addEvent('click', function(e)  {
               e.stop();
               form.submit();
            });
        } 
    }
}

function createLinkbox(element) {
    if (element!=null) {
        var id = element.get('id').replace('_linkbox', '');
        var parent = $(id + '_item');
        var show = null;
        var hide = null;
        if (parent!=null) {
            parent.addEvent('mouseenter', function(event) {
                show = window.setTimeout("showLinkbox('" + id + "')", 500);
                if (hide!=null) {
                    window.clearTimeout(hide);
                }
            });
            parent.addEvent('mouseleave', function(event) {
                hide = window.setTimeout("hideLinkbox('" + id + "')", 500);
                if (show!=null) {
                    window.clearTimeout(show);
                }
            });
            element.addEvent('mouseenter', function(event) {
                if (hide!=null) {
                    window.clearTimeout(hide);
                }
            });
            element.addEvent('mouseleave', function(event) {
                hide = window.setTimeout("hideLinkbox('" + id + "')", 500);
                if (show!=null) {
                    window.clearTimeout(show);
                }
            });
        }
    }
}

function showLinkbox(id) {
    var element = $(id + '_linkbox');
    var parent = $(id + '_item'); 
    element.setStyle('left', parent.getPosition($(document.body)).x + 3);
    element.setStyle('top', parent.getPosition($(document.body)).y + parent.getSize().y + 3);
    element.removeClass('hidden');
}

function hideLinkbox(id) {
    var element = $(id + '_linkbox');
    element.addClass('hidden');
}

function parseCallbacks(element) {
    if (element!=null) {
        if (element.get('callbacks')!=null) {
            var functions = element.get('callbacks').split(';');
            for (var i=0; i < functions.length; i++) {
                eval(functions[i]);
            };
        }
    }
}

function setSaveOption(element, oldvalue, newvalue) {
    if ((element.get('callbacks')!=null) && (element.get('callbacks').indexOf('saveOption')>=0)) {
        element.set('callbacks', element.get('callbacks').replace("'" + oldvalue + "'", "'" + newvalue + "'"));
    }
}

function saveOption(key, value) {
     var BP = $('BP').get('value');
     new Request({
        url: BP + 'options/edit',
        method: 'post',
        }).post({
            'key': key,
            'value': value
        });         
}

function saveValue(element) {
    var BP = $('BP').get('value');
    element.addEvent('blur', function(event) {
         if (element.get('custom')==null) {
             if (console) {
                 exit();
             }
         }
         
         $(document.body).getElements('.customvalue[custom=' + element.get('custom') + ']').each(function(same) {
            same.set('value', element.get('value'));
            same.fireEvent('keyup');
         });
         
         new Request({
            url: BP + 'custom_values/edit',
            method: 'post',
            onSuccess: function(e) 
                {
                }
            }).post({
                'valueType': element.get('custom').split(':')[0],
                'invTypeID': parseInt(element.get('custom').split(':')[1]),
                'value': parseFloat(element.get('value'))
            });         
    });
}

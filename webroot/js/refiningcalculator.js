window.addEvent('domready', function() {

    calcEfficiencies();

    $$('.pricebox').each(function(element) {
        element.addEvent('keyup', function(event) {
            calcEfficiencies();
        });
    });
});

function calcEfficiencies() {
    $$('.refineryefficiency').each(function(element) {
        calcEfficiency(element);
    });
    $$('.refiningvalue').each(function(element) {
        calcRefiningValue(element);
    });
}

function calcEfficiency(element) {
    var id = element.get('id').replace('_efficiency', '');
    var skill_refining = parseFloat($('refining_skill').get('rel'));
    var skill_efficiency = parseFloat($('refineryefficiency_skill').get('rel'));
    var skill_ore = parseFloat($(id + '_skill').get('rel'));
    
    var station = 0.5;    
    var efficiency = station + 
        (0.375
            * (1 + 0.02 * skill_refining) 
            * (1 + 0.04 * skill_efficiency) 
            * (1 + 0.05 * skill_ore));
    
    if (efficiency>1.0) {
        efficiency = 1.0;
    }
    
    $(id + '_efficiency').set('html', parseFloat(efficiency*100).toFixed(2) + '%');
}

function calcRefiningValue(element) {
    var rId = element.get('id').replace('_sum', '');
    var id = rId.split('_')[0];
    var type = rId.split('_')[1];
    
    var orePrice = parseFloat($(rId + '_price').get('value'));
    var refineSize = parseFloat($(rId + '_refinesize').get('html'));
    
    var efficiency = parseFloat($(id + '_efficiency').get('html').replace('%', '')) / 100.0;
    
    var value = new Array();
    var price = new Array();
    
    for (var i=0; i<6; i++) {
        value[i] = parseFloat($(rId + '_' + i + '_value').get('html'));
        price[i] = parseFloat($(id + '_' + i + '_price').get('value'));
    }
    
    var buy = orePrice * refineSize;
    var sell = 0.0;
    for (var i=0; i<6; i++) {
        sell = sell + value[i] * price[i] * efficiency;
    }
     
    var sum = sell / buy * 100.0 - 100.0;
    if (sum>0) {
        var s = '+' + sum.toFixed(2) + '%';
    } else {
        var s = sum.toFixed(2) + '%';
    }
    element.set('html', s);
}
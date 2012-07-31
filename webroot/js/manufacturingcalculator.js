window.addEvent('domready', function() {

    $$('.numeric').each(function(element) {
        createNumericInput(element);
    });

    $$('.pricebox').each(function(element) {
        createPriceCalc(element);
    });
    
     calculateAllInventions();

    $$('.meinput').each(function(element) {
        element.addEvent('keyup', function(event) {
            createMeCalc(element);
            calculateCompleteCost();
        });
        createMeCalc(element);
    });

    $$('.decryptorprice').each(function(element) {
        element.addEvent('keyup', function(event) {
            calculateInvention();
        });
    });

    $$('.metatypeprice').each(function(element) {
        element.addEvent('keyup', function(event) {
            calculateInvention();
        });
    });

    $$('.shoppinglistruns').each(function(element) {
        element.addEvent('keyup', function(event) {
            calculateShoppingList();
        });
    });

    $$('.manufactoringcost').each(function(element) {
        createPeCalc(element);
        peCalc(element.get('rel'));
    });

    $$('.blueprintcopycost').each(function(element) {
        createBpCopyCalc(element);
        bpCopyCalc(element.get('rel'));
    });

    $$('.blueprintresearchcost').each(function(element) {
        createBpResearchCalc(element);
        bpResearchCalc(element.get('rel'));
    });
    
    calculateInvention();
    calculateCompleteResearchCost();
    calculateCompleteCost();
});

function calculateShoppingList() {
    $$('.shoppinglist').each(function(element) {
        var typeID = parseInt(element.get('id').replace('shoppinglistitem_', ''));
        var quantity = 0;
        $$('.shoppinglistitem').each(function(e) {
            if (e.get('typeid')==typeID) {
                var qty = parseInt(e.get('rel'));
                if (e.get('parent')!=null) {
                    qty = qty * parseInt($(e.get('parent')).get('rel'));
                }
                quantity = quantity + qty;
            }
        });
        quantity = quantity * parseInt($('shoppinglistruns').get('value'));
        element.set('text', format(quantity));
    });
}

function calculateAllInventions() {
    $$('.inventionprice').each(function(element) {
        element.addEvent('keyup', function(event) {
            inventionPriceCalc(element);
        });
        inventionPriceCalc(element);
    });
}

function calculateInvention() {
    $$('.invchance').each(function(element) {
        var hash = element.get('id').replace('_complete', '');
        var base_chance = parseFloat($(hash + '_basechance').get('value'));
        var encryption_skill_level = parseInt($(hash + '_encryptionskilllevel').get('value'));
        var datacore_1_skill_level = parseInt($(hash + '_datacore1skilllevel').get('value'));
        var datacore_2_skill_level = parseInt($(hash + '_datacore2skilllevel').get('value'));
        var base_runs = parseInt($(hash + '_baseruns').get('rel'));
        var base_me = parseInt($(hash + '_baseme').get('rel'));
        var base_pe = parseInt($(hash + '_basepe').get('rel'));
        
        var probabilitymodifier = 0.0;
        $(hash + '_decryptors').getElements('td[rel=' + hash + '_probabilitymodifier]').each(function(e) {
            if (e.getParent('tr').getElements('.radiobutton')[0].hasClass('selected')) {
                probabilitymodifier = parseFloat(e.get('text'));
            }
        });
        
        var decryptor_runs = 0;
        $(hash + '_decryptors').getElements('td[rel=' + hash + '_decryptorruns]').each(function(e) {
            if (e.getParent('tr').getElements('.radiobutton')[0].hasClass('selected')) {
                decryptor_runs = parseInt(e.get('text'));
            }
        });
        
        var decryptor_me = 0;
        $(hash + '_decryptors').getElements('td[rel=' + hash + '_decryptorme]').each(function(e) {
            if (e.getParent('tr').getElements('.radiobutton')[0].hasClass('selected')) {
                decryptor_me = parseInt(e.get('text'));
            }
        });
        
        var decryptor_pe = 0;
        $(hash + '_decryptors').getElements('td[rel=' + hash + '_decryptorpe]').each(function(e) {
            if (e.getParent('tr').getElements('.radiobutton')[0].hasClass('selected')) {
                decryptor_pe = parseInt(e.get('text'));
            }
        });
        
        var decryptorprice = 0.0;
        $(hash + '_decryptors').getElements('.decryptorprice').each(function(e) {
            if (e.getParent('tr').getElements('.radiobutton')[0].hasClass('selected')) {
                decryptorprice = parseFloat(e.get('value'));
            }
        });

        var metalevel = 0;
        if ($(hash + '_metatypes')!=null) {
            metalevel = $(hash + '_metatypes').getElements('.selected')[0].get('id').replace(hash + '_meta_', '');
            $(hash + '_metatypes').getElements('.metatypeprice').each(function(e) {
                if (e.getParent('tr').getElements('.radiobutton')[0].hasClass('selected')) {
                    decryptorprice = decryptorprice + parseFloat(e.get('value'));
                }
            });
        }
        
        var chance = base_chance * (1 + (0.01 * encryption_skill_level)) * (1 + ((datacore_1_skill_level + datacore_2_skill_level) * (0.1 / (5 - metalevel)))) * probabilitymodifier;
        var runs = base_runs + decryptor_runs;
        var me = base_me + decryptor_me;
        var pe = base_pe + decryptor_pe;
        if (chance>1) {
            chance = 1;
        }

        element.set('rel', chance);
        element.set('text', parseFloat(chance*100).toFixed(2) + '%');
        $(hash + '_baseruns').set('text', runs);
        if ($(hash + '_baseruns').get('pid')!=null) {
            $($(hash + '_baseruns').get('pid') + '_baseruns').set('value', runs);
            bpCopyCalc($(hash + '_baseruns').get('pid'));
            calculateCompleteResearchCost();
        }
        
        $(hash + '_baseme').set('text', me);
        $(hash + '_basepe').set('text', pe);
        var invcost = parseFloat($(element.get('parent') + '_completeresearchcost').get('rel'));
        var cost = ((invcost + decryptorprice) / chance) / runs;
        $(hash + '_priceperrun').set('rel', parseFloat(cost).toFixed(2));
        $(hash + '_priceperrun').set('text', format(parseFloat(cost).toFixed(2)));

        var pid = $(hash + '_priceperrun').get('pid').replace('_invprice', '');

        if ($(pid + '_price')!=null) {
            if (!$($(pid + '_price').get('rel') + 'checkbox').hasClass('checked')) {
                $($(pid + '_price').get('rel')).set('rel', 0.00);
                $($(pid + '_price').get('rel')).set('text', '0.00');
            } else {
                $($(pid + '_price').get('rel')).set('rel', parseFloat(cost).toFixed(2));
                $($(pid + '_price').get('rel')).set('text', format(parseFloat(cost).toFixed(2)));
            }
    
            $($(pid + '_me').get('rel')).set('value', parseInt(me));
            $($(pid + '_pe').get('rel')).set('value', parseInt(pe));
            createMeCalc($($(pid + '_me').get('rel')));
            peCalc($($(pid + '_pe').get('rel')).get('id').replace('_pe',''));
        }
        calculateCompleteCost();
    });
}


function calculateCompleteCost() {
    
    $$('.completecost').each(function(element) {
        
        var tblHash = element.get('id').replace('_completecost', '');
        var complete = parseFloat($(tblHash + '_materialcost').get('rel')) + parseFloat($(tblHash + '_blueprintcost').get('rel')) + parseFloat($(tblHash + '_manufacturingcost').get('rel'));
        element.set('text', format(parseFloat(complete).toFixed(2)));  
        element.set('rel', parseFloat(complete).toFixed(2));

        var portionsize = parseFloat($(tblHash + '_portionsize').get('value'));
        var completeperitem = complete / portionsize;
        $(tblHash + '_completecostperitem').set('text', format(parseFloat(completeperitem).toFixed(2)))

        if (element.get('parent')!=null) {
            $(element.get('parent')).set('value', parseFloat(complete).toFixed(2));
            calcPrice($(element.get('parent')));
        }
    });
    calculateShoppingList();
}

function calculateCompleteResearchCost() {
    
    $$('.completeresearchcost').each(function(element) {
        var tblHash = element.get('id').replace('_completeresearchcost', '');
        var complete = parseFloat($(tblHash + '_researchmaterialcost').get('rel')) + parseFloat($(tblHash + '_blueprintcost').get('rel')) + parseFloat($(tblHash + '_researchcost').get('rel'));
        element.set('text', format(parseFloat(complete).toFixed(2)));  
        element.set('rel', parseFloat(complete).toFixed(2));  
    });
}

function inventionPriceCalc(element) {
    
    var hash = element.get('id');
    var price = $(hash + '_quantity').get('rel') * element.get('value');
    if (isNaN(price)) {
        $(hash + '_price').set('rel', 0);
    } else {
        $(hash + '_price').set('rel', price.toFixed(2));
    }
    $(hash + '_price').set('text', format(price.toFixed(2)));

    var tableHash = element.getParent('table').get('id');
    calculateInvention();
    calcInventionMaterialPrice(tableHash);
}

function calcInventionMaterialPrice(tableHash) {
    var complete = 0;
    $(tableHash).getElements('span.decryptorprice').each(function(element) {
        complete = complete + parseFloat(element.get('rel'));
    });
    $(tableHash + '_researchmaterialcost').set('text', format(complete.toFixed(2)));
    $(tableHash + '_researchmaterialcost').set('rel', complete.toFixed(2));
    calculateCompleteResearchCost();
}

function createBpResearchCalc(element) {
    
    var tblHash         = element.get('rel');
    element.getElements('.bpresearchcalc').each(function(e) {
        e.addEvent('keyup', function(event) {
            bpResearchCalc(tblHash);
            calculateCompleteCost();
        });
    });
}

function bpResearchCalc(tblHash) {
    if (!$(tblHash + '_blueprintresearchcheckbox').hasClass('checked')) {
        $(tblHash + '_researchcost').set('text', format(parseFloat(0).toFixed(2)));
        $(tblHash + '_researchcost').set('rel', parseFloat(0).toFixed(2));
        return;
    }
    var researchTime            = parseInt($(tblHash + '_researchTechTime').get('value'));   
    var installcost             = parseFloat($(tblHash + '_bp_installcost').get('value'));
    var hourcost                = parseFloat($(tblHash + '_bp_hourcost').get('value'));
    var timemultiplier          = parseFloat($(tblHash + '_bp_timemultiplier').get('value'));
    var standing                = parseFloat($(tblHash + '_bp_standing').get('value'));
    var good_standing           = 1.5; 
    var bad_standing            = 0.5; 
    
    var result = ((researchTime * timemultiplier)/3600 * hourcost) + (installcost);

    if (standing>=0) {
        result = result * (1 - ((standing * good_standing) / 100));
    } else {
        result = result * (1 + ((standing * bad_standing) / 100));
    }
    $(tblHash + '_researchcost').set('text', format(parseFloat(result).toFixed(2)));
    $(tblHash + '_researchcost').set('rel', parseFloat(result).toFixed(2));
    calculateCompleteResearchCost()
}

function createBpCopyCalc(element) {
    
    var tblHash         = element.get('rel');
    element.getElements('.bpcopycalc').each(function(e) {
        e.addEvent('keyup', function(event) {
            bpCopyCalc(tblHash);
            calculateCompleteCost();
        });
    });
}

function bpCopyCalc(tblHash) {
    if (!$(tblHash + '_blueprintcostcheckbox').hasClass('checked')) {
        $(tblHash + '_blueprintcost').set('text', format(parseFloat(0).toFixed(2)));
        $(tblHash + '_blueprintcost').set('rel', parseFloat(0).toFixed(2));
        return;
    }
    var science                 = parseInt($('science').get('value'));   
    var copyTime                = parseInt($(tblHash + '_researchCopyTime').get('value'));   
    var maxproductionlimit      = parseInt($(tblHash + '_maxProductionLimit').get('value'));    
    var installcost             = parseFloat($(tblHash + '_bp_installcost').get('value'));
    var hourcost                = parseFloat($(tblHash + '_bp_hourcost').get('value'));
    var timemultiplier          = parseFloat($(tblHash + '_bp_timemultiplier').get('value'));
    var standing                = parseFloat($(tblHash + '_bp_standing').get('value'));
    var good_standing           = 1.5; 
    var bad_standing            = 0.5; 
    
    var base_runs               = parseInt($(tblHash + '_baseruns').get('value'));
    var copy_runs               = parseInt($(tblHash + '_maxProductionLimit').get('value'));
    if (base_runs==1) {
        copy_runs = 1;
    }

    var result = (((copyTime * (1 - science * 0.05)) * timemultiplier)/3600 * hourcost) * copy_runs + (installcost);

    if (standing>=0) {
        result = result * (1 - ((standing * good_standing) / 100));
    } else {
        result = result * (1 + ((standing * bad_standing) / 100));
    }
    result = parseFloat(result) / parseFloat(maxproductionlimit);
    $(tblHash + '_blueprintcost').set('text', format(parseFloat(result).toFixed(2)));
    $(tblHash + '_blueprintcost').set('rel', parseFloat(result).toFixed(2));
}

function createPeCalc(element) {
    
    var tblHash         = element.get('rel');
    element.getElements('.manucalc').each(function(e) {
        e.addEvent('keyup', function(event) {
            peCalc(tblHash);
            calculateCompleteCost();
        });
    });
}

function peCalc(tblHash) {
    if (!$(tblHash + '_manufacturingcostcheckbox').hasClass('checked')) {
        $(tblHash + '_manufacturingcost').set('text', format(parseFloat(0).toFixed(2)));
        $(tblHash + '_manufacturingcost').set('rel', parseFloat(0).toFixed(2));
        return;
    }
    var pe                      = parseInt($(tblHash + '_pe').get('value'));
    var installcost             = parseFloat($(tblHash + '_installcost').get('value'));
    var hourcost                = parseFloat($(tblHash + '_hourcost').get('value'));
    var timemultiplier          = parseFloat($(tblHash + '_timemultiplier').get('value'));
    var productivitymodifier    = parseFloat($(tblHash + '_productivitymodifier').get('value'));
    var maxproductionlimit      = parseInt($(tblHash + '_maxProductionLimit').get('value'));    
    var standing                = parseFloat($(tblHash + '_standing').get('value'));
    var industrylvl             = parseInt($('industry').get('value'));
    var pe_time                 = parseInt($(tblHash + '_productiontime').get('value'));
    var good_standing           = 1.5; 
    var bad_standing            = 0.5; 
    if (pe_time>0) {
        if (pe > 0) {
            pe_time = parseInt(pe_time * (1 -((productivitymodifier / pe_time) * (pe / (1 + pe)))));
        } else {
            pe_time = parseInt(pe_time * (1 - ((productivitymodifier / pe_time) * (pe-1))));
        }
    } else {
        pe_time = 0;
    }
    
    pe_time = (pe_time * (1 - (industrylvl * 0.05))) * timemultiplier;
    
    var result          = (((pe_time/3600)*hourcost) + (installcost / maxproductionlimit));
    if (standing>=0) {
        result = result * (1 - ((standing * good_standing) / 100));
    } else {
        result = result * (1 + ((standing * bad_standing) / 100));
    }

    $(tblHash + '_manufacturingcost').set('text', format(parseFloat(result).toFixed(2)));
    $(tblHash + '_manufacturingcost').set('rel', parseFloat(result).toFixed(2));
}

function createMeCalc(element) {
    var tblHash = element.get('rel');
    var me = element.get('value');
    $(tblHash + '_yme').set('text', me);
    $(tblHash + '_yme').set('rel', me);
    $(tblHash).getElements('tr.switchrow').each(function(row) {
        if (row.getParent('table').get('id')==tblHash) {
            var base = row.getElements('.quantity')[0].get('rel');
            if (parseInt(me)>=0) {
                var quantity = parseInt(base) * (1 + 0.1 / (parseInt(me) + 1));
                var yourquantity = parseInt(base) * (1 + 0.1 / (parseInt(me) + 1)) * (1.25 - 0.05 * parseInt($('production_efficiency').get('value')));
            } else {
                var quantity = parseInt(base) * (1 + 0.1 - parseInt(me) / 10);
                var yourquantity = parseInt(base) * (1 + 0.1 - parseInt(me) / 10) * (1.25 - 0.05 * parseInt($('production_efficiency').get('value')));
            }
            if (row.getElements('.mequantity').length>0) {
                row.getElements('.mequantity')[0].set('rel', quantity.toFixed(0));
                row.getElements('.mequantity')[0].set('text', format(quantity.toFixed(0)));
            }
            if (row.getElements('.yourquantity').length>0) {
                row.getElements('.yourquantity')[0].set('rel', yourquantity.toFixed(0));
                row.getElements('.yourquantity')[0].set('text', format(yourquantity.toFixed(0)));
            }
        }
    });
    $(tblHash).getElements('.pricebox').each(function(element) {
        calcPrice(element);
    });
}

function createNumericInput(element) {
    element.addEvent('keyup', function(event) {
        
    });
}

function createPriceCalc(element) {
    element.addEvent('keyup', function(event) {
        calcPrice(element);
        calculateCompleteCost();
    });
    calcPrice(element);
}

function calcPrice(element) {
    
    var hash = element.get('id');
    var price = $(hash + '_quantity').get('rel') * element.get('value');
    if (isNaN(price)) {
        $(hash + '_price').set('rel', 0);
    } else {
        $(hash + '_price').set('rel', price.toFixed(2));
    }
    $(hash + '_price').set('text', format(price.toFixed(2)));
    
    var tableHash = element.getParent('table').get('id');
    calcMaterialPrice(tableHash);
}

function calcMaterialPrice(tableHash) {
    var complete = 0;
    $(tableHash).getElements('span.price').each(function(element) {
        complete = complete + parseFloat(element.get('rel'));
    });
    $(tableHash + '_materialcost').set('text', format(complete.toFixed(2)));
    $(tableHash + '_materialcost').set('rel', complete.toFixed(2));
}

function format(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

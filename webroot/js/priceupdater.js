window.addEvent('domready', function() {

    updatePrices();

});

function updatePrices() {
    if ($('update_prices') != null) {
        var id = 0;
        updatePrice(id);
    }
}

function updatePrice(id) {
    if ($('price_' + id) != null) {
        var max = $('max_progress').get('value'); 
        var tmp = $('price_' + id).get('value').split(',');
        var typeID = tmp[0];
        var region = tmp[1];
        var type = tmp[2];
        var BP = $('BP').get('value');
        var progress = parseFloat(id+1) / parseFloat(max);
        new Request({
            url: BP + 'apis/cacheSingle',
            method: 'post',
            onSuccess: function(responseText, responseXML) {
                $('progressbar').setStyle('width', (progress * 748.0) + 'px');
                $('progressbar').set('text', (id+1) + '/' + max);
                updatePrice(id+1);
            }
            }).post({
                'typeID': typeID,
                'region': region,
                'type': type
            });         
    } else {
        $('PriceUpdateCompleted').submit();
    }
}

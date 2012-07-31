window.addEvent('domready', function() {
    if ($('region_select')!=null) {
        createRegionSelectbox();
        regionSelectbox();
    }
});

function createRegionSelectbox() {
    $('region_select').addEvent('change', function(event) {
        regionSelectbox();
    });
}

function regionSelectbox() {
    var url = $('region_url').get('value');
    url = $('BP').get('value') + url.replace('{regionID}', $('region_select').getSelected()[0].get('value')); 
    $('location_apply').set('href', url);
}

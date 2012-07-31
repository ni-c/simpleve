window.addEvent('domready', function() {
    $$('.skillswitch').each(function(element) {
        createSkillSwitch(element); 
    });
});

function createSkillSwitch(element) {
    var BP = $('BP').get('value');
    if (element!=null) {
        element.addEvent('click', function(event) {
            var level = parseInt(element.get('rel'));
            level++;
            if (level>5) {
                level = 0;
            }
            element.set('rel', level);
            element.set('src', BP + 'img/theme/skill_' + level + '.png')
            parseCallbacks(element);
        });
    }
}

var Inteco = window.Inteco || {};

Inteco.events = {};
Inteco.bindings = {};

Inteco.Core = {

    eventsHolder: 'data-event',
    bindsHolder: 'data-bind',

    eventPublisher: function (target, event) {
        if (!$(target).attr(Inteco.Core.eventsHolder)) {
            return true;
        }
        var eventsList = $(target).attr(Inteco.Core.eventsHolder).split(/\s+/);
        var responseStatus = true;
        $.each( eventsList, function(index, item){
            if (typeof window['Inteco']['events'][item] != "undefined") {
                responseStatus = window['Inteco']['events'][item]['run'](event);
            }
        });
        return responseStatus;
    },

    bindingsPublisher: function(target) {
        if (!$(target).attr(Inteco.Core.bindsHolder)) {
            return true;
        }
        var bindsList = $(target).attr(Inteco.Core.bindsHolder).split(/\s+/);
        $.each(bindsList, function(index, item) {
            if (typeof window['Inteco']['bindings'][item] != "undefined") {
                window['Inteco']['bindings'][item]['run']($(target));
            }
        });
    },

    bindingsInit: function(parent) {
        $.each($(parent).find('[' + Inteco.Core.bindsHolder + ']'), function(){
            Inteco.Core.bindingsPublisher($(this));
        });
    },

    get: function (key) {
        if (typeof window['Inteco']['Core']['events'][key] != "undefined") {
            return window['Inteco']['Core']['events'][key];
        } else {
            return false;
        }
    },

    set: function (key, val) {
        window['Inteco']['Core']['events'][key] = val;
    },

    split: function (val) {
        return val.split( /,\s*/ );
    },

    extractLast: function (term) {
        return Inteco.Core.split( term ).pop();
    },

    generateGuid: function() {
        var S4 = function() {
            return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
        };
        return (S4()+S4()+S4()+S4()+S4()+S4()+S4()+S4());
    }
};

if (!String.prototype.format) {
    String.prototype.format = function() {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function(match, number) {
            return typeof args[number] != 'undefined'
                ? args[number]
                : match
                ;
        });
    };
}

$(document).ready(function(){

    var routeId = '';
    if ($('body').attr("data-controller-handler")) {
        var routeId = $('body').attr("data-controller-handler");
        if (typeof window[routeId] !== 'undefined') {
            window[routeId]["run"]();
        }
    }

    // click handlers
    $(document).click(function(event) {
        if ($(event.target).data('event-disable-click-handlers') == true) {
            return true;
        }
        return Inteco.Core.eventPublisher(event.target, event);
    });

    // change handlers
    $(document).on('change', null, function(event) {
        return Inteco.Core.eventPublisher(event.target, event);
    });

    // bind handlers
    $.each($('body').find('[data-bind]'), function(target) {
        Inteco.Core.bindingsPublisher($(this));
    });

    $('#application-initialization-indicator').remove();
});
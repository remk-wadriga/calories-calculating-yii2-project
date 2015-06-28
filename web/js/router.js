Router = {

    rules: {},

    init: function(data){
        if(typeof data != 'undefined'){
            var attributes = [
                'rules'
            ];

            $.each(attributes, function(index, element){
                if(typeof data[element] != 'undefined')
                    Router[element] = data[element];
            });
        }

        Router.setHandlers();
    },

    setHandlers: function(){

    },

    // Handlers

    // END Handlers


    // Public functions

    createUrl: function(route, params){
        var url = Router.findRule(route);

        params = params || {};
        var verbs = 'GET|HEAD|POST|PUT|PATCH|DELETE|OPTIONS';

        var reg = new RegExp(verbs, 'g');
        url = url.replace(reg, '');
        url = url.replace(' ', '');
        var oldUrl = url;

        $.each(params, function(index, value){
            reg = new RegExp("<"+index+":.*?>", 'g');
            url = url.replace(reg, value);

            if(url != oldUrl){
                oldUrl = url;
                params[index] = null;
            }
        });

        $.each(params, function(index, value){
            if(value !== null){
                url += url.indexOf('?') === -1 ? '?' : '&';
                url += index+'='+value;
            }
        });

        url = '/' + url;

        reg = new RegExp("//", 'g');
        return url.replace(reg, '/');
    },

    // Public functions


    // Private functions

    findRule: function(url){
        return Router.rules[url];
    },

    urlEncode: function(url){
        //return escape(encodeURIComponent(url));
        //return escape(encodeURI(url));
        return encodeURI(url);
    }

    // END Private functions
};
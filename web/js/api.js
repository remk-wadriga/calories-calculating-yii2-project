Api = {

    tmpData1: null,
    tmpData2: null,
    tmpData3: null,


    init: function(data){
        if(typeof data != 'undefined'){
            var attributes = [
            ];

            $.each(attributes, function(index, element){
                if(typeof data[element] != 'undefined')
                    Api[element] = data[element];
            });
        }
    },


    // Public functions

        // Modals handlers

        // END Modals handler


        // Change values handlers
        changeValueAjxSelectSubList: function(select){
            var params = {};
            params[select.data('param')] = select.val();

            var url = Router.createUrl(select.data('url'), params);

            var success = function(json){
                $(select.data('target')).html(json);
            };

            Api.ajx(url, {}, success, 'GET');
        },
        // Change values handlers


        // Event handlers
        removeParentElement: function(element){
            var tmpindex = element.data('tmpindex');
            if (typeof tmpindex !== 'undefined') {
                var tmpelement = element.data('tmpelement');

                if (tmpindex == 1) {
                    Api.tmpData1.splice(tmpelement, 1);
                } else if (tmpindex == 2) {
                    Api.tmpData2.splice(tmpelement, 1);
                } else if (tmpindex == 3) {
                    Api.tmpData3.splice(tmpelement, 1);
                }
            }

            element.closest(element.data('parent')).remove();
        },

        changeAddIngredientDropdown: function(select){
            var inputName = select.attr('name');
            var container = $(select.data('target'));
            var id = select.val();

            if ($('input[name="'+inputName+'['+id+']"]', container).length === 0) {
                var name = $('option:selected', select).text();
                var prototype = $(select.data('prototype'));
                var clone = prototype.clone();

                $('input', clone).attr('name', inputName+'['+id+']').val(1);
                $('span', clone).text(name);

                container.append(clone.html());
            }
        },
        // Event handlers


    ajx: function(url, data, success, type, headers, error){
        success = success || function(){};
        error = error || function(){return true};
        type = type || 'POST';
        headers = headers || {};

        $.ajax({
            type: type,
            url: url,
            data: data,
            headers: headers,
            beforeSend: function(){},
            success: function(json){
                success(json);
            },
            complete: function(){},
            error: function(json){
                if(error(json)){
                    Api.processResponseError(json);
                }
            }
        });
    },

    // Public functions



    // Private functions

    processResponseError: function(json){
        console.log(json);
    }

    // END Private functions
};
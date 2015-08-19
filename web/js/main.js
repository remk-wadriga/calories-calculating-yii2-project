Main = {

    // Configs
    dateFormat: 'yyyy-mm-dd',
    language: 'ru',
    messagesLifeTime: 5,
    // END Configs

    // Properties
    eventHandlers: {},
    // END Properties

    // elements ID
    modalWindowsCancelBtnId: '.cancel',
    modalWindowsCloseBtnId: '.close',
    removeParentElementId: '.remove-parent-element',
    dropdownSubListAjxId: 'select.dropdown-sublist-ajx',
    dropdownAddProductId: '.add-product-select',
    ingredientInputId: '.ingredient',
    dropdownAddToCalcId: '.add-to-calc-select',
    floatInputId: 'input.float-input',
    dateInputID: '.date-input',
    messagesContainerID: '#messages_wrapper',
    // END elements ID

    init: function(data){
        if(data !== undefined){
            $.each(data, function(name, value){
                if(Main[name] !== undefined){
                    Main[name] = value;
                }
            });
        }

        Main.runSetupFunctions();
        Main.setHandlers();
    },

    runSetupFunctions: function(){
        Main.seupDatepicker();
    },

    setHandlers: function(){
        Main.changeDropdownSubListAjxValue();
        Main.changeDropdownAddProduct();
        Main.clickRemoveParentElement();
        Main.changeDropDownAddToCalc();
        Main.inputFloatInput();
    },


    // Setup functions

    seupDatepicker: function(){
        $(Main.dateInputID).datepicker({
            format: Main.dateFormat,
            language: Main.language
        }).on('changeDate', function(event){
            Main.handleEvent('changeDate', event, this);
        });
    },

    // END Setup functions


    // Handlers

    changeDropdownSubListAjxValue: function(){
        $(document).on('change', Main.dropdownSubListAjxId, function(){
            Api.changeValueAjxSelectSubList($(this));
            return false;
        });
    },

    clickRemoveParentElement: function(){
        $(document).on('click', Main.removeParentElementId, function(){
            Api.removeParentElement($(this));
        });
    },

            // <-----------------------------------------------------------> //

    changeDropdownAddProduct: function(){
        $(document).on('change', Main.dropdownAddProductId, function(){
            Api.changeAddIngredientDropdown($(this));
        });
    },

    changeDropDownAddToCalc: function(){
        $(document).on('change', Main.dropdownAddToCalcId, function(){
            Api.changeAddIngredientDropdown($(this));
        });
    },

    inputFloatInput: function(){
        $(document).on('input', Main.floatInputId, function(){
            var input = $(this);
            var value = input.val();
            input.val(value.replace(',', '.'));
        });
    },

    // END Handlers



    // Public functions

    addError: function(message, lifeTime, callback){
        var messID = 'message_' + Helper.random_string(3);
        if(lifeTime == undefined){
            lifeTime = Main.messagesLifeTime;
        }
        if(callback == undefined){
            callback = function(){
                setTimeout(function(){
                    $('#' + messID).remove();
                }, lifeTime*1000);
            };
        }
        var text = '<div id="' + messID + '" class="alert alert-danger" role="alert">' + message + '</div>';
        $(Main.messagesContainerID).append(text);
        callback(messID, message);
    },

    // END Public functions



    // Private Functions

    handleEvent: function(eventName, event, data){
        var handlers = Main.eventHandlers[eventName];
        if(handlers === undefined || handlers === null){
            return false;
        }
        if(typeof handlers != 'array'){
            handlers = [handlers];
        }
        $.each(handlers, function(index, handler){
            handler(event, data);
        });
    }

    // END Private Functions

};
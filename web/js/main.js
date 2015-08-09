Main = {

    dateFormat: 'yyyy-mm-dd',
    language: 'ru',


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
    }

    // END Handlers



    // Public functions

    // END Public functions



    // Private Functions



    // END Private Functions

};
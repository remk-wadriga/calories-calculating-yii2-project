Main = {

    // elements ID
    modalWindowsCancelBtnId: '.cancel',
    modalWindowsCloseBtnId: '.close',
    removeParentElementId: '.remove-parent-element',
    dropdownSubListAjxId: 'select.dropdown-sublist-ajx',
    dropdownAddProductId: '.add-product-select',
    ingredientInputId: '.ingredient',
    dropdownAddToCalcId: '.add-to-calc-select',
    floatInputId: 'input.float-input',
    // END elements ID

    init: function(data){
        if(typeof data != 'undefined'){
            var attributes = [
                'leftMenuElemId'
            ];

            $.each(attributes, function(index, element){
                if(typeof data[element] != 'undefined')
                    Main[element] = data[element];
            });
        }

        Main.setHandlers();
    },

    setHandlers: function(){
        Main.changeDropdownSubListAjxValue();
        Main.changeDropdownAddProduct();
        Main.clickRemoveParentElement();
        Main.changeDropDownAddToCalc();
        Main.inputFloatInput();
    },

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
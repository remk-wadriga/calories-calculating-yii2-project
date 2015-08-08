/**
 * Created by Dima on 08.08.2015.
 */

Plan = {

    dateRangeInputID: '.date-range-input',

    init: function(data){
        if(typeof data != 'undefined'){
            var attributes = [
            ];

            $.each(attributes, function(index, element){
                if(typeof data[element] != 'undefined')
                    Plan[element] = data[element];
            });
        }

        Plan.runSetupFunctions();
        Plan.setHandlers();
    },

    runSetupFunctions: function(){
        Plan.seupDateTimepicker();
    },

    setHandlers: function(){

    },

    // Setup functions

    seupDateTimepicker: function(){
        $(Plan.dateRangeInputID).daterangepicker({
            format: Main.dateFormat
        });
    }

    // END Setup functions

    // Handlers

    // END Handlers


    // Public functions

    // Public functions


    // Private functions

    // END Private functions

};
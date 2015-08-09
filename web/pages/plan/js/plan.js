/**
 * Created by Dima on 08.08.2015.
 */

Plan = {

    startDateInputID: '#plan_start_date_input',
    endDateInputID: '#plan_end_date_input',

    init: function(data){
        if(data !== undefined){
            $.each(data, function(name, value){
                if(Plan[name] !== undefined){
                    Plan[name] = value;
                }
            });
        }

        Plan.runSetupFunctions();
        Plan.setHandlers();
    },

    runSetupFunctions: function(){

    },

    setHandlers: function(){

    }

    // Setup functions

    // END Setup functions


    // Handlers

    // END Handlers


    // Public functions

    // Public functions


    // Private functions

    // END Private functions

};
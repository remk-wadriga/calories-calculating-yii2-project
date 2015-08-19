/**
 * Created by Dima on 08.08.2015.
 */

Plan = {

    startDateInputID: '#plan_start_date_input',
    endDateInputID: '#plan_end_date_input',

    startAndDatesError: '',

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
        Plan.changeDate();
    },

    // Setup functions

    // END Setup functions


    // Handlers

    changeDate: function(){
        Main.eventHandlers['changeDate'] = function(event, element){
            element = $(element);
            var elementID = '#'+element.attr('id');
            var startDate = $(Plan.startDateInputID).val();
            var endDate = $(Plan.endDateInputID).val();

            if(elementID == Plan.startDateInputID){
                startDate = element.val();
            }else if(elementID == Plan.endDateInputID){
                endDate = element.val();
            }

            if(endDate && startDate >= endDate){
                $(Plan.endDateInputID).val('');
                Main.addError(Plan.startAndDatesError);
            }
        };
    }

    // END Handlers


    // Public functions

    // Public functions


    // Private functions

    // END Private functions

};
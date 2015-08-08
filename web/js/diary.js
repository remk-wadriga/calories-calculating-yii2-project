/**
 * Created by Dima on 08.08.2015.
 */

Diary = {

    language: 'ru',

    dateInputID: '.diary-date-input',

    init: function(data){
        if(typeof data != 'undefined'){
            var attributes = [
                'language'
            ];

            $.each(attributes, function(index, element){
                if(typeof data[element] != 'undefined')
                    Diary[element] = data[element];
            });
        }

        Diary.runSetupFunctions();
        Diary.setHandlers();
    },

    runSetupFunctions: function(){
        Diary.seupDatepicker();
    },

    setHandlers: function(){

    },

    // Setup functions

    seupDatepicker: function(){
        $(Diary.dateInputID).datepicker({
            format: 'yyyy-mm-dd',
            language: Diary.language
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
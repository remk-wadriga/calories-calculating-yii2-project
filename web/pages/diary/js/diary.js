/**
 * Created by Dima on 08.08.2015.
 */

Diary = {

    init: function(data){
        if(data !== undefined){
            $.each(data, function(name, value){
                if(Diary[name] !== undefined){
                    Diary[name] = value;
                }
            });
        }

        Diary.runSetupFunctions();
        Diary.setHandlers();
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
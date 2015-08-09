EXAMPLE = {

    init: function(data){
        if(data !== undefined){
            $.each(data, function(name, value){
                if(EXAMPLE[name] !== undefined){
                    EXAMPLE[name] = value;
                }
            });
        }

        EXAMPLE.runSetupFunctions();
        EXAMPLE.setHandlers();
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
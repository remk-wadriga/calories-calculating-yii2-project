Helper = {
    in_array: function(needle, haystack, strict){
        var found = false, key, strict = !!strict;
        for (key in haystack) {
            if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
                found = true;
                break;
            }
        }

        return found;
    },

    random_string: function(lengh){
        if(lengh === undefined){
            lengh = 5;
        }

        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz_0123456789";

        for(var i=0; i < lengh; i++){
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }

        return text;
    }
};
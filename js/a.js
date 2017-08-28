var kobe = (function() {
    var _name = "kobe";
    var a = 4;
    var setName = function(name) {
        _name = name;
    }

    var getName = function() {
        return _name;
    }
    // Module pattern
    return {
        setName: setName,
        getName: getName,
        a:a
    }
}());
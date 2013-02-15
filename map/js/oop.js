var $class = function(def) {    
    var constructor = def.hasOwnProperty('constructor') ? def.constructor : function() { };    
    for (var name in $class.Initializers) {
        $class.Initializers[name].call(constructor, def[name], def);
    }
    return constructor;
};

$class.Initializers = {
    Extends: function(parent) {
        if (parent) {
            var F = function() { };
            this._superClass = F.prototype = parent.prototype;
            this.prototype = new F;
        }
    },

    Mixins: function(mixins, def) {
        this.mixin = function(mixin) {
            for (var key in mixin) {
                if (key in $class.Initializers) continue;
                this.prototype[key] = mixin[key];
            }
            this.prototype.constructor = this;
        };
        var objects = [def].concat(mixins || []);
        for (var i = 0, l = objects.length; i < l; i++) {
            this.mixin(objects[i]);
        }
    }
};

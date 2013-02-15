var map1 = map1 || {}

map1.I18n = $class({
	constructor: function() {
		var self = this
		self.dictionary = {}
		var language = 'cs'    
		$.getJSON("locales/" + language + "/translation.json", function(data) {
			self.dictionary = data
			self.translate($(document))
		});        
	},
            
    translate: function(obj) {
        self = this
        obj.find('*[data-i18n-src]').each(function(i){                        
            text = $(this).attr('src')            
            if ( text in self.dictionary ) {                
                $(this).attr('src',self.dictionary[text])
                $(this).removeAttr('data-i18n-src')
            }
        });
        obj.find('*[data-i18n]').each(function(i){
            text = $(this).text().replace(/^\s+|\s+$/g,"")           
            if ( text in self.dictionary ) {
                $(this).text(self.dictionary[text])
                $(this).removeAttr('data-i18n')
            }
        });        
    }	
});

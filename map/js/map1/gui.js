var map1 = map1 || {}
map1.gui =  map1.gui || {}

map1.gui.SideBar = $class({	
	constructor: function(id,id_handle,down) {
		var self = this
		
		this.hideDelay = 200
		this.down = down
	
		this._bar = $(id)
		this._handle = $(id_handle)
		
		this._hideBarTimer = false
	
		this._bar.hide()
		
		this._mouseIn = false		
		this._handleMouseIn = false
						
		this._handle.hover(function() {self._handleMouseIn = true; self.showBar(); }, function() {self._handleMouseIn = false;})	
		this._handle.focusin(function() { self.showBar(); })
		this._bar.hover(function() {self._mouseIn = true;}, function() {self._mouseIn = false;})
		this._bar.focusin(function() { self.showBar(); })	
	},		
	
	_hideBar: function(_doHide) {		
		var self = this
		
		if ( !this._isActive() ) {					
			if (_doHide ) {
				this._handle.removeClass('active-'+this._bar.attr('id'))
				this._bar.hide();
			}
			else {				
				this._hideBarTimer = setTimeout(function() { self._hideBar(true) },this.hideDelay);
			}
		}
		else
			this._hideBarTimer = setTimeout(function() { self._hideBar() },50)
	},
	
	_isActive: function() {		
		return    this._mouseIn
			   || this._handleMouseIn
			   || $(this._bar).find(':focus').length > 0
		       || $(this._handle).find(':focus').length > 0		      
	},
	
	showBar: function() {
		var self = this
		if ( this.down ) {
			this._bar.slideDown(100)
		}
		else {
			this._bar.show(100)
		}
		if ( this._hideBarTimer ) {
			clearTimeout(this._hideBarTimer)
			this._hideBarTimer = false
		}
		this._handle.addClass('active-'+this._bar.attr('id'))
		setTimeout(function() { self._hideBar() },50)
	},		
	
	openDialog: function(dialog) {		
		dialog.open()
	}
});

map1.gui.Dialog = $class({
	constructor: function(id,id_handle,id_close,id_next,id_prev,id_finish) {
		var self = this				
		
		if ( $.isArray(id) ) {
			this._dialog = []
			for ( var i in id ) {
				this._dialog.push($(id[i]))
			}
		}
		else {
			this._dialog = [$(id)]
		}
		
		this._handle = $(id_handle)
		this._close = $(id_close)
		this._prev = $(id_prev)
		this._next = $(id_next)
		this._finish = $(id_finish)
		
		
		this._curr = 0
		
		for ( var i in this._dialog ) {
			this._dialog[i].hide()
		}
		this._handle.css('cursor','pointer')
		this._close.css('cursor','pointer')
		this._next.css('cursor','pointer')
		this._prev.css('cursor','pointer')
		this._finish.css('cursor','pointer')
		
		this._handle.click(function() { self.open() })
		this._close.click(function() { self.close() })
		this._next.click(function() { self.next() })
		this._prev.click(function() { self.prev() })
		this._finish.click(function() { self.finish() })
	},
	
	onOpen: function() {},
	onClose: function() {},
	onPageOpen: function(pageNum) {},
	onPageClose: function(pageNum) {},
	onFinish: function() {},
	
	open: function() {
		var self = this
		this._dialog[0].show()
		this._handle.addClass('active')
		this._prev.addClass('disabled')
		this._prev.css('cursor','auto')	
		this.onOpen()
		this.onPageOpen(this._curr)	
		$(document).bind('keyup', 'esc', function() { self.close() })
		$(document).bind('keyup', 'return', function() { self.next() })
		$(document).bind('keyup', 'backspace', function() { self.prev() })
	},						
	
	close: function() {
		var self = this
		$(document).unbind('keyup', 'esc', function() { self.close() })
		$(document).unbind('keyup', 'return', function() { self.next() })
		$(document).unbind('keyup', 'backspace', function() { self.prev() })
		this.onPageClose(this._curr)	
		this.onClose()	
		this._dialog[this._curr].hide()
		this._handle.removeClass('active')
	},
	
	next: function() {
		if ( this._curr < this._dialog.length -1) {
			this.onPageClose(this._curr)
			this._dialog[this._curr++].hide()					
			this._dialog[this._curr].show()
			this.onPageOpen(this._curr)
			this._prev.removeClass('disabled')
			this._prev.css('cursor','pointer')
			if ( this._curr == this._dialog.length -1 ) {
				this._next.addClass('disabled')
				this._next.css('cursor','auto')
			}
			else {
				this._next.removeClass('disabled')
				this._next.css('cursor','pointer')
			}
		}
	},
	
	prev: function() {
		if ( this._curr > 0 ) {
			this.onPageClose(this._curr)
			this._dialog[this._curr--].hide()			
			this._dialog[this._curr].show()
			this.onPageOpen(this._curr)
			this._next.removeClass('disabled')
			this._next.css('cursor','pointer')
			if ( this._curr == 0 ) {
				this._prev.addClass('disabled')
				this._prev.css('cursor','auto')
			}
			else {
				this._prev.removeClass('disabled')
				this._prev.css('cursor','pointer')
			}
		}
	},
	
	finish: function() {
		this.onFinish()
	}		
});

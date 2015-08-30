/*
 * jCountdown
 * Creates a countdown timer from a jQuery object. Allows you to format
 * the way the time is displayed.
 *
 * $(<selector>).countdown({params});
 *
 * If you want to replace the 
 *
 */
jQuery.fn.countdown = function(params) {
    var self = this;

    //Properties
    //----------------------------------------------            
    //set the time and day to work with
    self.display = $(this);    
    self.target = new Date(params.target);
    self.start = new Date(params.start);               
    self.message = params.message?params.message:"It's Here!!";
    self.addZeros = params.addZeros?params.addZeros:false;
    self.diff = (self.target-self.start);
    self.count = 1000;  
    //Events
    //----------------------------------------------
    self.onTick = params.onTick?params.onTick:function() { return true; };
    self.onFinish = params.onFinish?params.onFinish:function() { return true; };

    //Methods
    //----------------------------------------------   
    //Updates the text for the countdown timer
    self._tick = function() {
	
        //get the time difference
        var now = self.diff;
        self.count = self.count+1000;  
        //make sure success hasn't been reached
        if ((now.valueOf()-self.count) < 0) {

            //clear the interval and run the event
            window.clearInterval(self._interval);
            if (!self.onFinish(self.display)) { return; }
            
            //display the finish message
            self.display.html(self.message);
            return;
            
        };
        
        //update the values
        var seconds = (now.valueOf()-self.count)/1000;        
        var day = (Math.floor(seconds/86400))%86400;
        var hrs = (Math.floor(seconds/3600))%24;
        var min = (Math.floor(seconds/60))%60;
        var sec = (Math.floor(seconds/1))%60;
                
        //run the event if needed
        if (!self.onTick(self.display,day,hrs,min,sec)) { return; }; 
        
        //check for zeros
        if (self.addZeros) {
            hrs = (hrs+"").length<2?"0"+hrs:hrs;
            min = (min+"").length<2?"0"+min:min;
            sec = (sec+"").length<2?"0"+sec:sec;
        };
                
        //display the new time
        self.display.html(
            hrs+"<span>:</span>"+min+"<span>:</span>"+sec
            );
    };
    
    
    //Setup Routine
    //----------------------------------------------
    self._interval = window.setInterval(
        self._tick,
        params.interval?params.interval:1000
        );
        
    //run immediately by default
    if (!params.delayStart) { self.update(); };

    //return itself
    return this;

};

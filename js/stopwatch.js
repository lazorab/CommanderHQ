
var flagclock = 0;
var flagstop = 0;
var stoptime = 0;
var splitcounter = 0;
var currenttime;
var splitdate = "";
var clock;

function save()
{
	document.clockform.submit();
}

function savecustom()
{
	document.customform.submit();
}

function countclicks()
{
	var rounds = parseInt(document.getElementById("rounds").value);
	document.getElementById("rounds").value = rounds + 1;
	$('.ui-li-count').html(rounds + 1);
}

function stopcountdown()
{
	javascript_countdown.stop();
}

function resetcountdown(val)
{
	document.getElementById("clock").value = val;
}

function startcountdown(val)
{
	var time = val.split(":");
	var minutes=parseInt(time[0]);
	var seconds=parseInt(time[1]);
	var splitseconds=parseInt(time[2]);
	var totalsplitseconds = (minutes*600) + (seconds*10) + splitseconds;
	javascript_countdown.init(totalsplitseconds, 'javascript_countdown_time');
}

var javascript_countdown = function () {
	var time_left = 10; //number of seconds for countdown
	var output_element_id = 'javascript_countdown_time';
	var keep_counting = 1;
	var pause = 0;
	var no_time_left_message = 'Times Up!';
 
	function countdown() {
		if(time_left < 2) {
			keep_counting = 0;
		}
 
		time_left = time_left - 1;
	}
 
	function add_leading_zero(n) {
		if(n.toString().length < 2) {
			return '0' + n;
		} else {
			return n;
		}
	}
 
	function format_output() {
		var hours, minutes, seconds, splitseconds;
		
		splitseconds = time_left % 10;
		seconds = Math.floor(time_left / 10) % 60;
		minutes = Math.floor(time_left / 600);
		hours = Math.floor(time_left / 36000);
 
		seconds = add_leading_zero( seconds );
		minutes = add_leading_zero( minutes );
		hours = add_leading_zero( hours );
 
		return minutes + ':' + seconds + ':' + splitseconds;
	}
 
	function show_time_left() {
		document.getElementById("clock").value = format_output();//time_left;
		//document.getElementById("clock").value = time_left;//time_left;
	}
 
	function no_time_left() {
		document.getElementById("clock").value = no_time_left_message;
		document.clockform.submit();
	}
 
	return {
		count: function () {
			countdown();
			show_time_left();
		},
		timer: function () {
			javascript_countdown.count();
 
			if(keep_counting && pause == 0) {
				setTimeout("javascript_countdown.timer();", 100);
			} else if(keep_counting == 0 && pause == 0){
				no_time_left();				
			}
		},

		setTimeLeft: function (t) {
			time_left = t;
			if(keep_counting == 0) {
				javascript_countdown.timer();
			}
		},
		init: function (t, element_id) {
			pause = 0;
			time_left = t;
			output_element_id = element_id;
			javascript_countdown.timer();
		},
		stop: function() {
			//keep_counting = 0;
			pause = 1;
		}
	};
}();

function startstop()
{
    if(flagclock == 1)
	stop();
    else
	start();
}

function start()
{
    var startdate = new Date();
    var starttime = startdate.getTime();

    flagclock = 1;
    counter(starttime);
}

function stop()
{
    var startdate = new Date();
    var starttime = startdate.getTime();

    flagclock = 0;
    flagstop = 1;
    splitdate = "";
}

function counter(starttime)
{
clock = document.getElementById("clock");
currenttime = new Date();
var timediff = currenttime.getTime() - starttime;
if(flagstop == 1)
{
timediff = timediff + stoptime
}
if(flagclock == 1)
{
clock.value = formattime(timediff,"");
refresh = setTimeout("counter(" + starttime + ");",10);
}
else
{
window.clearTimeout(refresh);
stoptime = timediff;
}
}

function formattime(rawtime,roundtype)
{
if(roundtype == "round")
{
var ds = Math.round(rawtime/100) + "";
}
else
{
var ds = Math.floor(rawtime/100) + "";
}
var sec = Math.floor(rawtime/1000);
var min = Math.floor(rawtime/60000);
ds = ds.charAt(ds.length - 1);
if(min >= 60)
{
start();
}
sec = sec - 60 * min + "";
if(sec.charAt(sec.length - 2) != "")
{
sec = sec.charAt(sec.length - 2) + sec.charAt(sec.length - 1);
}
else
{
sec = 0 + sec.charAt(sec.length - 1);
}
min = min + "";
if(min.charAt(min.length - 2) != "")
{
min = min.charAt(min.length - 2)+min.charAt(min.length - 1);
}
else
{
min = 0 + min.charAt(min.length - 1);
}
return min + ":" + sec + ":" + ds;
}

function reset()
{
   // flagstop = 0;
   // stoptime = 0;
   // splitdate = "";
    //window.clearTimeout(refresh);
   // splitcounter = 0;
   // if(flagclock == 1)
   // {
   //     var resetdate = new Date();
   //     var resettime = resetdate.getTime();
   //     counter(resettime);
   // }
    clock.value = "00:00:0";
}
var urlCount=0;
var urlPos=0;
var urlHistory = [];

addressBarStatus = true;

function Refresh(alink){
	Activate();
	var tmp = document.getElementById('MobileWindow').src;
	if(tmp!=''){
		document.getElementById('MobileWindow').src=tmp;
	}
	else
		{
			document.getElementById('MobileWindow').src='';
		}
	return false;
}

function goBack(alink){
	SetOn();
	if(urlHistory.length > 0 && urlPos > 1){
		document.getElementById('MobileWindow').src = urlHistory[urlPos-2];
		document.getElementById('MobileURL').value = urlHistory[urlPos-2];
		urlPos--;
	}
 return false;
}

function goForward(alink){
	SetOn();
	if(urlHistory.length > 0 && urlPos < urlHistory.length){
		document.getElementById('MobileWindow').src = urlHistory[urlPos];
		document.getElementById('MobileURL').value = urlHistory[urlPos];
		urlPos++;
	}
 return false;
}

function flipMobile(obj){
 hand = document.getElementById('Mobile_Main');

 if(hand.className == "Vertical"){
  hand.className ="Horizontal";
 }else{
  hand.className = "Vertical";
 }
 changeAddressBarLocation(addressBarStatus);  
 document.getElementById('MobileURL').focus();
 return false;
}

function EnableScrollingText(onoff){
 var z = document.getElementById('MobileWindow');
 var queryStr = window.top.location.search.substring(1);
 var y = getValues(queryStr, 'scroll');
 z.scrolling = onoff;
 if(onoff == 'auto'){
  if(y == 'on'){
  
  }
 }
}

function ShowWeb(){
 
}

function loadListValues(id){
	document.getElementById('MobileWindow').src = iPhoneApps[id];
	document.getElementById('MobileURL').value = iPhoneApps[id];
 return false;
}

MobileDateTime = "";
xyz = 0;
var datenow;

function Statuschange(){
	datenow = new Date();
	iHour = datenow.getHours();
	iMinute = datenow.getMinutes();
	iSecond = datenow.getSeconds();
	if(iHour < 12){ampm = "AM"}else{ampm = "PM";iHour = iHour-12;}
	if(iHour < 10){iHour = "0" + iHour;}
	if(iHour == 0){iHour = "12";}
	if(iMinute < 10){iMinute = "0" + iMinute;}
	MobileDateTime = iHour + ":" + iMinute + " " + ampm;
	x = document.getElementById("MobileSignals");
	if(xyz > 0){
		document.getElementById("DateTime").innerHTML = MobileDateTime;
		if((iSecond*iMinute%5) == 0){
			x.className = "none";}else{
			x.className = "Signals";
		}
	}
	xyz = 1;
	window.setTimeout(Statuschange, 30000);
}

Statuschange();

function Activate(){
	locationObj1.className='loadingAact';
	locationObj2.className='loadingBact';
	locationObj3.className='loadingCact';
	setTimeout(SetOff,350);
}

function SetOff(){
	locationObj1.className='Mobile_A_OffLoading';
	locationObj2.className='Mobile_B_OffLoading';
	locationObj3.className='Mobile_C_OffLoading';
	xyz = 0;
}

function SetOn(){
	locationObj1.className='loadingAon';
	locationObj2.className='loadingBon';
	locationObj3.className='loadingCon';
}

function getValues ( queryString, parameterName ) {

var parameterName = parameterName + "=";
if ( queryString.length > 0 ) {

begin = queryString.indexOf ( parameterName );

if ( begin != -1 ) {

begin += parameterName.length;

end = queryString.indexOf ( "&" , begin );
if ( end == -1 ) {
end = queryString.length
}

return unescape ( queryString.substring ( begin, end ) );
}

return "null";
}
} 

function SetPNG() 
{
  
   var arVersion = navigator.appVersion.split("MSIE")
   var version = parseFloat(arVersion[1]);
   if ((version >= 5.5 && version < 7) && (document.body.filters)) 
   {
      for(var i=0; i<document.images.length; i++)
      {
         var img = document.images[i]
         var imgName = img.src.toUpperCase()
         if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
         {
            var imgID = (img.id) ? "id='" + img.id + "' " : ""
            var imgClass = (img.className) ? "class='" + img.className + "' " : ""
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
            var imgStyle = "display:inline-block;" + img.style.cssText 
            if (img.align == "left") imgStyle = "float:left;" + imgStyle
            if (img.align == "right") imgStyle = "float:right;" + imgStyle
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
            var strNewHTML = "<span " + imgID + imgClass + imgTitle
            + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
            + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
            img.outerHTML = strNewHTML
            i = i-1
         }
      }
   }    
}




$(document).ready(function() {
	locationObj1 = document.getElementById("MobileAddressBarLeft");
	locationObj2 = document.getElementById("MobileInputWindow");
	locationObj3 = document.getElementById("MobileAddressBarRight");
	$('#MobileURL').focus(function(){
		$(this).select();
		locationObj1.className='loadingAon';
		locationObj2.className='loadingBon';
		locationObj3.className='loadingCon';
	});
	$('#MobileURL').blur(function(){
		locationObj1.className='Mobile_A_OffLoading';
		locationObj2.className='Mobile_B_OffLoading';
		locationObj3.className='Mobile_C_OffLoading';
	});
	$('#tips_head').click(function(){
		$('#tips').toggle('fast');
	});
	$('#faq_head').click(function(){
		$('#faq').toggle('fast');
	});
	$('#apps_head').click(function(){
		$('#apps').toggle('fast');
	});
	$("html").keypress(function(e){
		if(window.event)	keycode = window.event.keyCode; 
		else if (e)	keycode = e.which; 
		if(keycode == 32){
			flipMobile(null);
			return false;
		}
	});
	if (document.images){
	   img1 = new Image();
	   img2 = new Image();
	   img3 = new Image();
	   img4 = new Image();
	   img5 = new Image();
	   img6 = new Image();
	   img7 = new Image();
	   img1.src = "/img/UIRoundedTextFieldLeft.png";
	   img2.src = "/img/UIRoundedTextFieldMiddle.png";
	   img3.src = "/img/UIRoundedTextFieldRight.png";
	   img4.src = "/img/UIRoundedTextFieldProgressLeft.png";
	   img5.src = "/img/UIRoundedTextFieldProgressMiddle.png";
	   img6.src = "/img/UIRoundedTextFieldProgressRight.png";
	   img7.src = "/img/iphone_hor.png";
	}
});

function handlEvent(event) {

  alert(event.keyCode);
  alert(event.which);
  alert(event.type);
  alert(event.target);
}

function changeBackground(HexColor){
 document.getElementById("docbody").style.backgroundColor = "#" + HexColor;
}

function changeAddressBarLocation(onoff){
if(onoff){
if(document.getElementById('Mobile_Main').className == "Horizontal"){
 document.getElementById('MobileAddressBar').style.display="block";
 document.getElementById('MobileWindow').style.height="208px";
 document.getElementById('MobileWindow').style.top="110px";
}else if(document.getElementById('Mobile_Main').className == "Vertical"){
 document.getElementById('MobileAddressBar').style.display="block";
 document.getElementById('MobileWindow').style.height="356px";
 document.getElementById('MobileWindow').style.top="210px";
}
}else{
if(document.getElementById('Mobile_Main').className == "Horizontal"){
 document.getElementById('MobileAddressBar').style.display="none";
 document.getElementById('MobileWindow').style.height="268px";
 document.getElementById('MobileWindow').style.top="51px";
}else if(document.getElementById('Mobile_Main').className == "Vertical"){
 document.getElementById('MobileAddressBar').style.display="none";
 document.getElementById('MobileWindow').style.height="416px";
 document.getElementById('MobileWindow').style.top="150px";
}
}
}


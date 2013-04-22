<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script language="javascript">
    var lat;
    var lng;  
navigator.geolocation.getCurrentPosition(findLocation, noLocation);

function findLocation(position)
{
    lat = position.coords.latitude;
    lng = position.coords.longitude;
    $.ajax({url:'ajax.php?module=locator',data:{latitude:lat,longitude:lng},dataType:"html",success:display}); 
    //$.getJSON("ajax.php?module=locator",{latitude:lat,longitude:lng},display);
}

function noLocation()
{
    $.ajax({url:'ajax.php?module=locator',data:{latitude:null,longitude:null},dataType:"html",success:display}); 
    //$.getJSON("ajax.php?module=locator",{latitude:null,longitude:null},display);
}

function GymSearch()
{
    $("#map_canvas").removeClass("active");
    $.ajax({url:'ajax.php?module=locator',data:$("#searchform").serialize(),dataType:"html",success:display});
    //$.getJSON('ajax.php?module=locator', $("#searchform").serialize(),display);
    $('#topselection').html('<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d"><li>Search Results</li></ul>');
    $('#toplist').listview(); 
    $('#toplist').listview('refresh');   
}

function goBackTo()
{
    $.ajax({url:'ajax.php?module=locator',data:{latitude:lat,longitude:lng},dataType:"html",success:display});
    $("#map_canvas").html("");
    $("#map_canvas").removeClass("active");
    topselectiondisplay('<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d"><li>Affiliate Gyms Near you</li></ul>');
    //$.getJSON("ajax.php?module=locator",{latitude:lat,longitude:lng},display);
}

function getDetails(id)
{
    $('#back').html('<img alt="Back" onclick="goBackTo();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=locator',data:{Id:id,lat:lat,lng:lng},dataType:"html",success:display});
    $.ajax({url:'ajax.php?module=locator',data:{topselection:id},dataType:"html",success:topselectiondisplay});
    //$.getJSON("ajax.php?module=locator",{Id:id,lat:lat,lng:lng},display);
    //$.getJSON("ajax.php?module=locator",{topselection:id},topselectiondisplay);
}

function openMap(id)
{
	$.mobile.changePage("#pageMap");
	$.ajax({url:'ajax.php?module=locator',data:{getMap:id,lat:lat,lng:lng},dataType:"html",success:displayMap});
	$('#back').html('<img alt="Back" onclick="FromMapBackToDetails(' + id + ');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
}

function FromMapBackToDetails(id) {
	$('#mapPlaceOlder').html("<br>");
	$('#map_canvas').html("<br>");
	getDetails(id);
}

function displayMap(data) {
	$('#mapPlaceOlder').html(data);
	$("#topselection").html("");
    $('#toplist').listview(); 
    $('#toplist').listview('refresh');
	//initMap();
}

function topselectiondisplay(data)
{
    $('#topselection').html(data);
    $('#toplist').listview(); 
    $('#toplist').listview('refresh'); 
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('#listview').listview();
    $('#listview').listview('refresh');
    $('#AjaxLoading').html('');	
}

$("#listitem").swiperight(function() {
    alert("swipe");
});

</script>

<div id="mainPage">
	<div data-role="content">
		<form action="#" method="post" name="searchform" id="searchform">
			<div style="padding: 2%; float: left; width: 70%;">
				<input type="search" results="5" placeholder="Search" name="keyword" />
			</div>
			<div style="float: left; margin: 8px 0 0 0">
				<input type="button" name="btnSubmit" value="Go" data-inline="true"
					onclick="GymSearch();" />
			</div>
		</form>
	</div>
</div>

<div class="clear"></div>
<div id="topselection">
	<div data-role="content">
		<ul id="toplist" data-role="listview" data-inset="true" data-theme="c"
			data-dividertheme="d">
			<li>Affiliate Gyms Near you</li>
		</ul>
	</div>
</div>

<div id="AjaxOutput">       
    <?php echo $Display->Output();?>
</div>

<div id="pageMap">
	<div data-role="header">
		<h1>Map</h1>
	</div>
	<div data-role="content">
		swipe me
		<div id="mapPlaceOlder"></div>
		<div id="map_canvas"></div>
		<ul data-role="listview" data-inset="true" data-theme="c">
			<li id="listitem">Swipe Right to view Page 1</li>
		</ul>
	</div>
</div>


<div id="pageInstructions">
	<div id="map_instructions"></div>
</div>
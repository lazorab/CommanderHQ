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
}

function noLocation()
{
    $.ajax({url:'ajax.php?module=locator',data:{latitude:null,longitude:null},dataType:"html",success:display}); 
}

function GymSearch()
{
    $("#map_canvas").removeClass("active");
    $.ajax({url:'ajax.php?module=locator',data:$("#searchform").serialize(),dataType:"html",success:display});
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
}

function getDetails(id)
{
    $('#back').html('<img alt="Back" onclick="goBackTo();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=locator',data:{Id:id,lat:lat,lng:lng},dataType:"html",success:display});
    $.ajax({url:'ajax.php?module=locator',data:{topselection:id,lat:lat,lng:lng},dataType:"html",success:topselectiondisplay});
}

function DisplayMap() {
    $('#driveInstructions').removeClass("active");
    if($("#map_canvas").hasClass("active")){
        $("#map_canvas").removeClass("active");
    }else{
        $("#map_canvas").addClass("active");
    }
}

function DisplayDriveInstructions() {
    $("#map_canvas").removeClass("active");
    if($("#driveInstructions").hasClass("active")){
        $("#driveInstructions").removeClass("active");
    }else{
        $("#driveInstructions").addClass("active");
    }    
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
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('#AjaxLoading').html('');	
}

function CloseBoth() {
	
	$('#driveInstructions').removeClass("active");
}

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

<div id="map_canvas"></div>
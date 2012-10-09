<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>   
<script language="javascript">
    var lat;
    var lng;   
navigator.geolocation.getCurrentPosition(findLocation, noLocation);
function findLocation(position)
{
    lat = position.coords.latitude;
    lng = position.coords.longitude;
    $.getJSON("ajax.php?module=locator",{latitude:lat,longitude:lng},display);
}

function noLocation()
{
    $.getJSON("ajax.php?module=locator",{latitude:null,longitude:null},display);
}

function GymSearch()
{
    $("#map_canvas").removeClass("active");
    $.getJSON('ajax.php?module=locator', $("#searchform").serialize(),display);
    $('#topselection').html('<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d"><li>Search Results</li></ul>');
    $('#toplist').listview(); 
    $('#toplist').listview('refresh');   
}

function goBack()
{
    $("#map_canvas").removeClass("active");
    $.getJSON("ajax.php?module=locator",{latitude:lat,longitude:lng},display);
}

function getDetails(id)
{
    $('#back').html('<img alt="Back" onclick="goBack();" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>');
    $.getJSON("ajax.php?module=locator",{Id:id,lat:lat,lng:lng},display);
    $.getJSON("ajax.php?module=locator",{topselection:id},topselectiondisplay);
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
</script> 

    <div>
     <form action="#" method="post" name="searchform" id="searchform">
        <div style="padding:2%;float:left;width:70%;"><input type="search" results="5" placeholder="Search" name="keyword"/></div>
        <div style="float:left;"><input type="button" name="btnSubmit" value="Go" data-inline="true" onclick="GymSearch();"/></div>
    </form>  
    </div> 
<div class="clear"></div>
<div id="topselection">   
    <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
        <li>Affiliate Gyms Near you</li>
    </ul>
</div>

<div id="map_canvas"></div>

<div id="AjaxOutput">       
    <?php echo $Display->Output();?>
</div>

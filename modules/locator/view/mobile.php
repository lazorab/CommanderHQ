<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>   
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
        <div style="float:left;margin:8px 0 0 0"><input type="button" name="btnSubmit" value="Go" data-inline="true" onclick="GymSearch();"/></div>
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

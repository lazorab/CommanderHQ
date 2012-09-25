<script language="javascript">

navigator.geolocation.getCurrentPosition(findLocation, noLocation);
function findLocation(position)
{
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    var url = 'http://<?php echo THIS_DOMAIN;?>/?module=locator&lat=' + lat + '&long=' + lng + '';
    window.location=url;
}

function noLocation()
{

}
</script>
<h2>Affiliates</h2>
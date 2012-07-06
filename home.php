<?php
require_once('library/SAT_V2_API.php');
require_once('library/SAT_NET_MobiRender.php');
$database = mysql_connect( DB_SERVER, DB_USERNAME, DB_PASSWORD );
if ( !$database ) {
    die( 'Error: Could not connect to database' );
}
mysql_select_db( DB_CUSTOM_DATABASE, $database );

$browser=new Browser();

$isSmartPhone = $browser->getPlatform() == Browser::PLATFORM_ANDROID
|| $browser->getPlatform() == Browser::PLATFORM_IPAD
|| $browser->getPlatform() == Browser::PLATFORM_IPHONE
                || $browser->getPlatform() == Browser::PLATFORM_IPOD
|| ($browser->getPlatform() == Browser::PLATFORM_BLACKBERRY && substr($browser->getVersion(),0,1) != 4);

$displaylist='';
/*
$LBS = Location Based Services
*/
$LBS = '';
if (!isset($_REQUEST['lbs']) || $_REQUEST['lbs'] == ''){
/*
Check for smart phone
*/
if($isSmartPhone)
{
$ratio=0.717;
$site_width=$request->get_screen_width();
$video_height=floor($site_width * $ratio);
?>
<script language="javascript">

navigator.geolocation.getCurrentPosition(findLocation, noLocation);
function findLocation(position)
{
var lat = position.coords.latitude;
var lng = position.coords.longitude;
var url = 'http://satdemo.be-mobile.co.za/?page=home&lbs=yes&lat=' + lat + '&long=' + lng + '';
window.location=url;
}

function noLocation()
{
var url = 'http://satdemo.be-mobile.co.za/?page=home&lbs=no';
window.location=url;
}
</script>
<?php
}
else{
$LBS = 'no';
}
}
else{
$LBS = $_REQUEST['lbs'];
}

if($LBS != '')
{  
	if ($LBS == 'yes'){
?>
            <div class="content_holder">
              <div class="pad_content">
<div style="float:left">
<a name="fb_share"></a> 
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" 
        type="text/javascript">
</script>
</div>
<div style="float:left">
<a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
</div>
<wall:br/><wall:br/>			  
                <h2>Welcome to South Africa</h2>
              </div>
            </div>
            <div class="content_holder">
              <div class="pad_content">
                <p>Do you have a sense of adventure? Taste for life? Well South Africa delivers on a grand scale! But don't take our word for it. Find great catergorized travel deals, exciting events and best places to be- on our Mobisite.</p>
              </div>

            </div>
        <div class="content_holder">
          <div class="pad_content">
		  
            <div class="heading2"><span class="heading2_first">Experience: </span><span class="heading2_second">Shark Alley</span></div>
		</div>
			<iframe width="<?php echo $site_width; ?>" height="<?php echo $video_height; ?>" src="http://www.youtube.com/embed/Me8UyRqMdhM" frameborder="0"></iframe> 
			<div class="pad_content">
            <p>
              The aptly named Shark Alley, off the Western Cape coast, offers visitors adrenaline-packed adventures with its resident great white sharks, both in and out the water.
            </p>
			
                  <a href="?page=experience_view&id=195222">Read more</a>

                  <wall:br/>
                  <wall:br/>
                  <a href="?page=experiences"><img src="<?php echo str_replace( '~~meta~~', 'sat_experiences_read_more', $request->asset_url() ); ?>" border="0" class="right" alt="Read more" /></a>		
          </div>
        </div>
<?php	
	$sql='SELECT * FROM SAT_TravelToSADeals0910 WHERE DateExpire > NOW() AND Province = "Western Cape" LIMIT 5';
	$res=mysql_query($sql);
	$i=1;
	while($row=mysql_fetch_assoc($res))
	{       
          $_dateStart = date('Y-m-d',strtotime($row['DateStart']));
          $_dateEnd = date('Y-m-d',strtotime($row['DateExpire']));
          $_teaser = $row['TeaserHTML'];
          if ( 210 < strlen( $_teaser ) ) {
            $_40thSpace = strpos( $_teaser, ' ', 210 );
            $_teaserTrimmed = substr( $_teaser, 0, $_40thSpace ).'...';
          } else {
            $_teaserTrimmed = $_teaser;
          }
		echo '<div class="content_holder"></div>';
          echo '<div class="content_holder">
			<div class="pad_content">';
			if($i==1)
				echo '<div class="heading2"><span class="heading2_second"><u>Deals in your area:</u></span></div><wall:br/>';
				
				echo '
                <h4><wall:a href="?page=deal_details2&id='.$row['DealKey'].'">'.$row['Title'].'</wall:a></h4>
                <wall:br/>
                <p>'.$_teaserTrimmed.'</p>
                <wall:br/>
                <div class="strong_blue smaller clr">Valid '.$_dateStart.' to '.$_dateEnd.'</div>
                <wall:br/>
                <div><strong>Price: '.$row['Price'].'</strong></div>
                <wall:br/>
                <wall:a href="?page=deal_details2&id='.$row['DealKey'].'"><img src="'.str_replace( '~~meta~~', 'sat_general_read_more', $request->asset_url() ).'" border="0" class="right" alt="Read more" /></wall:a>
              </div>
            </div>';
			$i++;
	} ?>

<?php } 

else{
$_api = new SAT_v2_API();
$_api_render = new SA_NET_MobiRender();
$_data = $_api->getTopExperiences();
if ($_data ) {
    $_api_render->draw_home( $_data, false );
} else {
    $_api_render->draw_errorDisplay();
}
}
}
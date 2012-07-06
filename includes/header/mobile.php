<head>
	<title><?php echo $request->site->get_title();?></title>
<meta name="Description" content="<?php echo $request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $request->site->get_keywords();?>" />

<META NAME="ROBOTS" CONTENT="ALL" />
<meta name="HandheldFriendly" content="True" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<link id="ctl00_Link1" rel="icon" type="image/x-icon" href="http://images/favicon.ico" />
<link rel="apple-touch-icon" type="image/x-icon" href="http://images/favicon.ico" />
<link type="text/css" rel="stylesheet" href="/css/jquery.mobile-1.1.0.min.css" />
<?php 
    echo utility::mobile_stylesheet($request->get_screen_width_new(), 'css/mobile.css');
?>
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.mobile-1.1.0.min.js"></script>
<script type="text/javascript" src="/js/stopwatch.js"></script>
<script type="text/javascript" src="http://www.be-mobile.co.za/framework/js/device.js"></script>
<script type="text/javascript">
$(function(){
  var menuStatus;
  //Trigger menu drop down
  $(document).on("click","img#menuselect",function(){

                           if($('#menu').hasClass('active')) {
                           $('img#menuselect').attr("src", '<?php echo ImagePath;?>menu.png');
                           $('#menu').removeClass('active');
                 
                 $("#menu").animate({
                                    marginLeft: "0px",
                                    }, 300, function(){menuStatus = false});
                 return false;            
                 
                 
                           } else {
                           $('img#menuselect').attr("src",'<?php echo ImagePath;?>menu_active.png');
                           $('#menu').addClass('active');
                 
                 $("#menu").animate({
                                    marginLeft: "25%",
                                    }, 300, function(){menuStatus = true});
                 return false;
                 
                 
                 
                           }
                  });
  
  });
</script>
</head>
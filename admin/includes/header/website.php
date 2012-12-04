<head>
	<title>Commander HQ</title>
	<meta charset="UTF-8">
<meta name="Description" content="<?php echo $Request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $Request->site->get_keywords();?>" />
<meta http-equiv="cache-control" content="private" />
<meta http-equiv="expires" content="Fri, 30 Dec 2011 12:00:00 GMT" />
<script type="text/javascript" src="/admin/js/jquery-1.7.1.min.js"></script>

    <script src="/admin/js/jscal2.js"></script>
    <script src="/admin/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="/admin/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="/admin/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="/admin/css/steel/steel.css" />
<link rel="stylesheet" href="/admin/css/website.css">

<script type="text/javascript">

function OpenThisPage(page)
{
	$('#AjaxLoading').html('<img src="/admin/css/images/ajax-loader.gif" />');
	window.location = page;
}

</script>
<script type="text/javascript">
$( document ).bind( 'mobileinit', function(){
  $.mobile.loader.prototype.options.text = "loading";
  $.mobile.loader.prototype.options.textVisible = false;
  $.mobile.loader.prototype.options.theme = "a";
  $.mobile.loader.prototype.options.html = '<img src="/admin/css/images/ajax-loader.gif" />';
});
</script>
</head>
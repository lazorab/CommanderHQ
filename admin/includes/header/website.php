<head>
	<title>Commander HQ</title>
	<meta charset="UTF-8">
<meta name="Description" content="<?php echo $Request->site->get_description();?>" />
<meta name="Keywords" content="<?php echo $Request->site->get_keywords();?>" />
<meta http-equiv="cache-control" content="private" />
<meta http-equiv="expires" content="Fri, 30 Dec 2011 12:00:00 GMT" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>

<script src="js/jscal2.js"></script>
<script src="js/lang/en.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="nvd3/nv.d3.js"></script>
<script src="nvd3/src/models/linePlusBarChart.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/style_register.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic|Fjalla+One' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="css/steel/steel.css" />
<link href="css/website.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/hot-sneaks/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="css/nv.d3.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
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
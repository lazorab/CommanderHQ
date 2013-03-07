<?php $Height = floor(SCREENWIDTH * 0.717);?>
<script type="text/javascript">
    function GetVideo(filename)
    {
        document.getElementById("videodisplay").innerHTML = '<iframe marginwidth="0px" marginheight="0px" width="<?php echo SCREENWIDTH;?>" height="<?php echo $Height;?>" src="' + filename + '" frameborder="0"></iframe>';
    }
</script>

<div>
<form action="index.php" method="post" name="searchform">
<input type="hidden" name="module" value="videos"/>
<input type="hidden" name="formsubmitted" value="yes"/>
<div style="padding:2%;float:left;width:70%;"><input type="search" results="5" placeholder="Search" name="keyword" value="<?php echo $_REQUEST['keyword'];?>"/></div>
<div style="float:left;margin:8px 0 0 0"><input type="button" name="Submitbtn" value="Go" data-inline="true" onclick="this.form.submit();"/></div>
</form>
</div>
<div class="clear"></div>
<div id="videodisplay"></div>
<?php echo $Display->Html();?>
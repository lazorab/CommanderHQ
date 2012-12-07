<?php
$Overthrow='';
$Device = new DeviceManager;
if($Device->IsGoogleAndroidDevice()) { 
    $Overthrow=' overthrow';?>
        <script src="/js/overthrow.js"></script>
<?php } ?>

<script type="text/javascript">	
    $(function(){
        $('#slides').slides({
            preload: true,
            preloadImage: 'images/ajax-loader.gif',
            generatePagination: true,
            slideSpeed: 500,
            effect: 'slide'
        });
    });    

function getImages(type)
{
    $.getJSON("ajax.php?module=skills",{exercisetype:type},display);
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('#listview').listview();
    $('#listview').listview('refresh');
    $('#exercise').selectmenu();
    $('#exercise').selectmenu('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();	
}

</script>

<br/>
<div id="AjaxOutput">
      <div id="slides">
        <div class="slides_container">
            <div class="slide<?php echo $Overthrow;?>">
                <img alt="Level1" <?php echo $RENDER->NewImage('AthleticLevel1.png');?> src="<?php echo IMAGE_RENDER_PATH;?>AthleticLevel1.png"/><br/><br/>
            </div>
            <div class="slide<?php echo $Overthrow;?>">
                <img alt="Level2" <?php echo $RENDER->NewImage('AthleticLevel2.png');?> src="<?php echo IMAGE_RENDER_PATH;?>AthleticLevel2.png"/><br/><br/>
            </div>
            <div class="slide<?php echo $Overthrow;?>">
                <img alt="Level3" <?php echo $RENDER->NewImage('AthleticLevel3.png');?> src="<?php echo IMAGE_RENDER_PATH;?>AthleticLevel3.png"/><br/><br/>
            </div>
            <div class="slide<?php echo $Overthrow;?>">
                <img alt="Level4" <?php echo $RENDER->NewImage('AthleticLevel4.png');?> src="<?php echo IMAGE_RENDER_PATH;?>AthleticLevel4.png"/><br/><br/>
            </div>       
        </div>
        <a href="#" class="prev"><img src="<?php echo IMAGE_RENDER_PATH;?>arrow-next.png" width="36" height="36" alt="Arrow Prev"></a>
        <a href="#" class="next"><img src="<?php echo IMAGE_RENDER_PATH;?>arrow-prev.png" width="36" height="36" alt="Arrow Next"></a>
    </div>
</div>
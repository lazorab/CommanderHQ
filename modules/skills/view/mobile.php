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

<br/>
<div id="AjaxOutput">
      <div id="slides">
        <div class="slides_container">
            <div class="slide">
                <img alt="Level1" <?php echo $RENDER->NewImage('Level 2 Hips.png');?> src="<?php echo IMAGE_RENDER_PATH;?>Level 2 Hips.png"/>
            </div>
            <div class="slide">
                <img alt="Level2" <?php echo $RENDER->NewImage('Level 2 Hips.png');?> src="<?php echo IMAGE_RENDER_PATH;?>Level 2 Hips.png"/>
            </div>
            <div class="slide">
                <img alt="Level3" <?php echo $RENDER->NewImage('Level 2 Hips.png');?> src="<?php echo IMAGE_RENDER_PATH;?>Level 2 Hips.png"/>
            </div>
            <div class="slide">
                <img alt="Level4" <?php echo $RENDER->NewImage('Level 2 Hips.png');?> src="<?php echo IMAGE_RENDER_PATH;?>Level 2 Hips.png"/>
            </div>       
        </div>
        <a href="#" class="prev"><img src="<?php echo IMAGE_RENDER_PATH;?>arrow-next.png" width="36" height="36" alt="Arrow Prev"></a>
        <a href="#" class="next"><img src="<?php echo IMAGE_RENDER_PATH;?>arrow-prev.png" width="36" height="36" alt="Arrow Next"></a>
    </div>
</div>
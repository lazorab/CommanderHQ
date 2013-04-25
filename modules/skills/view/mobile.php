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

function getCategories(thislevel)
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=skills\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=skills',data:{level:thislevel},dataType:"html",success:display});    
}

function getSkills(cat, thislevel)
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=skills\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
    $.ajax({url:'ajax.php?module=skills',data:{category:cat, level:thislevel},dataType:"html",success:display});    
}

function display(data)
{
    var el = $('#AjaxOutput');
    $('#AjaxOutput').html(data);
    $('#toplist').listview();
    $('#toplist').listview('refresh');
    $('#exercise').selectmenu();
    $('#exercise').selectmenu('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
    el.find('div[data-role=collapsible]').collapsible({theme:'c',refresh:true}); 
}

</script>

<br/>
<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>
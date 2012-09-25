<script type="text/javascript">	

function getBaseline()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=baseline\');" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>');
    $('#toplist').html('<li>Baseline</li>');
    $.getJSON("ajax.php?module=baseline",{baseline:'Baseline'},display);
    $('#toplist').listview();
    $('#toplist').listview('refresh');
}

function getBenchmark(id)
{
    $.getJSON("ajax.php?module=baseline",{benchmark:id},display);
}

function getContent(selection)
{
    $.getJSON("ajax.php?module=baseline",{baseline:selection},display);
}

function getCustomExercise(id)
{
    $.getJSON("ajax.php?module=baseline",{customexercise:id, baseline:'custom'},display);
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('#listview').listview();
    $('#listview').listview('refresh');
    $("input").checkboxradio ();
    $("input").closest ("div:jqmData(role=controlgroup)").controlgroup ();
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
}

$(function() {
  var scntDiv = $('#p_scents');
  var i = $('#p_scents p').size() + 1;
  $('#newcount').value = i;
  $('#addScnt').live('click', function() {
                     $('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="newattribute_' + i +'" value="" placeholder="Attribute Name" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
                     i++;
                     return false;
                     });
  
  $('#remScnt').live('click', function() {
                     if( i > 1 ) {
                     $(this).parents('p').remove();
                     i--;
                     }
                     return false;
                     });
});

function baselinesubmit()
{
    $.getJSON('ajax.php?module=baseline', $("#baselineform").serialize(),display);
    window.location.hash = '#message';
}

</script>
<br/>

<div id="AjaxOutput">  
    <?php echo $Display->Output();?>
</div>

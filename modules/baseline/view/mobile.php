<script type="text/javascript">
$(document).ready(function () {
                  var curr = new Date().getFullYear();
                  var opt = {}
                  opt.select = {preset : 'select'};
                  opt.datetime = { preset : 'datetime', dateOrder: 'ddMMyy', timeWheels: '', dateFormat: 'dd/mm/yy', timeFormat: ''  };
                  
                  $('#datetime').scroller($.extend(opt['datetime'], { theme: 'default', mode: 'scroller', display: 'model' }));
                  $('#baselineselect').scroller($.extend(opt['select'], { theme: 'default', mode: 'scroller', display: 'model' }));
                  $('#newbaseline').scroller($.extend(opt['select'], { theme: 'default', mode: 'scroller', display: 'model' }));
                  $('#benchmark').scroller($.extend(opt['select'], { theme: 'default', mode: 'scroller', display: 'model' }));
                  $('#customtype').scroller($.extend(opt['select'], { theme: 'default', mode: 'scroller', display: 'model' }));

});	

function getBaseline(catid)
{
    $.getJSON("ajax.php?module=baseline",{catid:catid},maindisplay);
}

function getCustomContent(baseline)
{
    $.getJSON("ajax.php?module=baseline",{baselineselect:baseline},topdisplay);
}

function topdisplay(data)
{
	document.getElementById("topselection").innerHTML = data;
}

function maindisplay(data)
{
	document.getElementById("Baseline").innerHTML = data;
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

</script>
<br/>
<div id="topselection">
    <?php echo $Display->TopSelection();?>
</div>

<div id="Baseline">       
    <?php echo $Display->Output();?>
</div>

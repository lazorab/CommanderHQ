<script type="text/javascript">	

function getBaseline(catid)
{
    $.getJSON("ajax.php?module=baseline",{catid:catid},display);
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

</script>
<br/>
<div id="topselection">
<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
<li><a href="" onclick="getContent('Custom');">Custom</a></li>
<li><a href="" onclick="getContent('Baseline');">Baseline</a></li>
<li><a href="" onclick="getContent('Benchmark');">Benchmarks</a></li>	
</ul>
</div>

<div id="AjaxOutput">       
    <?php echo $Display->Output();?>
</div>

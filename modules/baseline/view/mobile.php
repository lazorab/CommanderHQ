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

                  });	

function getBaseline(catid)
{
    $.getJSON("ajax.php?module=baseline",{catid:catid},display);
}

function display(data)
{
	document.getElementById("Baseline").innerHTML = data;
}

</script>

<div id="content">
    <div id="Baseline">
        <?php echo $Display->Output();?>
    </div>
</div>

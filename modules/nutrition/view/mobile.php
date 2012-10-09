<script type="text/javascript">
$(document).ready(function () {
                  var curr = new Date().getFullYear();
                  var opt = {}
                  opt.datetime = { preset : 'datetime', dateOrder: 'ddMMyy',  dateFormat: 'dd/mm/yy', timeFormat: 'HH:ii:ss', timeWheels: 'HHii'  };
                  $('#datetime').scroller($.extend(opt['datetime'], { theme: 'default', mode: 'scroller', display: 'model' }));
});
</script>

<br/>
<h3>Nutrition</h3>
<?php if($Display->Message != ''){?>
<div style="background-color:RED;color:#fff;font-weight:bold;padding:1%;width:75%">* <?php echo $Display->Message;?></div>
<?php } ?>
<form name="foodlog" action="index.php" method="post">
<input type="hidden" name="module" value="nutrition"/>
What did you eat?<br/>
<textarea name="meal" rows="5" cols="15"></textarea><br/>
When?<br/>
<input id="datetime" type="text" name="mealtime" value="<?php echo date('d/m/Y H:i:s');?>"/>
<br/><br/>
<input type="submit" name="save" value="Save"/>
</form>
<br/>
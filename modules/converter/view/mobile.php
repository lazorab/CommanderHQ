<script type="text/javascript">	

function getForm(cat)
{
    $.getJSON("ajax.php?module=converter",{topselection:cat},topselectiondisplay);
}

function getMetricValue(cat,value)
{
    $.getJSON("ajax.php?module=converter",{category:cat,imperial:value},display);
}

function getImperialValue(cat,value)
{
    $.getJSON("ajax.php?module=converter",{category:cat,metric:value},display);
}

function topselectiondisplay(data)
{
    $('#topselection').html(data); 
    $('#AjaxOutput').html('');
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

<div id="content">
<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
    <li><a href="#" onclick="getForm('1')">Weight</a></li>
    <li><a href="#" onclick="getForm('2')">Height</a></li>
    <li><a href="#" onclick="getForm('3')">Distance</a></li>
    <li><a href="#" onclick="getForm('4')">Volume</a></li>
</ul>
<div id="topselection">

</div> 

<div id="AjaxOutput">

</div>
</div>
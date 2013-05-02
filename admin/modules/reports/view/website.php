
<script type="text/javascript">

function getMembers()
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{report:'Members'},dataType:"html",success:display});
}

function getMember(id)
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{AthleteId:id},dataType:"html",success:display});
}

function getWods()
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{report:'Wods'},dataType:"html",success:display});
}

function getWod(id)
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{WodId:id},dataType:"html",success:display});
}

function getActivities()
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{report:'Activities'},dataType:"html",success:display});
}

function getActivity(id)
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{ActivityId:id},dataType:"html",success:display});
}

function display(data)
{
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('#AjaxOutput').html(data);
}

function go(url)
{
    window.location = url;
}

</script>
<br/>
<div id="AjaxOutput">
<?php echo $Display->Output();?>
</div>
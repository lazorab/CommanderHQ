<script type="text/javascript">

function Continue()
{
    $.ajax({url:'ajax.php?module=terms&action=validateform',data:$("#terms").serialize(),dataType:"html",success:messagedisplay});  
}

function messagedisplay(message)
{
    if(message.length > 2)
         alert(message);
    else    
         window.location = '?module=memberhome'; 
}

</script>
<br/>
<?php echo $Display->Message;?>
<h2>Terms and Conditions</h2>
<form action="index.php" id="terms">
    <input type="hidden" name="module" value="terms"/>
<div data-role="fieldcontain">
 	<fieldset data-role="controlgroup">
		<input id="checkbox-1" type="checkbox" name="TermsAccepted" value="yes"/>
		<label for="checkbox-1">I have read and agree to Terms and Conditions</label>
    </fieldset>
</div>
<br/>           
<input class="buttongroup" type="button" onClick="Continue();" value="Continue"/>
<br/>
</form>
<div class="clear"></div>
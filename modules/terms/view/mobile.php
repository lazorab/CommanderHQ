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

<div id="AjaxOutput">
<h2>TERMS AND CONDITIONS</h2>
<form action="index.php" id="terms">
		<input data-role="none" id="checkbox-1" type="checkbox" name="TermsAccepted" value="yes"/>
		<label for="checkbox-1">I have read and agree to Terms and Conditions</label>
<br/><br/>           
<input class="buttongroup" type="button" onClick="Continue();" value="Continue"/>
</form><br/><br/>
</div>
<div class="clear"></div>
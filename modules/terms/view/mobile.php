<script type="text/javascript">

function Continue(status)
{
    $.getJSON('ajax.php?module=terms&action=validateform', {status:status},messagedisplay);
}

function messagedisplay(message)
{
    if(message == 'Continue')
        window.location = '?module=memberhome';
    else    
        alert(message);   
}

</script>

<h2>Terms and Conditions</h2>
<form id="terms">
<div data-role="fieldcontain">
 	<fieldset data-role="controlgroup">
		<input type="checkbox" name="Terms" id="checkbox-1" class="custom" />
		<label for="checkbox-1">I have read and agree to Terms and Conditions</label>
    </fieldset>
</div>
<br/>           
<input class="buttongroup" type="button" onClick="Continue(Terms.value);" value="Continue"/>
<br/>
</form>
<div class="clear"</div>
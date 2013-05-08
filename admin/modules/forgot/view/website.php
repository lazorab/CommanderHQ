<script type="text/javascript">

function forgotsubmit()
{
    $.ajax({url:'ajax.php?module=forgot&action=formsubmit',data:$("#forgotform").serialize(),dataType:"html",success:display});
}

function display(message)
{
    if(message == 'Success'){
        alert('You have been sent an email with your login details');
        window.location = 'index.php?module=login';
    }else{
        alert(message);
    }
}
</script>

<br/>

<div id="AjaxOutput">
<br/>
            <form action="index.php" name="forgot" id="forgotform" method="post">
            <input type="email" name="email" placeholder="Email Address"/>
            <input type="button" onClick="forgotsubmit();" value="Submit"/>
            </form>
</div>
<script type="text/javascript">

function contactsubmit()
{
    $.getJSON('ajax.php?module=contact&action=validateform', $("#contactform").serialize(),messagedisplay);
}

function messagedisplay(message)
{
    if(message != 'Success'){
        alert(message);
    }else{
        alert('Sent Successfully - Thank you.');
        window.location = 'index.php?module=memberhome';
    }   
}

</script>

<br/>

<div id="AjaxOutput">
<p>
This service is developed exclusively for you! 
</p><p>
Our job would not be complete if we have not provided you with the best possible experience.
</p><p>
Rate us here and please feel free to give us your ideas and thoughts on ways that this service could be improved upon.
</p>
            <form action="index.php" name="contact" id="contactform" method="post">
            <input type="hidden" name="module" value="contact"/>
            <input type="hidden" name="form" value="submitted"/>
            <textarea name="Comments" cols="10" rows="20"></textarea>
            <br/>
            <input class="buttongroup" type="button" onClick="contactsubmit();" value="Submit"/>
            </form>
</div>



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
<a href="mailto:info@commanderhq.net?Subject=Information%20request">info@commanderhq.net</a>
</p>
<p>
<a href="mailto:unsubscribe@commanderhq.net?Subject=Information%20request">unsubscribe@commanderhq.net</a>
</p>
<p>
<a href="mailto:subscriptions@commanderhq.net?Subject=Information%20request">subscriptions@commanderhq.net</a>
</p>
<p>
<a href="mailto:stop@commanderhq.net?Subject=Information%20request">stop@commanderhq.net</a>
</p>
<p>
<a href="mailto:finance@commanderhq.net?Subject=Information%20request">finance@commanderhq.net</a>
</p>
<p>
<a href="mailto:support@commanderhq.net?Subject=Information%20request">support@commanderhq.net</a>
</p>
<p>
<a href="mailto:thestore@commanderhq.net?Subject=Information%20request">thestore@commanderhq.net</a>
</p>
</div>



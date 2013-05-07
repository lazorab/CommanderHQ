<script type='text/javascript'>
     $(function() {
function log( message ) {
$( "#gymname" ).val( message );
}
$( "#gymname" ).autocomplete({
source: "ajax.php?module=login&action=getAffiliates",
minLength: 2,
select: function( event, ui ) {
log( ui.item.value );
}
});
});

function validateForm()
{
    var x=document.forms["regForm"]["gymname"].value;
if (x==null || x=="")
  {
  alert("Gym Name required");
  return false;
  }

var x=document.forms["regForm"]["email"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("Not a valid e-mail address");
  return false;
  }else{
      document.regform.submit();
  }
}
</script>
<div style="font-size:large;color:white"><?php echo $Display->Message;?></div>
<br/><br/>

			<div id="content_main">
            	<div class="form form_left">
                    <form name="form" id="form" method="post" action="index.php"> 
                        <input type="hidden" name="module" value="login"/>
                        <input type="hidden" name="action" value="Login"/>
                    	<h2>Sign In</h2>     
                        <div style="padding: 0px 0px 12px 0px;">
                            <div class="form_div"><input id="Username" style="width: 389px;" type="text" name="username" placeholder="Username" value="<?php echo $_REQUEST['username'];?>"/></div>
                        </div>
                        <div style="padding: 0px 0px 12px 0px;">
                            <div class="form_div"><input id="Password" style="width: 389px;" type="password" name="password" placeholder="Password" value="<?php echo $_REQUEST['password'];?>"/></div>
                        </div>
                        <div style="float: right;" id="submit" onClick="document.form.submit();">Sign In</div> 	  
                        <div class="clear">&nbsp;</div>    
                    </form>
                    <p><a href="?module=forgot">Forgotten username/password?</a></p>
            	</div>
                
                <div class="form form_right">
                    <form name="regForm" id="regForm" method="post" action="index.php">
                        <input type="hidden" name="module" value="login"/>
                        <input type="hidden" name="action" value="Register"/>                        
                    	<h2>Register</h2>     
                        <div style="padding: 0px 0px 12px 0px;">
                            <div class="form_div"><input id="Gym Name" style="width: 389px;" type="text" id="gymname" name="gymname" placeholder="Affiliate Gym Name" value="<?php echo $_REQUEST['gymname'];?>"/></div>
                        </div>
                        <div style="padding: 0px 0px 12px 0px;">
                            <div class="form_div"><input id="Location" style="width: 389px;" type="text" name="address" placeholder="Location / Address" value="<?php echo $_REQUEST['address'];?>"/></div>
                        </div>
                        <h2>Contact person for registration:</h2>
                        <div style="padding: 0px 0px 12px 0px;">
                            <div class="form_div"><input id="Name" style="width: 389px;" type="text" name="name" placeholder="Name" value="<?php echo $_REQUEST['name'];?>"/></div>
                        </div>
                        <div style="padding: 0px 0px 12px 0px;">
                            <div class="form_div"><input id="Email" style="width: 389px;" type="text" name="email" placeholder="Email" value="<?php echo $_REQUEST['email'];?>"/></div>
                        </div>
                        <div style="padding: 0px 0px 12px 0px;">
                            <div class="form_div"><input id="Phone" style="width: 389px;" type="text" name="phone" placeholder="Phone" value="<?php echo $_REQUEST['phone'];?>"/></div>
                        </div>
                        <div style="float: right;" id="submit" onClick="validateForm();">Register</div> 	  
                        <div class="clear">&nbsp;</div>    
                    </form>
            	</div>
                <div class="clear">&nbsp;</div>
            </div>

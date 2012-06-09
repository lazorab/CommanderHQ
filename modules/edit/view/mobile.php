<script type="text/javascript">
$(document).ready(function () {
    var curr = new Date().getFullYear();
    var opt = {}
	opt.datetime = { preset : 'datetime', dateOrder: 'ddMMyy', timeWheels: '', dateFormat: 'dd-mm-yy', timeFormat: ''  };

    $('#dob').scroller($.extend(opt['datetime'], { theme: 'default', mode: 'scroller', display: 'model' }));
});
</script>

<?php echo $Display->Message;
$MemberDetails = $Display->MemberDetails();
?>

<br/>
<form action="index.php" method="post">
<div data-role="fieldcontain">
<input type="hidden" name="module" value="edit"/>
<input type="hidden" name="formsubmitted" value="yes"/>
<input type="hidden" name="UserId" value="<?php echo $MemberDetails->UserId;?>"/>
<input type="hidden" name="SystemOfMeasure" value="<?php echo $Display->System;?>"/>
First Name<br/>
<input type="text" name="FirstName" value="<?php echo $MemberDetails->FirstName;?>"/><br/>
Last Name<br/>
<input type="text" name="LastName" value="<?php echo $MemberDetails->LastName;?>"/><br/>
Cell<br/>
<input type="text" name="Cell" value="<?php echo $MemberDetails->Cell;?>"/><br/>
Email<br/>
<input type="text" name="Email" value="<?php echo $MemberDetails->Email;?>"/><br/>
<label for="dob">Date of Birth</label><br/>
	<input type="text" name="dob" id="dob" value="<?php echo date('d-m-Y',strtotime($MemberDetails->DOB));?>"/>	
<br/><br/>
Male<input type="radio" name="Gender" value="M" <?php if($MemberDetails->Gender == 'M') echo 'checked="checked"';?>/>
Female<input type="radio" name="gender" value="F" <?php if($MemberDetails->Gender == 'F') echo 'checked="checked"';?>/>
<br/><br/>
Weight (<?php echo $Display->SystemWeight;?>)<br/>
<input type="text" name="Weight" value="<?php echo $MemberDetails->Weight;?>"/><br/>
Height (<?php echo $Display->SystemHeight;?>)<br/>
<input type="text" name="Height" value="<?php echo $MemberDetails->Height;?>"/><br/>
<br/><br/>
Preferred Sytem of Measurement<br/>
<input type="submit" name="system" value="<?php echo $Display->AlternateSystem;?>"/>
<br/><br/>
<input type="submit" name="submit" value="Save"/><br/><br/>
</div>
</form>

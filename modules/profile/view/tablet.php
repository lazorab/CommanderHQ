<?php echo $Display->Message;
$MemberDetails = $Display->MemberDetails();
?>

<br/><br/>
<form action="index.php" method="post">
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
Username<br/>
<input type="text" name="UserName" value="<?php echo $MemberDetails->UserName;?>"/><br/>
Password<br/>
<input type="password" name="PassWord" value="<?php echo $MemberDetails->Password;?>"/><br/><br/>
Date of Birth<br/>
<select name="Day">
<?php echo $Display->Model()->DayOptions($MemberDetails->Day);?>
</select>
<select name="Month">
<?php echo $Display->Model()->MonthOptions($MemberDetails->Month);?>
</select>
<select name="Year">
<?php echo $Display->Model()->YearOptions($MemberDetails->Year);?>
</select>
<br/><br/>
Male<input type="radio" name="Gender" value="M" <?php if($MemberDetails->Gender == 'M') echo 'checked="checked"';?>/>Female<input type="radio" name="Gender" value="F" <?php if($MemberDetails->Gender == 'F') echo 'checked="checked"';?>/>
<br/><br/>
Weight (<?php echo $Display->SystemWeight;?>)<br/>
<input type="text" name="Weight" value="<?php echo $MemberDetails->Weight;?>"/><br/>
Height (<?php echo $Display->SystemHeight;?>)<br/>
<input type="text" name="Height" value="<?php echo $MemberDetails->Height;?>"/><br/>
<br/><br/>
Preferred Sytem of Measurement<br/>
<input type="submit" name="system" value="<?php echo $Display->AlternateSystem;?>"/>
<br/><br/>
<input type="submit" name="submit" value="Save"/>
</form>
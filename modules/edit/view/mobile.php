<div id="menu" style="width:30%;float:left">
<div id="menuitem" style="margin:5%">
	<img alt="Register" src="<?php echo $RENDER->Image('register_active.png', $request->get_screen_width_new());?>"/>
</div>
<div id="menuitem" style="margin:5%">	
	<a href="?module=registergym"><img alt="GymRegister" src="<?php echo $RENDER->Image('registergym.png', $request->get_screen_width_new());?>"/></a>
</div>
<div id="menuitem" style="margin:5%">
	<a href="?module=goals"><img alt="Goals" src="<?php echo $RENDER->Image('goals.png', $request->get_screen_width_new());?>"/></a>
</div>
</div>

<?php echo $Display->Message;
$MemberDetails = $Display->MemberDetails();
?>
<div id="content" style="width:70%;float:left;color:#fff">
<wall:br/>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="module" value="edit"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
<wall:input type="hidden" name="UserId" value="<?php echo $MemberDetails->UserId;?>"/>
<wall:input type="hidden" name="SystemOfMeasure" value="<?php echo $Display->System;?>"/>
First Name<wall:br/>
<wall:input type="text" name="FirstName" value="<?php echo $MemberDetails->FirstName;?>"/><wall:br/>
Last Name<wall:br/>
<wall:input type="text" name="LastName" value="<?php echo $MemberDetails->LastName;?>"/><wall:br/>
Cell<wall:br/>
<wall:input type="text" name="Cell" value="<?php echo $MemberDetails->Cell;?>"/><wall:br/>
Email<wall:br/>
<wall:input type="text" name="Email" value="<?php echo $MemberDetails->Email;?>"/><wall:br/>
Username<wall:br/>
<wall:input type="text" name="UserName" value="<?php echo $MemberDetails->UserName;?>"/><wall:br/>
Password<wall:br/>
<wall:input type="password" name="PassWord" value="<?php echo $MemberDetails->Password;?>"/><wall:br/><wall:br/>
Date of Birth<wall:br/>
<wall:select name="Day">
<?php echo $Display->Model()->DayOptions($MemberDetails->Day);?>
</wall:select>
<wall:select name="Month">
<?php echo $Display->Model()->MonthOptions($MemberDetails->Month);?>
</wall:select>
<wall:select name="Year">
<?php echo $Display->Model()->YearOptions($MemberDetails->Year);?>
</wall:select>
<wall:br/><wall:br/>
Male<wall:input type="radio" name="Gender" value="M" <?php if($MemberDetails->Gender == 'M') echo 'checked="checked"';?>/>Female<input type="radio" name="gender" value="F" <?php if($MemberDetails->Gender == 'F') echo 'checked="checked"';?>/><wall:br/>
<wall:br/><wall:br/>
Weight (<?php echo $Display->SystemWeight;?>)<wall:br/>
<wall:input type="text" name="Weight" value="<?php echo $MemberDetails->Weight;?>"/><wall:br/>
Height (<?php echo $Display->SystemHeight;?>)<wall:br/>
<wall:input type="text" name="Height" value="<?php echo $MemberDetails->Height;?>"/><wall:br/>
<wall:br/><wall:br/>
Preferred Sytem of Measurement<br/>
<wall:input type="submit" name="system" value="<?php echo $Display->AlternateSystem;?>"/>
<wall:br/><wall:br/>
<wall:input type="submit" name="submit" value="Save"/><wall:br/><wall:br/>
</wall:form>
</div>
<div class="clear"></div>
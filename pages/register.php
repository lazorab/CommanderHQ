<?php
$Validate = new ValidationUtils;
$ErrorMessage = '';
$DropDown = new DropDownMenu;
if($_REQUEST['formsubmitted'] == 'yes')
{
	if($_REQUEST['firstname'] == '')
		$ErrorMessage = 'Firstname Required';
	elseif($_REQUEST['lastname'] == '')
		$ErrorMessage = 'Lastname Required';
	elseif($_REQUEST['cell'] == '' && $_REQUEST['email'] == '')
		$ErrorMessage = 'Either a Cell or Email Required';
	elseif($_REQUEST['cell'] != '' && !$Validate->CheckMobileNumber($_REQUEST['cell']))
		$ErrorMessage = 'Cell number invalid!';
	elseif($_REQUEST['email'] != '' && !$Validate->CheckEmailAddress($_REQUEST['email']))
		$ErrorMessage = 'Email Address invalid!';
	elseif($_REQUEST['username'] == '')
		$ErrorMessage = 'Username Required';		
	elseif($_REQUEST['password'] == '')
		$ErrorMessage = 'Password Required';
	elseif($_REQUEST['day'] == '')
		$ErrorMessage = 'Invalid Date of Birth';		
	elseif($_REQUEST['month'] == '')
		$ErrorMessage = 'Invalid Date of Birth';
	elseif($_REQUEST['year'] == '')
		$ErrorMessage = 'Invalid Date of Birth';		
	elseif($_REQUEST['weight'] == '')
		$ErrorMessage = 'Weight Required';
	elseif($_REQUEST['height'] == '')
		$ErrorMessage = 'Height Required';
	elseif($_REQUEST['gender'] == '')		
		$ErrorMessage = 'Select Gender';
		
	if($ErrorMessage == '')
	{
		$_CREDENTIALS=array(
			'FirstName'=>''.$_REQUEST['firstname'].'',
			'LastName'=>''.$_REQUEST['lastname'].'',
			'Cell'=>''.$_REQUEST['cell'].'',
			'Email'=>''.$_REQUEST['email'].'',		
			'UserName'=>''.$_REQUEST['username'].'',
			'PassWord'=>''.$_REQUEST['password'].'',
			'DOB'=>''.$_REQUEST['year'].'-'.$_REQUEST['month'].'-'.$_REQUEST['day'].'',
			'Weight'=>''.$_REQUEST['weight'].'',
			'Height'=>''.$_REQUEST['height'].'',
			'Gender'=>''.$_REQUEST['gender'].'',
			'Goals'=>''.serialize($_REQUEST['goals']).'');		
		$Register = new Register($_CREDENTIALS);
		if(!$Register->ReturnValue){
			$ErrorMessage = 'Member already exists, Please try again.';
		}
		else{
			$_SESSION['UID'] = $Register->ReturnValue;
			header('location: index.php?page=memberhome');
		}
	}
	if($ErrorMessage != ''){
		echo '<wall:br/>'.$ErrorMessage.'';
	}
}
?>
<wall:br/><wall:br/>
<wall:form action="index.php" method="post">
<wall:input type="hidden" name="page" value="register"/>
<wall:input type="hidden" name="formsubmitted" value="yes"/>
First Name<wall:br/>
<wall:input type="text" name="firstname" value="<?php echo $_REQUEST['firstname'];?>"/><wall:br/>
Last Name<wall:br/>
<wall:input type="text" name="lastname" value="<?php echo $_REQUEST['lastname'];?>"/><wall:br/>
Cell<wall:br/>
<wall:input type="text" name="cell" value="<?php echo $_REQUEST['cell'];?>"/><wall:br/>
Email<wall:br/>
<wall:input type="text" name="email" value="<?php echo $_REQUEST['email'];?>"/><wall:br/>
Username<wall:br/>
<wall:input type="text" name="username" value="<?php echo $_REQUEST['username'];?>"/><wall:br/>
Password<wall:br/>
<wall:input type="password" name="password" value="<?php echo $_REQUEST['password'];?>"/><wall:br/><wall:br/>
Date of Birth<wall:br/>
<wall:select name="day">
<?php echo $DropDown->DayOptions($_REQUEST['day']);?>
</wall:select>
<wall:select name="month">
<?php echo $DropDown->MonthOptions($_REQUEST['month']);?>
</wall:select>
<wall:select name="year">
<?php echo $DropDown->YearOptions($_REQUEST['year']);?>
</wall:select>
<wall:br/>
Weight (kg)<wall:br/>
<wall:input type="text" name="weight" value="<?php echo $_REQUEST['weight'];?>"/><wall:br/>
Height (meters)<wall:br/>
<wall:input type="text" name="height" value="<?php echo $_REQUEST['height'];?>"/><wall:br/>
Gender<wall:br/>
Male<wall:input type="radio" name="gender" value="M" <?php if($_REQUEST['gender'] == 'M') echo 'checked="checked"';?>/>Female<wall:input type="radio" name="gender" value="F" <?php if($_REQUEST['gender'] == 'F') echo 'checked="checked"';?>/><wall:br/>
<wall:input type="submit" name="submit" value="Submit"/><wall:br/><wall:br/>
</wall:form>
<?php
/********************************************************
Local class to handle all utility functions
Copyright Be-Mobile

Created By   : Brett Spence
Created Date : 30 September 2008

Last Modified Date: 30 September 2008

*********************************************************/


class utility extends utility_base
{
	public static function get_formatted_date($timestamp)
	{
		$year = substr($timestamp, 0, 4);
		$day = substr($timestamp, 6, 2);
		switch (substr($timestamp, 4, 2))
		{
			case '01':
				$month = 'January';
				break;
			case '02':
				$month = 'February';
				break;
			case '03':
				$month = 'March';
				break;
			case '04':
				$month = 'April';
				break;
			case '05':
				$month = 'May';
				break;
			case '06':
				$month = 'June';
				break;
			case '07':
				$month = 'July';
				break;
			case '08':
				$month = 'August';
				break;
			case '09':
				$month = 'September';
				break;
			case '10':
				$month = 'October';
				break;
			case '11':
				$month = 'November';
				break;
			case '12':
				$month = 'December';
				break;
		}
		return $day.' '.$month.' '.$year;
	}

	public static function today()
	{
		return date("Y", time()).date("m", time()).date("d", time());
	}

	public static function draw_upload_form()
	{
		$content = new content('preupload');
		$content->draw();
		print('<form enctype="multipart/form-data" action="index.php" method="post">');
		print('<wall:input type="hidden" name="MAX_FILE_SIZE" value="600000000" />');
		print('<wall:input type="hidden" name="form" value="upload" />');
		print('Title:<wall:br /><wall:input type="text" name="title" /><wall:br />');
		print('Description:<wall:br /><textarea rows="6" cols="18" name="description"></textarea><wall:br />');
		print('Search Tags:<wall:br /><wall:input type="text" name="tags" /><wall:br />');
		print('Audition Song:<wall:br /><wall:select name="Moto_Video_Song">');
		utility::draw_attribute('Moto_Video_Song', '', false);
		print('</wall:select><wall:br />');
		print('Video:<wall:br /><wall:input name="userfile" type="file" /><wall:br /><wall:br />');
		print('<wall:input type="submit" value="Upload My Audition" /><wall:br /><wall:br />');
		print('</form>');
	}	
}

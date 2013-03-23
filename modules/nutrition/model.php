<?php
class NutritionModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
	}
    
    function Log()
    {
        $SQL='INSERT INTO FoodLog(MemberId, Meal, MealTime) 
        Values("'.$_COOKIE['UID'].'", "'.$_REQUEST['meal'].'", "'.date_format(date_create(strtotime($_REQUEST['mealtime'])), 'Y-m-d H:i:s').'")';
        mysql_query($SQL);
    }
	
}
?>
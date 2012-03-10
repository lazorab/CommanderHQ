<?php
class ProductsModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function InsertProduct($_DETAILS)
	{
		$FIELDS = '';
		$VALUES = '';
		$i = 0;
		foreach($_DETAILS AS $key=>$val) 
		{
			if($i > 0)
			{
				$FIELDS .= ',';
				$VALUES .= ',';
			}
				$FIELDS .= $key;
				$VALUES .= '"'.$val.'"';
			$i++;
		}
		$SQL = 'INSERT INTO BenchmarkWorkouts('.$FIELDS.') VALUES('.$VALUES.')';
		mysql_query($SQL);	
	}
	
	function GetProducts($_SEARCH)
	{
		$Workouts = array();
		$SQL = 'SELECT recid, WorkoutName, WorkoutDescription, VideoId FROM BenchmarkWorkouts';
		if(isset($_SEARCH['searchword']))
			$SQL .= 'WHERE WorkoutName LIKE "'.$_SEARCH['searchword'].'%"';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Workouts, new BenchmarkObject($Row));
		}
		return $Workouts;
	}	
	
	function GetProductDetails($Id)
	{
		$SQL = 'SELECT WorkoutName, WorkoutDescription, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Workout = new BenchmarkObject($Row);
		
		return $Workout;
	}		
}

class ProductObject
{
	var $Id;
	var $ProductName;
	var $ProductDescription;
	var $ProductImage;
	var $ProductPrice;
	var $Category;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->ProductName = $Row['ProductName'];
		$this->ProductDescription = $Row['ProductDescription'];
		$this->ProductImage = $Row['ProductImage'];
		$this->ProductPrice = $Row['ProductPrice'];
		$this->Category = $Row['Category'];
	}
}
?>
<?php
class RecipesModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function getRecipes($_SEARCH)
	{
		$Recipes = array();
		$SQL = 'SELECT recid, Title, Recipe FROM Recipes';
		if(isset($_SEARCH['searchword']))
			$SQL .= 'WHERE Title LIKE "'.$_SEARCH['searchword'].'%"';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Recipes, new RecipeObject($Row));
		}
		return $Recipes;
	}	
	
	function GetRecipe($Id)
	{
		$SQL = 'SELECT recid, Title, Recipe FROM Recipes WHERE recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Recipe = new RecipeObject($Row);
		
		return $Recipe;
	}	

	function getFoodItems()
	{
		$FoodItems = array();
		$Sql = 'SELECT recid, FoodName FROM FoodItems';
		$Result = mysql_query($Sql);
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($FoodItems, new FoodItems($Row));
		}	
		return $FoodItems;
	}
}

class RecipeObject
{
	var $recid;
	var $Title;
	var $Recipe;

	function __construct($Row)
	{
		$this->recid = $Row['recid'];
		$this->Title = $Row['Title'];
		$this->Recipe = $Row['Recipe'];
	}
}

class FoodItems
{
	var $recid;
	var $FoodName;

	function __construct($Row)
	{
		$this->recid = $Row['recid'];
		$this->FoodName = $Row['FoodName'];
	}
}
?>
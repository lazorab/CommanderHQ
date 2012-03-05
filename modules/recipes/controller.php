<?php
class RecipesController extends Controller
{
	var $Model;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');	
		$this->Model = new RecipesModel;
	}
	
	function html()
	{
		$html='';
		
		if(isset($_REQUEST['id']))
		{
			$Recipe = $this->Model->getRecipe($_REQUEST['id']);
			$FormattedText = $this->getFormattedText($Recipe->Recipe);
			$html.='<h3>'.$Recipe->Title.'</h3>';
			$html.='<p>'.$FormattedText.'</p>';
		}
		else
		{
			$Recipes = $this->Model->getRecipes($_REQUEST);
			foreach($Recipes as $Recipe)
			{
				$html.='<h3><a href="index.php?module=recipes&id='.$Recipe->recid.'">'.$Recipe->Title.'</a></h3>';
			}
		}	
		return $html;
	}
	
	private function getFormattedText($unFormattedText)
	{
		$FormattedText = '';
		$Search = array();
		$Replace = array();
		$FoodItems = $this->Model->getFoodItems();
		foreach($FoodItems as $Item)
		{
			array_push($Search, '{'.$Item->FoodName.'}');
			array_push($Replace, '<a href="?module=foodlog&id='.$Item->recid.'">'.$Item->FoodName.'</a>');
		}
		$Text = str_replace('{br}','<br/>',$unFormattedText);
		$FormattedText = str_replace($Search,$Replace,$Text);
		return $FormattedText;
	}
	
	function CustomHeader()
	{
		$CustomHeader='';
		
		return $CustomHeader;
	}
}
?>
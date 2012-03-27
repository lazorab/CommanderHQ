<?php
class ShoppingbasketModel extends Model
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
	
	function getShoppingBasket()
	{
		$Items = array();
		$SQL = 'SELECT P.recid, P.ProductName, P.ProductDescription, P.ProductImage, P.ProductPrice, PC.ProductCategory 
			From Products P JOIN ProductCategories PC ON PC.recid = P.CategoryId';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Items, new BasketObject($Row));
		}
		return $Items;
	}	
	

class BasketObject
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
		$this->Category = $Row['ProductCategory'];
	}
}
?>
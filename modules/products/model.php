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
		$SQL = 'INSERT INTO Products('.$FIELDS.') VALUES('.$VALUES.')';
		mysql_query($SQL);	
	}
	
	function GetCategories()
	{
		$Categories = array();
		$SQL = 'SELECT recid, ProductCategory From ProductCategories';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Categories, new CategoryObject($Row));
		}
		return $Categories;
	}
	
	function GetProducts($_SEARCH)
	{
		$Products = array();
		$SQL = 'SELECT P.recid, P.ProductName, P.ProductDescription, P.ProductImage, P.ProductPrice, PC.ProductCategory 
			From Products P JOIN ProductCategories PC ON PC.recid = P.CategoryId';
		if(isset($_SEARCH['searchword']))
			$SQL .= 'WHERE P.ProductName LIKE "'.$_SEARCH.'%"';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Products, new ProductObject($Row));
		}
		return $Products;
	}	
	
	function GetProductsByCategory($CategoryId)
	{
		$Products = array();
		$SQL = 'SELECT P.recid, P.ProductName, P.ProductDescription, P.ProductImage, P.ProductPrice, PC.ProductCategory 
			From Products P JOIN ProductCategories PC ON PC.recid = P.CategoryId';
		if($CategoryId > 0)
			$SQL .= ' WHERE P.CategoryId = '.$CategoryId.'';
		$Result = mysql_query($SQL);	
		while($Row = mysql_fetch_assoc($Result))
		{
			array_push($Products, new ProductObject($Row));
		}
		return $Products;
	}
	
	function GetProductDetails($Id)
	{
		$SQL = 'SELECT P.recid, P.ProductName, P.ProductDescription, P.ProductImage, P.ProductPrice, PC.ProductCategory 
			From Products P JOIN ProductCategories PC ON PC.recid = P.CategoryId
			WHERE P.recid = '.$Id.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		$Product = new ProductObject($Row);
		
		return $Product;
	}	
	
	function getBasketId($MemberId)
	{
		$SQL='SELECT MAX(BasketId) AS LastId FROM MemberPurchases WHERE MemberId = '.$MemberId.'';
		$Result = mysql_query($SQL);	
		$Row = mysql_fetch_assoc($Result);
		if($Row['LastId'] == null)
			$BasketId = 1;
		else
			$BasketId = $Row['LastId'] + 1;
			
		return $BasketId;
	}

	function AddToBasket($MemberId, $BasketId, $ProductId, $Quantity)
	{
		$Response='';
		$SQL='INSERT INTO MemberPurchases(MemberId, BasketId, ProductId, Quantity) VALUES('.$MemberId.', '.$BasketId.', '.$ProductId.', '.$Quantity.')';
		if(!mysql_query($SQL))
			$Response='Action Failed!';
		else
			$Response='Successfully Added';
		return $Response;
	}
	
	function RemoveFromBasket($ProductId, $Quantity)
	{

	}
}

class CategoryObject
{
	var $Id;
	var $Category;

	function __construct($Row)
	{
		$this->Id = $Row['recid'];
		$this->Category = $Row['ProductCategory'];
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
		$this->Category = $Row['ProductCategory'];
	}
}
?>
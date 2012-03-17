<?php
class ProductsController extends Controller
{
	var $Model;
	var $Html;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_SESSION['UID']))
			header('location: index.php?module=login');
					
		$this->Model = new ProductsModel;
	}
	
	function getHtml()
	{
		if($_REQUEST['form'] != 'submitted')
			$this->Html = $this->getCategories();
		else if($_REQUEST['submit'] == 'Submit')
			$this->Html = $this->getProductsByCategory($_REQUEST['category']);
		else if($_REQUEST['id'] > 0)
			$this->Html = $this->getProductDetails($_REQUEST['id']);
		else if($_REQUEST['submit'] == 'Add to basket')
			$this->Html = $this->ShoppingBasket($_REQUEST['product'], $_REQUEST['quantity'], 'add');
			
		return $this->Html;
	}
	
	function getProducts($_REQUEST)
	{
		$Html='';
		$Products = $this->Model->getProducts($_REQUEST['searchword']);
		foreach($Products AS $Product){
			$Html.=''.$Product->ProductName.'';
		}
		return $Html;
	}
	
	function getProductDetails($Id)
	{
		$Html='';
		$Details = $this->Model->getProductDetails($Id);

		$Html.=''.$Details->ProductName.'<'.$this->Wall.'br/>';
		$Html.=''.$Details->ProductDescription.'<'.$this->Wall.'br/>';
		$Html.=''.$Details->ProductPrice.'<'.$this->Wall.'br/>';
		$Html.='<'.$this->Wall.'img src="'.$Details->ProductImage.'" alt=""/><'.$this->Wall.'br/>';
		$Html.='Quantity:<'.$this->Wall.'select name="quantity">';
		for($i=1;$i<11;$i++){
			$Html.='<'.$this->Wall.'option value="'.$i.'">'.$i.'</'.$this->Wall.'option>';
		}
		$Html.='</'.$this->Wall.'select>';
		$Html.='<'.$this->Wall.'input type="submit" name="submit" value="Add to basket"/>';
		$Html.='<'.$this->Wall.'input type="hidden" name="product" value="'.$Details->Id.'"/>';
		
		return $Html;
	}
	
	function getCategories()
	{
		$Categories = $this->Model->getCategories();
		$Html='<'.$this->Wall.'select name="category">';
		foreach($Categories AS $Category){
			$Html.='<'.$this->Wall.'option value="'.$Category->Id.'">'.$Category->Category.'</'.$this->Wall.'option>';
		}
		$Html.='</'.$this->Wall.'select>';
		$Html.='<'.$this->Wall.'input type="submit" name="submit" value="Submit"/>';
		return $Html;
	}	
	
	function getProductsByCategory($Category)
	{
		$Html='';
		$Products = $this->Model->getProductsByCategory($Category);
		foreach($Products AS $Product){
			$Html.='<'.$this->Wall.'a href="?module=products&form=submitted&id='.$Product->Id.'">'.$Product->ProductName.'</'.$this->Wall.'a>';
		}
		return $Html;
	}
	
	function ShoppingBasket($ProductId, $Quantity, $Action)
	{
		if(!isset($_SESSION['BasketId'])){
			$_SESSION['BasketId'] = $this->Model->getBasketId($_SESSION['UID']);
		}
		
		$Html='';
		if($Action == 'add'){
			$Response = $this->Model->AddToBasket($_SESSION['UID'], $_SESSION['BasketId'], $ProductId, $Quantity);

			$Html.=''.$Response.'';
		}
		else if($Action == 'remove'){
			$this->Model->RemoveFromBasket($_SESSION['UID'], $_SESSION['BasketId'], $ProductId, $Quantity);
		}	
	
		return $Html;
	}
	
	function CheckOut()
	{
		//Process
		
		unset($_SESSION['BasketId']);
	}
	
	function CustomHeader()
	{
		return $CustomHeader;
	}
}
?>
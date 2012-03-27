<?php
class ProductsController extends Controller
{
	var $Model;
	var $Html;
	var $Message;
	
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
		else if($_REQUEST['submit'] == 'Add to basket'){
			$this->ShoppingBasket($_REQUEST['product'], $_REQUEST['quantity'], 'add');
			$this->Html = $this->getCategories();
		}
		else if($_REQUEST['action'] == 'remove'){
			$this->ShoppingBasket($_REQUEST['product'], 0, 'remove');
			$this->Html = $this->ShoppingBasket(0, 0, 'view');	
		}
		else if($_REQUEST['submit'] == 'View basket')
			$this->Html = $this->ShoppingBasket(0, 0, 'view');	
		else if($_REQUEST['submit'] == 'Update Basket'){
			$this->ShoppingBasket(0, 0, 'update');	
			$this->Html = $this->ShoppingBasket(0, 0, 'view');	
		}
		else if($_REQUEST['submit'] == 'Back to Products')
			$this->Html = $this->getCategories();
		else if($_REQUEST['submit'] == 'CheckOut')
			$this->Html = $this->CheckOut();			
			
		return $this->Html;
	}
	
	function getMessage()
	{
		return $this->Message;
	}
	
	function getProducts($_REQUEST)
	{
		$Html='';
		$Products = $this->Model->getProducts($_REQUEST['searchword']);
		foreach($Products AS $Product){
			$Html.=''.$Product->ProductName.'';
		}
		if(!isset($_SESSION['BasketId']))
			$Html.='<'.$this->Wall.'br/><'.$this->Wall.'input type="submit" name="submit" value="View basket"/>';
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
		if(isset($_SESSION['BasketId']))
			$Html.='<'.$this->Wall.'br/><'.$this->Wall.'input type="submit" name="submit" value="View basket"/>';
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
		if(isset($_SESSION['BasketId']))
			$Html.='<'.$this->Wall.'br/><'.$this->Wall.'input type="submit" name="submit" value="View basket"/>';
		return $Html;
	}	
	
	function getProductsByCategory($Category)
	{
		$Html='';
		$Products = $this->Model->getProductsByCategory($Category);
		foreach($Products AS $Product){
			$Html.='<'.$this->Wall.'a href="?module=products&form=submitted&id='.$Product->Id.'">'.$Product->ProductName.'</'.$this->Wall.'a>';
		}
		if(isset($_SESSION['BasketId']))
			$Html.='<'.$this->Wall.'br/><'.$this->Wall.'input type="submit" name="submit" value="View basket"/>';
		return $Html;
	}
	
	function ShoppingBasket($ProductId=0, $Quantity=0, $Action)
	{
		if(!isset($_SESSION['BasketId'])){
			$_SESSION['BasketId'] = $this->Model->getBasketId($_SESSION['UID']);
		}
		
		$Html='';
		if($Action == 'add'){
			$Response = $this->Model->AddToBasket($_SESSION['UID'], $_SESSION['BasketId'], $ProductId, $Quantity);
			$this->Message.=''.$Response.'';
		}
		else if($Action == 'remove'){
			$Response = $this->Model->RemoveFromBasket($_SESSION['UID'], $_SESSION['BasketId'], $ProductId);
			$this->Message.=''.$Response.'';
		}	
		else if($Action == 'update'){
			$Response = $this->Model->UpdateBasket($_SESSION['UID'], $_SESSION['BasketId']);
			$this->Message.=''.$Response.'';
		}		
		else if($Action == 'view'){
			$Basket = $this->Model->ViewBasket($_SESSION['UID'], $_SESSION['BasketId']);
			$Html.='Quantity	ProductName		Unit Price	Total<'.$this->Wall.'br/>';
			$GrandTotal=0;
			foreach($Basket AS $Item)
			{
				$Total = $Item->Quantity * $Item->ProductPrice;
				$GrandTotal = $GrandTotal + $Total;
				$Html.='<'.$this->Wall.'select name="Quantity_'.$Item->ProductId.'">';
				for($i=1;$i<11;$i++){
					$Selected='';
					if($i == $Item->Quantity)
						$Selected = 'selected="selected"';
					$Html.='<'.$this->Wall.'option value="'.$i.'" '.$Selected.'>'.$i.'</'.$this->Wall.'option>';
				}
				$Html.='</'.$this->Wall.'select>';
				$Html.='<'.$this->Wall.'input type="hidden" name="Product_'.$Item->ProductId.'" value="'.$Item->ProductId.'"/>';
				$Html.='	X '.$Item->ProductName.' @ R'.$Item->ProductPrice.'ea	R'.$Total.'	<'.$this->Wall.'a href="index.php?module=products&form=submitted&action=remove&product='.$Item->ProductId.'">remove<'.$this->Wall.'/a><'.$this->Wall.'br/>';
			}
			$Html.='Total:	R'.$GrandTotal.'<'.$this->Wall.'br/>';
			$Html.='<'.$this->Wall.'input type="submit" name="submit" value="CheckOut"/>';
			$Html.='<'.$this->Wall.'input type="submit" name="submit" value="Update Basket"/>';
			$Html.='<'.$this->Wall.'input type="submit" name="submit" value="Back to Products"/>';
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
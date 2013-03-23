<?php
class ShoppingbasketController extends Controller
{
	var $Model;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(!isset($_COOKIE['UID']))
			header('location: index.php?module=login');
					
		$this->Model = new ShoppingbasketModel;
		if($_REQUEST['form'] != 'submitted'){
			if($_REQUEST['action'] != 'Check Out'){
			
                        }else if($_REQUEST['action'] != 'Back to Products'){
                            
                        }
		}
	}
	
	function ShoppingBasket()
	{
		$Html='';
		$Total = 0;
		$BasketItems = $this->Model->getShoppingBasket();
		
		foreach($BasketItems AS $Item){
			$Html.=''.$Item->Quantity.' X
				'.$Item->Name.' @
				'.$Item->Price.' ea <br/>';
			$Total = $Total + ($Item->Price * $Item->Quantity);
		}
		$Html.='Total:'.$Total.'';
		
		return $Html;
	}
	
	function CustomHeader()
	{
		return $CustomHeader;
	}
}
?>
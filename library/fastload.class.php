<?php
/********************************************************
Local class to Load data from db instead of calling api
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 17 August 2011

Last Modified Date: 17 August 2011

*********************************************************/


class Fastload
{
	function __construct()
	{
		mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die( "Unable to select database");		
	}

    function getFastPrices() {	

        $results = array();
		$sql='SELECT MaxPrice FROM DealsMaxPrice ORDER BY CreatedDate DESC LIMIT 1';
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		$maxPrice = $row['MaxPrice'];

        $incr = 5000; // we always start at 5000

        $int = ceil($maxPrice / $incr);
        $min = '0';
        $max = $min + $incr;
        for ($i = 0; $i < $int; $i++) {

            $results[$i]['val'] = 'between ' . $min . ' and ' . $max . '';
            $results[$i]['disp'] = SAT_DEFAULT_CURRENCY_SYMBOL . $min . ' - ' . SAT_DEFAULT_CURRENCY_SYMBOL . $max . '';
            $min = $min + $incr;
            $max = $max + $incr;
        }

        return $results;
    }	
	
	function getFastPackages()
	{
		$results=array();
  		$sql='SELECT EnglishName FROM PackagesLanguage';
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
            array_push($results, new Dropdowns($row));	
		}
		return $results;
	}
	
	function getFastExperiences()
	{
		$results=array();
  		$sql='SELECT EnglishName FROM ExperiencesLanguage';
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
            array_push($results, new Dropdowns($row));	
		}
		return $results;
	}	

    public function getFastProvinces() {

        $results = array();	
		$sql='SELECT Province FROM DealsProvinces';
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			array_push($results, new FastProvince($row));	
		}
        return $results;
    }		
}


class Dropdowns {

    public $Value;
    public $Description;

    function __construct($Row) {
        $this->Value = $Row['EnglishName'];
        $this->Description = $Row['EnglishName'];
    }
}

class FastProvince {

    public $Id;
    public $Name;

    function __construct($Row) {
        $this->Id = $Row['Province'];
        $this->Name = $Row['Province'];
    }
}

class FastLastestDeal {

    public $Id;
    public $ExpireAt;
    public $Name;
    public $Teaser;
    public $ValidFrom;
    public $Value;
    public $ValueDescription;
    public $CurrencyDisplaySymbol;
    public $Province;
    public $PartnerTelNo;
    public $FromAPI;

    function __construct($aData) {

		$chars = array("\r\n", "\n", "\r");
		$validate = new ValidationUtils;
		
        $this->Id = $aData["id"];
        $this->ExpireAt = date('Y-m-d', strtotime($aData["DateExpire"]));
        $this->Name = $aData["Title"];
        $this->Teaser = $aData["TeaserHTML"];
        $this->ValidFrom = date('Y-m-d', strtotime($aData["DateStart"]));
        $this->Value = $aData["Price"];
		$this->ValueDescription = $aData["ValueDescription"];
        $this->CurrencyDisplaySymbol = SAT_DEFAULT_CURRENCY_SYMBOL;
        $this->Province = $aData["Province"];
        $this->PartnerTelNo = $validate->GeneralNumberCheck($aData["PartnerTelNo"]);
		$this->FromAPI = $aData["FromAPI"];
    }
}

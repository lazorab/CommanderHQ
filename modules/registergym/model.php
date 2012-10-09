<?php
class RegistergymModel extends Model
{
	var $ReturnValue;
	var $Wall='';
	
	function __construct()
	{
        mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        @mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");	
	}
/*	
	function Register()
	{
	    mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
		@mysql_select_db(DB_CUSTOM_DATABASE) or die("Unable to select database");
		$sql='SELECT * FROM RegisteredGyms WHERE GymName = "'.$_REQUEST['gymname'].'" OR URL = "'.$_REQUEST['url'].'"';
		$result = mysql_query($sql);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			$GymId = $row['recid'];
			$message = "Gym has been added to your profile";
		}else{
			$sql="INSERT INTO RegisteredGyms(GymName,
				Country,
				Region,
				Email,
				TelNo,
				FeedURL,
                                WebURL) 
				VALUES('".$_REQUEST['gymname']."',
				'".$_REQUEST['country']."',
				'".$_REQUEST['region']."',
				'".$_REQUEST['email']."',
				'".$_REQUEST['tel']."',
                                '".$_REQUEST['feedurl']."',    
				'".$_REQUEST['weburl']."')";

			if(!mysql_query($sql)){
				$message = "Failed to register!";
			}
			else{
				$GymId = mysql_insert_id();
				$message = "Success";
			}
			
			$sql='Update MemberDetails
				SET GymId = "'.$GymId.'"
				WHERE MemberId = "'.$_SESSION['UID'].'"';

			mysql_query($sql);				
		}
		return $message;
	}
  */
        function Register(){
            $Query = 'Update MemberDetails
		SET GymId = "'.$_REQUEST['AffiliateId'].'"
                WHERE MemberId = "'.$_SESSION['UID'].'"';  
            mysql_query($Query);
            return 'Success';
        }
        
        function getAffiliates() {
            $Affiliates = array();
        
            $Query = 'SELECT AffiliateId,
            GymName
            FROM Affiliates
            WHERE GymName <> ""
            ORDER BY GymName';
            $Result = mysql_query($Query);
            while($Row = mysql_fetch_assoc($Result)){
                array_push($Affiliates, new Affiliate($Row));
            } 
            return $Affiliates;
    }
}

 class Affiliate {

    var $AffiliateId;
    var $GymName;
    var $URL;
    var $Address;
    var $City;
    var $Region;
    var $TelNo;
    var $Latitude;
    var $Longitude;

    function __construct($Row) {
        $this->AffiliateId = isset($Row['AffiliateId']) ? $Row['AffiliateId'] : "";
        $this->GymName = isset($Row['GymName']) ? $Row['GymName'] : "";
        $this->URL = isset($Row['URL']) ? $Row['URL'] : "";
        $this->Address = isset($Row['Address']) ? $Row['Address'] : "";
        $this->City = isset($Row['City']) ? $Row['City'] : "";
        $this->TelNo = isset($Row['TelNo']) ? $Row['TelNo'] : "";
        $this->Region = isset($Row['Region']) ? $Row['Region'] : "";
        $this->Latitude = isset($Row['Latitude']) ? $Row['Latitude'] : "";
        $this->Longitude = isset($Row['Longitude']) ? $Row['Longitude'] : "";
    }
}       

?>
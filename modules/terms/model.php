<?php
class TermsModel extends Model
{
    function Check()
    {
        $Action = '';
        if($_REQUEST['status'] == 'accept'){
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'UPDATE Members SET TermsAccepted = 1, DateTermsAccepted = NOW() 
                WHERE UserId = "'.$_COOKIE['UID'].'"';
            $db->setQuery($SQL);
            $db->Query();
            $Action = 'Continue';
        }
        return $Action;
    }
}
?>
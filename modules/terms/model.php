<?php
class TermsModel extends Model
{
    function Check()
    {
        $Action = 'Must accept terms to continue!';
        if($_REQUEST['TermsAccepted'] == 'yes'){
            $db = new DatabaseManager(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_CUSTOM_DATABASE);
            $SQL = 'UPDATE Members SET TermsAccepted = 1, DateTermsAccepted = NOW() 
                WHERE UserId = "'.$_COOKIE['UID'].'"';
            $db->setQuery($SQL);
            $db->Query();
            $Action = '';
        }
        return $Action;
    }
}
?>
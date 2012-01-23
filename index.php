<?php
/********************************************************
Main control that routes all hits to the correct pages
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 24 Nov 2011

Last Modified Date: 24 Nov 2011

*********************************************************/

	/*HEADER*/
	require_once('includes/header.php');

		if( !isset( $_REQUEST['page'] ) )
			$page_name = 'home.php';
		else
			$page_name = $_REQUEST['page'].'.php';

		//Now look for the file - first check for local file
		if(file_exists('./pages/'.$page_name))
		{
			include('./pages/'.$page_name);
		}
		//Next check for local file
		elseif(file_exists(GLOBAL_PAGES.$page_name))
		{
			include(GLOBAL_PAGES.$page_name);
		}
		//Nothing found, therefore check for local error
		elseif(file_exists('./pages/filenotfound.php'))
		{
			include('./pages/filenotfound.php');
		}
		//Else show global error
		else
		{
			include(GLOBAL_PAGES.'filenotfound.php');
		}
	
	/*FOOTER*/
	require_once('includes/footer.php');

?>

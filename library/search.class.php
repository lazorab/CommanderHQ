<?php
/********************************************************
Class to handle search requests
Copyright Be-Mobile

Created By   : Brett Spence
Created Date : 14 August 2008

Last Modified Date: 14 August 2008

*********************************************************/


class search extends search_base
{

	function search_news($member_id, $site_id, $url, $search_term)
	{
		//perform the search
		//$search_t = $this->exclude_terms($search_term);
		$search_t = $search_term;
		$sql = 'SELECT * FROM PANews WHERE HeadLine LIKE "%'.$search_t.'%" OR BodyBody LIKE "%'.$search_t.'%"';
		$rs = $this->db->return_recordset( $sql );

		$this->log_search( $member_id, $site_id, $url, $search_term, $rs );
		return $rs;

	}

}

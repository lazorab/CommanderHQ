<?php
/********************************************************
Class for video functionality
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 26 January 2012

Last Modified Date: 26 January 2012

*********************************************************/


class Video
{
	var $URL='';
	var $SearchResults='';
	var $Response='';
  
	function __construct()
	{

	} 
	
	function SearchResults($keyword)
	{
		$VideoResults = array();
		$this->URL = 'http://gdata.youtube.com/feeds/api/videos?q='.urlencode($keyword).'';
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->URL);
		curl_setopt($ch, CURLOPT_TIMEOUT, 180);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		$this->Response=curl_exec($ch);

		curl_close($ch);
		$this->SearchResults = new SimpleXMLElement($this->Response);

		foreach($this->SearchResults as $Child)
		{
			if($Child->title != '')
			array_push($VideoResults, new VideoObject($Child));	
		}			
		return $VideoResults;	
	}
}

class VideoObject
{
	var $Title;
	var $SmartPhoneURL;
	var $LegacyPhoneURL;
	var $Content;
	
	function __construct($Video)
	{
		$this->Title = $Video->title;		
		$this->SmartPhoneURL = 'http://www.youtube.com/embed/'.str_replace('http://gdata.youtube.com/feeds/api/videos/','',$Video->id).'';
		$this->LegacyPhoneURL = 'http://m.youtube.com/details?v='.str_replace('http://gdata.youtube.com/feeds/api/videos/','',$Video->id).'';
		$this->Content = $Video->content;
	}
}
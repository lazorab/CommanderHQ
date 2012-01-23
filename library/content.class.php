<?php
/********************************************************
Class to handle the generic content
Copyright Be-Mobile

Created By   : Brett Spence
Created Date : 23 October 2008

Last Modified Date: 23 October 2008

*********************************************************/


class BContent extends BContent_Base
{
	function draw_summary( $ratio = 1 )
	{
		print('<div class="hoverPromo">');
		print($this->get_assets(' '.$this->get_keywords(), ($ratio * 0.27)));
		print('<p><wall:a href="?page=news&view=detail&news_id='.$this->get_Id().'" class="promoLink">'.$this->get_headline().'</wall:a></p>');
		print('<div class="endFloat"></div>');
		print('</div>');

	}

	function draw_detail( $ratio = 1 )
	{
		print('<p>'.$this->get_assets(' '.$this->get_keywords(), ($ratio * 0.5)));
		print('<wall:br />');
		print('<strong>'.strtoupper($this->get_headline()).'</strong><wall:br />');
		$this->draw();
		print('</p>');		
	}
}

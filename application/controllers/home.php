<?php

class Home_Controller extends Base_Controller {

	public $restful = true;  

	public function get_index()  //Display latest 50 borrowers and interface to select which borrowers to follow
    {


		$url = "http://api.kivaws.org/v1/loans/newest.json";
		$json = file_get_contents($url);
		$data = json_decode($json, TRUE);
		$current_borrowers = array();
		$borrowers = Borrower::all();
		foreach ($borrowers as $borrower)
		{
			array_push($current_borrowers,$borrower->kiva_id);
		}

		$content = View::make('new.index')->with('data', $data)->with('current_borrowers', $current_borrowers);

    	$view = View::make('home.index');
    	$view->content = $content;
    	return $view;
    }   

}
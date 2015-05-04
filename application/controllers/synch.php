<?php

class Synch_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index()
    {


		$borrowers = Borrower::all();
		foreach ($borrowers as $borrower)  //UPDATES BORROWER INFROMATION.  LOAD INTENSIVE TODO: Disperse load using scheduled task
		{
			$url = "http://api.kivaws.org/v1/loans/".$borrower->kiva_id.".json";
			$json = file_get_contents($url);
			$data = json_decode($json, TRUE);

			$data = $data['loans'][0];

			if( array_key_exists('location', $data) && array_key_exists('country', $data["location"]) ){

				$borrower->country = $data["location"]["country"];
			}
			if( array_key_exists('location', $data) && array_key_exists('town', $data["location"]) ){
				$borrower->town = $data["location"]["town"];
			}
			if( array_key_exists('sector', $data) ){
				$borrower->sector = $data["sector"];
			}
			if( array_key_exists('activity', $data) ){
				$borrower->activity = $data["activity"];
			}
			if( array_key_exists('use', $data) ){
				$borrower->use = $data["use"];
			}
			if( array_key_exists('funded_amount', $data) ){
				$borrower->funded_amount = $data["funded_amount"];
			}
			if( array_key_exists('loan_amount', $data) ){
				$borrower->loan_amount = $data["loan_amount"];
			}
			if( array_key_exists('name', $data) ){
				$borrower->name = $data["name"];
			}
			if( array_key_exists('image', $data) && array_key_exists('id', $data['image']) ){
				$borrower->image = $data["image"]['id'];
			}

			$borrower->save();
		}


		$lenders = Lender::all();
		foreach ($lenders as $lender)
		{
			$url = "http://api.kivaws.org/v1/lenders/".$lender->kiva_id.".json";
			$json = file_get_contents($url);
			$data = json_decode($json, TRUE);

			$data = $data['lenders'][0];

			if( array_key_exists('name', $data) ){
				$lender->name = $data["name"];
			}

			if( array_key_exists('image', $data) && array_key_exists('id', $data['image']) ){
				$lender->image = $data["image"]['id'];
			}

			if( array_key_exists('whereabouts', $data) ){
				$lender->whereabouts = $data["whereabouts"];
			}

			if( array_key_exists('country_code', $data) ){
				$lender->country_code = $data["country_code"];
			}

			if( array_key_exists('occupation', $data) ){
				$lender->occupation = $data["occupation"];
			}

			if( array_key_exists('occupational_info', $data) ){
				$lender->occupational_info = $data["occupational_info"];
			}

			if( array_key_exists('loan_because', $data) ){
				$lender->loan_because = $data["loan_because"];
			}
			$lender->save();
		}
		

    	$view = View::make('home.index');
    	$view->content = "Synch Complete";
    	return $view;


    }

}
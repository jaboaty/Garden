<?php

class Borrowers_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index() //Displays all Borrowers
    {

   		$borrowers = Borrower::all();
    	$content = View::make('borrower.index')->with('borrowers', $borrowers);

    	$view = View::make('home.index');
    	$view->content = $content;
    	return $view;




    }    

	public function put_index() // Adds a New Borrower
    {
    	$input = Input::all();
    	$rules = array(
		    'borrower_id'  => 'required'
		);
		$validation = Validator::make($input, $rules);
		if ($validation->fails()){ // Borrower Id not provided.  Display error message
			$view = View::make('borrower.fail');
			return $view;
		}else{

			$borrower = new Borrower;  //New borrower database model
            $borrower->kiva_id = Input::get('borrower_id');

            //Grabs Borrower information from Kiva API
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
			$borrower->save();  //Saves Model





            if($borrower->save()){
            	$content = "Borrwer has been saved";
            }else{
				$content = "Could not Save Borrower";
            }

	    	$view = View::make('home.index');
	    	$view->content = $content;
	    	return $view;

		}
    }


    public function delete_index() //Restful call to delete a Borrower based off of the borrower ID
    {
    	$input = Input::all();
    	$rules = array(
		    'id'  => 'required'
		);
		$id = Input::get('id');
		$validation = Validator::make($input, $rules);
		if ($validation->fails()){  // Validation Fails.  Display Error Message
			$view = View::make('borrower.fail');
			return $view;
		}else{  //Deletes Borrower Record and all Loans given to that borrower
			$borrower = Borrower::where('id', '=', $id )->first();
			$borrower->delete();

			$loans = Loan::where('borrower_id', '=', $id )->delete();

			$view = View::make('home.index');
			$view->content = "Borrower Deleted";
	    	return $view;
		}
	}

}
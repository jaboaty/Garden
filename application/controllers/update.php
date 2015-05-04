<?php

class Update_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index()
    {
    	

		$borrowers = Borrower::all();  //Updates Lender information attached to all current borrowers.  Fails with large number of borrowers.
		foreach ($borrowers as $borrower)
		{

			$url = "http://api.kivaws.org/v1/loans/".$borrower->kiva_id."/lenders.json";
			$json = file_get_contents($url);
			$data = json_decode($json, TRUE);
			foreach( $data['lenders'] as $lender ){
				$lender_name = "Anonymous";
				if(isset($lender['lender_id'])){
					$lender_name = $lender['lender_id'];
				}

				if($lender = Lender::where('kiva_id', '=', $lender_name)->first()){  //Checks if Lender already exists
				}else{  //Creates new Lender Record if new lender
					$lender = new Lender;
					$lender->kiva_id = $lender_name;

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


				if($loan = Loan::where('lender_id', '=', $lender->id)->where('borrower_id', '=', $borrower->id)->first() ){
				}else{
					$loan = new Loan;
					$loan->lender_id = $lender->id;
					$loan->borrower_id = $borrower->id;
					$loan->save();
				}



			}
		}

		$content = "Update Finished";

    	$view = View::make('home.index');
    	$view->content = $content;
    	return $view;

    } 

    private function add_loan(){  //TODO Handle individual Loans

    }


}
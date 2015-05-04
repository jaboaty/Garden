<?php

class Loan extends Eloquent 
{

	public function lender(){
		return $this->belongs_to('lender');
	}


	public function borrower(){
		return $this->belongs_to('borrower');
	}

	public function get_loans(){
		return $this->with(array('lender', 'borrower'))->get();
	}

}
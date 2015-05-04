<?php

class Borrower extends Eloquent 
{
	 public function lenders()
     {
          return $this->has_many_and_belongs_to('Lender', 'loans');
     }
}
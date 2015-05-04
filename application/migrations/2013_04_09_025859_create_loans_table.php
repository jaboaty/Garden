<?php

class Create_Loans_Table {    

	public function up()
    {
		Schema::create('loans', function($table) {
			$table->increments('id');
			$table->string('lender_id');
			$table->integer('borrower_id');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('loans');

    }

}
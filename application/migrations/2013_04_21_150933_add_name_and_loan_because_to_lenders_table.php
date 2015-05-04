<?php

class Add_Name_And_Loan_Because_To_Lenders_Table {    

	public function up()
    {
		Schema::table('lenders', function($table) {
			$table->string('name');
			$table->string('loan_because');
	});

    }    

	public function down()
    {
		Schema::table('lenders', function($table) {
			$table->drop_column(array('name', 'loan_because'));
	});

    }

}
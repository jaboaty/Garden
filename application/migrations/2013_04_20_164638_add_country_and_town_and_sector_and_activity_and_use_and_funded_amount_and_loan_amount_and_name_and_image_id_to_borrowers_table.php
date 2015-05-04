<?php

class Add_Country_And_Town_And_Sector_And_Activity_And_Use_And_Funded_Amount_And_Loan_Amount_And_Name_And_Image_Id_To_Borrowers_Table {    

	public function up()
    {
		Schema::table('borrowers', function($table) {
			$table->string('country');
			$table->string('town');
			$table->string('sector');
			$table->string('activity');
			$table->string('use');
			$table->integer('funded_amount');
			$table->integer('loan_amount');
			$table->string('name');
			$table->integer('image');
	});

    }    

	public function down()
    {
		Schema::table('borrowers', function($table) {
			$table->drop_column(array('country', 'town', 'sector', 'activity', 'use', 'funded_amount', 'loan_amount', 'name', 'image'));
	});

    }

}
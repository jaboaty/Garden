<?php

class Add_Wherabouts_And_Country_Code_And_Occupation_And_Occupational_Info_And_Image_Id_To_Lenders_Table {    

	public function up()
    {
		Schema::table('lenders', function($table) {
			$table->string('whereabouts');
			$table->string('country_code');
			$table->string('occupation');
			$table->string('occupational_info');
			$table->integer('image');
	});

    }    

	public function down()
    {
		Schema::table('lenders', function($table) {
			$table->drop_column(array('whereabouts', 'country_code', 'occupation', 'occupational_info', 'image'));
	});

    }

}
<?php

class Create_Borrowers_Table {    

	public function up()
    {
		Schema::create('borrowers', function($table) {
			$table->increments('id');
			$table->integer('kiva_id')->unique();
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('borrowers');

    }

}
<?php

class Create_Lenders_Table {    

	public function up()
    {
		Schema::create('lenders', function($table) {
			$table->increments('id');
			$table->string('kiva_id')->unique();
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('lenders');

    }

}
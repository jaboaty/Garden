<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/


Route::get('/',array('as'=>'home','uses' => 'home@index'));
Route::get('synch',array('as'=>'synch','uses' => 'synch@index'));
Route::get('borrowers',array('as'=>'borrowers','uses' => 'borrowers@index'));
Route::put('borrowers',array('as'=>'borrowers','uses' => 'borrowers@index'));
Route::delete('borrowers',array('as'=>'borrowers','uses' => 'borrowers@index'));
Route::get('update',array('as'=>'update','uses' => 'update@index'));
Route::get('export', function(){  //Exports all database information as a JSON feed to be handled by another application

	$export = array();
	$borrowers = Borrower::all();
	foreach($borrowers as $borrower){ 

		$new_borrower = array(
			"name" => $borrower->name,
			"use" => $borrower->use,
			"sector" => $borrower->sector,
			"activity" => $borrower->activity,
			"country" => $borrower->country,
			"town" => $borrower->town,
			"loan_amount" => $borrower->loan_amount,
			"image" => "http://s3-1.kiva.org/img/s232/".$borrower->image.".jpg"
		);
		$new_borrower['lenders'] = array();
		foreach($borrower->lenders as $lender){

			$new_lender = array(
				"name" => $lender->name,
				"loan_because" => $lender->loan_because,
				"occupation" => $lender->occupation,
				"occupational_info" => $lender->occupational_info,
				"whereabouts" => $lender->whereabouts,
				"country_code" => $lender->country_code,
				"image" => "http://s3-2.kiva.org/img/w800/".$lender->image.".jpg",
				"created_at" => $lender->relationships['pivot']->created_at
			);
			array_push($new_borrower['lenders'],$new_lender);
		}
		array_push($export,$new_borrower);		
	}
	return Response::json($export);
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});
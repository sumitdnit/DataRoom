<?php
  use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
/*
  |--------------------------------------------------------------------------
  | Register The Laravel Class Loader
  |--------------------------------------------------------------------------
  |
  | In addition to using Composer, you may use the Laravel class loader to
  | load your controllers and models. This is useful for keeping all of
  | your classes in the "global" namespace without Composer updating.
  |
 */

ClassLoader::addDirectories(array(
    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/database/seeds',
	app_path() . '/permissions',
));

/*
  |--------------------------------------------------------------------------
  | Application Error Logger
  |--------------------------------------------------------------------------
  |
  | Here we will configure the error logger setup for the application which
  | is built on top of the wonderful Monolog library. By default we will
  | build a basic log file setup which creates a single file for logs.
  |
 */

Log::useFiles(storage_path() . '/logs/laravel.log');

/*
  |--------------------------------------------------------------------------
  | Application Error Handler
  |--------------------------------------------------------------------------
  |
  | Here you may handle any errors that occur in your application, including
  | logging them or displaying custom views for specific errors. You may
  | even register several error handlers to handle different types of
  | exceptions. If nothing is returned, the default error view is
  | shown, which includes a detailed stack trace during debug.
  |
 */
App::missing(function($exception) {
    return Redirect::to('/error');
});
/* 
  |--------------------------------------------------------------------------
  | Maintenance Mode Handler
  |--------------------------------------------------------------------------
  |
  | The "down" Artisan command gives you the ability to put an application
  | into maintenance mode. Here, you will define what is displayed back
  | to the user if maintenance mode is in effect for the application.
  |
 */

App::down(function() {
    return Response::make("Be right back!", 503);
});

App::error(function(MethodNotAllowedHttpException $exception){
    return Redirect::to('/');
});


/*App::before(function($request)
{
//echo '<pre>';
	//print_r($request);
//die;

    foreach($request->all() as $req){
	
	
	     $entity='<� W3S�h����>';
		 if($req==$entity)
		 {
		  echo $req= addslashes($req);
		  }
		  else {
		  
		  echo $req= htmlentities($req);
		   }
		
		
		
		} 
		
		//die;
});*/


App::after(function($request, $response)
{
//echo  'rrrrrr';
//echo $content = $response->getContent();
 //echo  $request;
//echo '<pre>';
	//print_r($conten);
	//die;
//$req= stripslashes($response);
 //$diff = (microtime(true) - Session::get('start'));

//Session::put('diff',$diff);
});

/*
  |--------------------------------------------------------------------------
  | Require The Filters File
  |--------------------------------------------------------------------------
  |
  | Next we will load the filters file for the application. This gives us
  | a nice separate location to store our route and application filter
  | definitions instead of putting them all in the main routes file.
  |
 */

require app_path() . '/filters.php';
require app_path() . '/helpers.php';
require app_path() . '/composers.php';
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
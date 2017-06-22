<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//echo 123;
//exit();

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/v1'], function($app)
{
    $app->post('slicing/start', 'SlicingController@start');

    $app->get('slicing/status/{jobId}', 'SlicingController@status');

    $app->options('upload/upload', 'UploaderController@preflight');

    $app->post('upload/upload', 'UploaderController@upload');

    $app->post('upload/combine', 'UploaderController@combine');

    $app->options('upload/delete/{uuid}', 'UploaderController@preflight');

    $app->delete('upload/delete/{uuid}', 'UploaderController@delete');
});

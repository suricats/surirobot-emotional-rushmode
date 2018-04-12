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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * POST analysePost
 * Summary: Returns data about the face of the person
 * Notes: 
 * Output-Formats: [application/json]
 */
$router->post('/analyse', 'AnalyseController@analysePost');
/**
 * POST identifyPost
 * Summary: Recognize the person on the pictures
 * Notes: 

 */
$router->post('/identify', 'IdentifyController@identifyPost');
/**
 * GET personGet
 * Summary: Get the list of people
 * Notes: 

 */
$router->get('/person', 'PersonController@personGet');
/**
 * POST personPost
 * Summary: Add a new person to the list
 * Notes: 

 */
$router->post('/person', 'PersonController@personPost');
/**
 * POST personPersonIdFacePost
 * Summary: Add a face for the person
 * Notes: 

 */
$router->post('/person/{personId}/face', 'PersonController@addPersonFacePost');

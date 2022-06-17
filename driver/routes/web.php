<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
//$router->get('/getNotice','NoticeController@get_notice');
$router->get('/testClass','NoticeController@testClass');
// $router->get('age', ['middleware' => 'age:10' ,function () use ($router) {
//     print 'test middleware';
// }]);
// $router->get('posts/{id}/comments/{idcom}', ['as' => 'blog', function($id, $idcom){
//     return 'Hello World '.$id.' '.$idcom;
// }]);

// API route group

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('notices', 'NoticeController@getNotices');
    $router->get('notices/{id}', 'NoticeController@getNoticeById');
//    $router->get('byauthor/{id}', 'NoticeController@byAuthor');
//    $router->get('byindex/{id}', 'NoticeController@byIndex');
//    $router->get('bypublisher/{id}', 'NoticeController@byPublisher');
});

<?php


use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('dicts', DictController::class);

    $router->resource('users', UserController::class);
    $router->resource('profiles', ProfileController::class);

    $router->resource('categories', CategoryController::class);
    $router->resource('articles', ArticlesController::class);
    $router->resource('tags', TagController::class);
    $router->resource('comments', CommentController::class);

    $router->resource('links', LinkController::class);
    $router->resource('navs', NavController::class);
    $router->resource('attachments', AttachmentController::class);


    $router->resource('questions', QuestionController::class);

});

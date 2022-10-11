<?php
declare(strict_types=1);

namespace ApiExample;

use ApiExample\Controllers\User;
use ApiExample\Routing\Router;

Router::get('/', function () {
    echo 'Hello! It works';
});
Router::get('/users', [User::class, 'getAll']);
Router::post('/users', [User::class, 'create']);
Router::get('/users/add-fake-users', [User::class, 'addFake']);
Router::get('/users/{id}', [User::class, 'find']);
Router::put('/users/{id}', [User::class, 'update']);
Router::delete('/users/{id}', [User::class, 'delete']);

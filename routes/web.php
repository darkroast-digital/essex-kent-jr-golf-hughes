<?php

/*
|--------------------------------------------------------------------------
| #WEB
|--------------------------------------------------------------------------
*/



use App\Controllers\Admin\AgeGroupsController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\HolesController;
use App\Controllers\Admin\PlayersController;
use App\Controllers\Admin\ScoresController;
use App\Controllers\Admin\TournamentsController;
use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\PasswordsController;
use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;



// #HOME
// =========================================================================

$app->get('/', HomeController::class . ':index')->setName("home");
$app->post('/', HomeController::class . ':post');
$app->get('/results', HomeController::class . ':results')->setName("results");
$app->get('/players', HomeController::class . ':players')->setName("players");
$app->get('/players/{id}', HomeController::class . ':playerView')->setName("home.player.view");




// #AUTH
// =========================================================================

$app->get('/login', AuthController::class . ':showLogin')->setName('login');
$app->post('/login', AuthController::class . ':postLogin');
// $app->get('/register', AuthController::class . ':showRegister')->setName('register');
// $app->post('/register', AuthController::class . ':postRegister');
$app->get('/logout', AuthController::class . ':getLogout')->setName('logout');
$app->get('/forgot', PasswordsController::class . ':getForgot')->setName('forgot');
$app->post('/forgot', PasswordsController::class . ':postForgot');
$app->get('/reset/{token}', PasswordsController::class . ':getReset')->setName('reset');
$app->post('/reset/{token}', PasswordsController::class . ':postReset');




// #ADMIN
// =========================================================================

$app->group('/admin', function() {
    $this->get('', DashboardController::class . ':index')->setName('admin.index');
})->add(AuthMiddleware::class);




// #AGE GROUPS
// =========================================================================

$app->group('/admin/age-groups', function() {
    $this->get('', AgeGroupsController::class . ':index')->setName('agegroups.index');
    $this->get('/create', AgeGroupsController::class . ':create')->setName('agegroups.create');
    $this->post('/create', AgeGroupsController::class . ':store');
    $this->post('/delete/{id}', AgeGroupsController::class . ':delete')->setName('agegroups.delete');
    $this->get('/edit/{id}', AgeGroupsController::class . ':edit')->setName('agegroups.edit');
    $this->post('/edit/{id}', AgeGroupsController::class . ':update');
    $this->get('/view/{id}', AgeGroupsController::class . ':view')->setName('agegroups.view');
})->add(AuthMiddleware::class);




// #HOLES
// =========================================================================

$app->group('/admin/holes', function() {
    $this->get('', HolesController::class . ':index')->setName('holes.index');
})->add(AuthMiddleware::class);




// #PLAYERS
// =========================================================================

$app->group('/admin/players', function() {
    $this->get('', PlayersController::class . ':index')->setName('players.index');
    $this->get('/create', PlayersController::class . ':create')->setName('players.create');
    $this->post('/create', PlayersController::class . ':store');
    $this->get('/edit/{id}', PlayersController::class . ':edit')->setName('players.edit');
    $this->post('/edit/{id}', PlayersController::class . ':update');
    $this->post('/delete/{id}', PlayersController::class . ':delete')->setName('players.delete');
    $this->get('/view/{id}', PlayersController::class . ':view')->setName('players.view');
})->add(AuthMiddleware::class);




// #SCORES
// =========================================================================

$app->group('/admin/scores', function() {
    $this->get('', ScoresController::class . ':index')->setName('scores.index');
    $this->get('/create', ScoresController::class . ':create')->setName('scores.create');
    $this->post('/create', ScoresController::class . ':store');
    $this->get('/api/tournaments/{holes}', TournamentsController::class . ':api')->setName('api.tournaments');
    $this->get('/api/players/{group}', PlayersController::class . ':api')->setName('api.players');
    $this->get('/api/scores/{player}/{tournament}', ScoresController::class . ':api')->setName('api.scores');
    $this->get('/view/{id}', ScoresController::class . ':view')->setName('scores.view');
    $this->get('/overall/{holes}', ScoresController::class . ':overall')->setName('scores.overall');
})->add(AuthMiddleware::class);




// #TOURNAMENTS
// =========================================================================

$app->group('/admin/tournaments', function() {
    $this->get('', TournamentsController::class . ':index')->setName('tournaments.index');
    $this->get('/create', TournamentsController::class . ':create')->setName('tournaments.create');
    $this->post('/create', TournamentsController::class . ':store');
    $this->get('/edit/{id}', TournamentsController::class . ':edit')->setName('tournaments.edit');
    $this->post('/edit/{id}', TournamentsController::class . ':update');
    $this->post('/delete/{id}', TournamentsController::class . ':delete')->setName('tournaments.delete');
    $this->get('/view/{id}', TournamentsController::class . ':view')->setName('tournaments.view');
})->add(AuthMiddleware::class);
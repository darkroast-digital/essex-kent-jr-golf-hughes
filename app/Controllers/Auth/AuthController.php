<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin($request, $response, $args)
    {
        if ($this->auth->check() == true) {
            return $response->withRedirect($this->router->pathFor('admin.index'));
        }

        return $this->view->render($response, 'auth/login.twig');
    }

    public function postLogin($request, $response, $args)
    {
        if ($this->auth->attempt($_POST['email'], $_POST['password']) != true) {
            $this->flash->addMessage('error', 'You have entered incorrect credentials.');
            return $response->withRedirect($this->router->pathFor('login'));
        }

        return $response->withRedirect($this->router->pathFor('admin.index'));
    }

    public function showRegister($request, $response, $args)
    {
        if ($this->auth->check() == true) {
            return $response->withRedirect($this->router->pathFor('admin.index'));
        }

        return $this->view->render($response, 'auth/register.twig');
    }

    public function postRegister($request, $response, $args)
    {
        $params = $request->getParams();
        $userCheck = User::where('email', $params['email'])->first();

        if ($userCheck != false) {
            $this->flash->addMessage('error', 'That email is already being used.');
            return $response->withRedirect($this->router->pathFor('register'));
        }

        if ($params['password'] != $params['passwordConfirm']) {
            $this->flash->addMessage('error', 'Passwords must match.');
            return $response->withRedirect($this->router->pathFor('register'));
        }

        $user = User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => password_hash($params['password'], PASSWORD_DEFAULT)
        ]);

        $this->flash->addMessage('info', 'You are now a registered user. Please log in.');
        return $response->withRedirect($this->router->pathFor('login'));
    }

    public function getLogout($request, $response, $args)
    {
        unset($_SESSION['user']);

        $this->flash->addMessage('info', 'You have successfully logged out.');
        return $response->withRedirect($this->router->pathFor('login'));        
    }
}


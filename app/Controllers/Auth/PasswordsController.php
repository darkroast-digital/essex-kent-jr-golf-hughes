<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class PasswordsController extends Controller
{
    public function getForgot($request, $response, $args)
    {
        if ($this->auth->check() == true) {
            return $response->withRedirect($this->router->pathFor('admin.index'));
        }

        return $this->view->render($response, 'auth/forgot.twig');
    }

    public function postForgot($request, $response, $args)
    {
        $user = User::where('email', $request->getParam('email'))->first();

        if (!$user) {
            $this->flash->addMessage('error', 'That is not an existing user email address.');
            return $response->withRedirect($this->router->pathFor('forgot'));
        }

        $hash = hash('sha256', $user->email . time());
        $user->reset_token = $hash;
        $user->save();

        $this->mail->from('kim@darkroast.co', 'Kim Morin')
                    ->to([
                        [
                            'name' => $user->name,
                            'email' => $user->email
                        ]
                    ])
                    ->subject('Hey, ' . $user->name . '! A password reset has been requested on your account.')
                    ->send('mail/mail.twig', compact('user'));

        $this->flash->addMessage('info', 'Check your email for your reset link.');
        return $response->withRedirect($this->router->pathFor('login'));
    }

    public function getReset($request, $response, $args)
    {
        if ($this->auth->check() == true) {
            return $response->withRedirect($this->router->pathFor('admin.index'));
        }

        $token = $args['token'];
        $user = User::where('reset_token', $args['token'])->first();

        return $this->view->render($response, 'auth/reset.twig', compact('token', 'user'));
    }

    public function postReset($request, $response, $args)
    {
        $user = User::where('reset_token', $args['token'])->first();
        $params = $request->getParams();
        $routeArgs = ['token' => $user->reset_token];

        if ($user->email != $params['email']) {
            $this->flash->addMessage('error', 'That is not the email associated with your account.');
            return $response->withRedirect($this->router->pathFor('reset', $routeArgs));
        }

        $validation = $this->validator->validate($request, [
            'password' => v::noWhitespace()->notEmpty()
        ]);

        if ($validation->failed()) {
            $this->flash->addMessage('error', 'Password cannot contain spaces.');
            return $response->withRedirect($this->router->pathFor('reset', $routeArgs));
        }

        if ($params['password'] != $params['passwordConfirm']) {
            $this->flash->addMessage('error', 'Passwords do not match.');
            return $response->withRedirect($this->router->pathFor('reset', $routeArgs));
        }

        $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        $user->reset_token = NULL;
        $user->save();

        $this->flash->addMessage('info', 'Your password has been successfully changed.');
        return $response->withRedirect($this->router->pathFor('login'));
    }
}


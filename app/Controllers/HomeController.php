<?php

namespace App\Controllers;

use App\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;


class HomeController extends Controller
{
    public function index($request, $response, $args)
    {
        return $this->view->render($response, 'home.twig');
    }

    public function results($request, $response, $args)
    {
        return $this->view->render($response, 'results.twig');
    }

    public function post($request, $response, $args)
    {
        // 
    }
}

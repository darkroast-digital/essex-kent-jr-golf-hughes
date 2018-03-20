<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\AgeGroup;

class DashboardController extends Controller
{
    public function index($request, $response, $args)
    {
        return $response->withRedirect($this->router->pathFor('agegroups.index'));
    }
}


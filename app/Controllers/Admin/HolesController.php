<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Hole;
use App\Models\Tournament;

class HolesController extends Controller
{
    public function index($request, $response, $args)
    {
        $holes = Hole::all();
        $courses = Tournament::groupBy('name')->orderBy('name')->paginate(10);

        return $this->view->render($response, 'admin/holes/index.twig', compact('holes', 'courses'));
    }
}


<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\AgeGroup;
use App\Models\Player;
use App\Models\Score;
use App\Models\Tournament;

class AgeGroupsController extends Controller
{
    public function index($request, $response, $args)
    {
        $groups = AgeGroup::all();

        return $this->view->render($response, 'admin/age-groups/index.twig', compact('groups'));
    }

    public function view($request, $response, $args)
    {
        $group = AgeGroup::where('id', $args['id'])->first();
        $players = Player::where('age_group_id', $group->id)->orderBy('lname', 'asc')->paginate(10);
        $tournaments = $group->tournList();
        $scores = Score::all();

        return $this->view->render($response, 'admin/age-groups/view.twig', compact('group', 'players', 'tournaments', 'scores'));
    }

    public function create($request, $response, $args)
    {
        return $this->view->render($response, 'admin/age-groups/create.twig');
    }

    public function store($request, $response, $args)
    {
        $group = AgeGroup::create([
            'name' => $request->getParam('name'),
            'holes_played' => $request->getParam('length')
        ]);

        $group->save();

        $this->flash->addMessage('info', 'Age Group created!');
        return $response->withRedirect($this->router->pathFor('agegroups.index'));
    }

    public function edit($request, $response, $args)
    {
        $group = AgeGroup::where('id', $args['id'])->first();

        return $this->view->render($response, 'admin/age-groups/edit.twig', compact('group'));
    }

    public function update($request, $response, $args)
    {
        $group = AgeGroup::where('id', $args['id'])->first();

        $group->name = $request->getParam('name');
        $group->holes_played = $request->getParam('length');
        $group->save();

        $this->flash->addMessage('info', 'Age Group updated!');
        return $response->withRedirect($this->router->pathFor('agegroups.view', ['id' => $group->id]));
    }

    public function delete($request, $response, $args)
    {
        $id = $_POST['hiddenInput'];
        $group = AgeGroup::where('id', $id)->first();
        $group->delete();

        $this->flash->addMessage('info', 'Age Group deleted!');
        return $response->withRedirect($this->router->pathFor('agegroups.index'));
    }
}


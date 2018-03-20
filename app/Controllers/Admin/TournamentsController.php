<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Hole;
use App\Models\Tournament;

class TournamentsController extends Controller
{
    public function index($request, $response, $args)
    {
        $tournaments = Tournament::orderBy('date')->paginate(10);

        return $this->view->render($response, 'admin/tournaments/index.twig', compact('tournaments'));
    }

    public function create($request, $response, $args)
    {
        return $this->view->render($response, 'admin/tournaments/create.twig');
    }

    public function store($request, $response, $args)
    {
        $params = $request->getParams();
        $par = null;

        if(isset($params['coursePar'])) {
            $par = $params['coursePar'];
        }

        $time = '00:00';

        if(isset($params['time'])) {
            $time = $params['time'];
        }

        $date = $params['date'] . ' ' . $time . ' 00';

        $tournament = Tournament::create([
            'name' => $params['name'],
            'holes' => $params['length'],
            'par' => $par,
            'date' => $date
        ]);

        $tournament->save();

        for($i = 1; $i <= 18; $i++) {
            $par = null;

            if (isset($params['hole' . $i])) {
                $par = $params['hole' . $i];
            }

            $tournHoles = Hole::create([
                'hole' => $i,
                'par' => $par,
                'tournament_id' => $tournament->id
            ]);

            $tournHoles->save();
        }

        $this->flash->addMessage('info', 'Tournament created!');
        return $response->withRedirect($this->router->pathFor('tournaments.index'));
    }

    public function view($request, $response, $args)
    {
        $tournament = Tournament::where('id', $args['id'])->first();
        $holes = Hole::where('tournament_id', $args['id'])->get();

        return $this->view->render($response, 'admin/tournaments/view.twig', compact('tournament', 'holes'));
    }

    public function edit($request, $response, $args)
    {
        $tournament = Tournament::where('id', $args['id'])->first();
        $date = $tournament->date;
        $date = substr($date, 0, 10);
        $time = $tournament->date;
        $time = substr($time, 11, 16);

        if ($time == "00:00:00") {
            $time = null;
        }

        $holes = Hole::all();

        return $this->view->render($response, 'admin/tournaments/edit.twig', compact('tournament', 'date', 'time', 'holes'));
    }

    public function update($request, $response, $args)
    {
        $tournament = Tournament::where('id', $args['id'])->first();
        $params = $request->getParams();
        $par = null;

        if(isset($params['coursePar'])) {
            $par = $params['coursePar'];
        }

        $time = '00:00';

        if(isset($params['time'])) {
            $time = $params['time'];
        }

        $date = $params['date'] . ' ' . $time . ' 00';

        $tournament->name = $params['name'];
        $tournament->holes = $params['length'];
        $tournament->par = $par;
        $tournament->date = $date;
    
        $tournament->save();

        for($i = 1; $i <= 18; $i++) {
            $hole = Hole::where('hole', $i)->where('tournament_id', $tournament->id)->first();
            if ($hole->hole == $i) {
                $par = null;

                if (isset($params['hole' . $i])) {
                    $par = $params['hole' . $i];
                }
                $hole->par = $par;
                $hole->save();
            }
            
        }

        $this->flash->addMessage('info', 'Tournament updated!');
        return $response->withRedirect($this->router->pathFor('tournaments.index'));
    }

    public function delete($request, $response, $args)
    {
        $id = $_POST['hiddenInput'];
        $tournament = Tournament::where('id', $id)->first();

        $tournament->delete();

        $this->flash->addMessage('info', 'Tournament deleted!');
        return $response->withRedirect($this->router->pathFor('tournaments.index'));
    }

    public function api($request, $response, $args)
    {
        $tournaments = Tournament::where('holes', $args['holes'])->get();

        return $response->withJson($tournaments);
    }
}


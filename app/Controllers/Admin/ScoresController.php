<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\AgeGroup;
use App\Models\Player;
use App\Models\Score;
use App\Models\Tournament;

class ScoresController extends Controller
{
    public function index($request, $response, $args)
    {
        $tourn9 = Tournament::where('holes', 9)->get();
        $tourn18 = Tournament::where('holes', 18)->get();

        return $this->view->render($response, 'admin/scores/index.twig', compact('tourn9', 'tourn18'));
    }

    public function view($request, $response, $args)
    {
        $scores = Score::where('tournament_id', $args['id'])->get();
        $players = array();
        $tournament = Tournament::where('id', $args['id'])->first();

        foreach ($scores as $score) {
            $player = Player::where('id', $score->player_id)->with([
                'AgeGroup',
                'Scores'
            ])->first();

            if (!in_array($player, $players)) {
                array_push($players, $player);
            }
        }

        $players = collect($players)->sortBy('AgeGroup');

        return $this->view->render($response, 'admin/scores/view.twig', compact('players', 'tournament'));
    }

    public function overall($request, $response, $args)
    {
        $holes = $args['holes'];
        $tournaments = Tournament::where('holes', $args['holes'])->get();
        $groups = AgeGroup::where('holes_played', $args['holes'])->get();

        $scores = Score::all();
        $players = array();

        foreach ($scores as $score) {
            $player = Player::where('id', $score->player_id)->with([
                'AgeGroup',
                'Scores'
            ])->first();

            if (!in_array($player, $players)) {
                array_push($players, $player);
            }
        }

        $players = collect($players)->sortBy('AgeGroup');

        return $this->view->render($response, 'admin/scores/overall.twig', compact('holes', 'players', 'tournaments', 'groups'));
    }

    public function create($request, $response, $args)
    {
        $players = Player::orderBy('lname')->get();
        $groups = AgeGroup::all();
        $tournaments = Tournament::all();

        return $this->view->render($response, 'admin/scores/create.twig', compact('players', 'groups', 'tournaments'));
    }

    public function api($request, $response, $args)
    {
        $scores = Score::where('player_id', $args['player'])
                    ->where('tournament_id', $args['tournament'])
                    ->get();

        return $response->withJson($scores);
    }

    public function store($request, $response, $args)
    {
        $params = $request->getParams();
        $count = $params['group'];

        for ($i = 1; $i <= $count; $i++) {
            $score = 0;

            if (isset($params['hole' . $i])) {
                $score = $params['hole' . $i];
            }

            $entry = Score::where('player_id', $params['player'])
                        ->where('tournament_id', $params['tournament'])
                        ->where('hole_id', $i)
                        ->first();

            if (!$entry) {
                $entry = Score::create([
                    'player_id' => $params['player'],
                    'tournament_id' => $params['tournament'],
                    'hole_id' => $i,
                    'score' => $score
                ]);

                $entry->save();
            } else {
                $entry->score = $score;
                $entry->save();
            }

            
        }

        $this->flash->addMessage('info', 'Scores saved');
        return $response->withRedirect($this->router->pathFor('scores.create'));
    }
}


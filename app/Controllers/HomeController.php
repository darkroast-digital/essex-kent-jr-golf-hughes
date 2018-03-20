<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\AgeGroup;
use App\Models\Hole;
use App\Models\Player;
use App\Models\Score;
use App\Models\Tournament;
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

    public function players($request, $response, $args)
    {
        $players = Player::with([
            'AgeGroup'
        ])->orderBy('lname')->get();

        $agegroups = AgeGroup::all();

        return $this->view->render($response, 'players.twig', compact('players', 'agegroups'));
    }

    public function playerView($request, $response, $args)
    {
        $player = Player::where('id', $args['id'])->first();
        $agegroup = AgeGroup::where('id', $player->age_group_id)->first();
        $scores = Score::where('player_id', $player->id)->get();
        $player->bio = $this->markdown->text($player->bio);
        $numHoles = $agegroup->holes_played;
        $holes = Hole::all();
        $tournaments = Tournament::orderBy('date')->get();
        
        return $this->view->render($response, 'view-player.twig', compact('player', 'agegroup', 'scores', 'numHoles', 'holes', 'tournaments'));
    }

    public function post($request, $response, $args)
    {
        // 
    }
}

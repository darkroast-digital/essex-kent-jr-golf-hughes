<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\AgeGroup;
use App\Models\Hole;
use App\Models\Player;
use App\Models\Score;
use App\Models\Tournament;

class PlayersController extends Controller
{
    public function index($request, $response, $args)
    {
        $players = Player::with([
            'AgeGroup'
        ])->orderBy('lname')->paginate(10);

        return $this->view->render($response, 'admin/players/index.twig', compact('players'));
    }

    public function create($request, $response, $args)
    {
        $agegroups = AgeGroup::all();

        return $this->view->render($response, 'admin/players/create.twig', compact('agegroups'));
    }

    public function store($request, $response, $args)
    {
        $params = $request->getParams();

        if (isset($_FILES['featured'])) {
            $image = $_FILES['featured'];
        }

        $player = Player::create([
            'fname' => $params['fname'],
            'lname' => $params['lname'],
            'age' => $params['age'],
            'gender' => $params['gender'],
            'age_group_id' => $params['agegroup'],
            'bio' => $params['bio']
        ]);

        $player->save();

        if (!file_exists(__DIR__ . '/../../../assets/uploads/players/' . $player->id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/players/' . $player->id);
            $player->image = $player->id;
            copy(__DIR__ . '/../../../assets/uploads/players/featured.jpg', __DIR__ . '/../../../assets/uploads/players/' . $player->id . '/featured.jpg');
            $player->save();
        }

        if (isset($_FILES['featured'])) {
            move_uploaded_file($image['tmp_name'], __DIR__ . '/../../../assets/uploads/players/' . $player->id . '/featured.jpg');
            $player->save();
        }

        $this->flash->addMessage('info', 'Player Created!');
        return $response->withRedirect($this->router->pathFor('players.index'));
    }

    public function view($request, $response, $args)
    {
        $player = Player::where('id', $args['id'])->first();
        $agegroup = AgeGroup::where('id', $player->age_group_id)->first();
        $scores = Score::where('player_id', $player->id)->get();
        $player->bio = $this->markdown->text($player->bio);
        $numHoles = $agegroup->holes_played;
        $holes = Hole::all();
        $tournaments = Tournament::orderBy('date')->get();
        
        return $this->view->render($response, 'admin/players/view.twig', compact('player', 'agegroup', 'scores', 'numHoles', 'holes', 'tournaments'));
    }

    public function edit($request, $response, $args)
    {
        $player = Player::where('id', $args['id'])->first();
        $agegroups = AgeGroup::all();
        $featured = null;

        if (file_exists(__DIR__ . '/../../../assets/uploads/players/' . $player->id . '/featured.jpg')) {
            $featured = __DIR__ . '/../../../assets/uploads/players/' . $player->id . '/featured.jpg';
        }
        
        return $this->view->render($response, 'admin/players/edit.twig', compact('player', 'agegroups', 'featured'));
    }

    public function update($request, $response, $args)
    {
        $params = $request->getParams();
        $player = Player::where('id', $args['id'])->first();

        if (isset($_FILES['featured'])) {
            $image = $_FILES['featured'];
        }

        $player->fname = $params['fname'];
        $player->lname = $params['lname'];
        $player->age = $params['age'];
        $player->gender = $params['gender'];
        $player->age_group_id = $params['agegroup'];
        $player->bio = $params['bio'];

        $player->save();

        if (isset($_FILES['featured'])) {
            if (!file_exists(__DIR__ . '/../../../assets/uploads/players/' . $player->id)) {
                mkdir(__DIR__ . '/../../../assets/uploads/players/' . $player->id);
            }

            move_uploaded_file($image['tmp_name'], __DIR__ . '/../../../assets/uploads/players/' . $player->id . '/featured.jpg');

            $player->image = $player->id;
            $player->save();
        }

        $this->flash->addMessage('info', 'Player Updated!');
        return $response->withRedirect($this->router->pathFor('players.index'));
    }

    public function delete($request, $response, $args)
    {
        $id = $_POST['hiddenInput'];
        $player = Player::where('id', $id)->first();

        $player->delete();

        $this->flash->addMessage('info', 'Player deleted!');
        return $response->withRedirect($this->router->pathFor('players.index'));
    }

    public function api($request, $response, $args)
    {
        $players = Player::where('age_group_id', $args['group'])->get();

        return $response->withJson($players);
    }
}


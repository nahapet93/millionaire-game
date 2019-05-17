<?php

namespace App\Http\Controllers;

use App\Game;
use App\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function top() {
        $top_games = Game::getTopGames(10);

        return view('admin/top', compact('top_games'));
    }

    public function store() {
        $user = \Auth::user();
        Game::createGame($user->id);

        return redirect('/');
    }

    public function answer(Request $request) {
        $user = \Auth::user();
        $current_game = Game::getCurrentGame($user->id);

        if ($request->post('submit') == 'interrupt') {
            $current_game->interrupt();
        }

        if (!empty($request->post('answers'))) {
            if ($request->post('submit') == 'answer') {
                $current_question = Game::getCurrentQuestion($user->id);
                $current_game->answer($current_question, $request->post('answers'));
            }
        }

        if ($request->post('next')) {
            Game::createGame($user->id);
        }

        return redirect('/');
    }
}

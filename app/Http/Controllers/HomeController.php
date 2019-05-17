<?php

namespace App\Http\Controllers;

use App\Game;
use App\Question;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = \Auth::user();

        if ($user->role == User::ROLE_PLAYER) {
            $current_game = Game::getCurrentGame($user->id);
            $current_question = Game::getCurrentQuestion($user->id);
            $is_last_question = Game::isLastQuestion($current_game);

            return view('home', compact('current_game', 'current_question', 'is_last_question'));
        } elseif ($user->role == User::ROLE_ADMIN) {
            $questions = Question::orderBy('id', 'desc')->get();
            $points = [5, 7, 10, 14, 20];

            return view('admin/home', compact('questions', 'points'));
        }
    }
}

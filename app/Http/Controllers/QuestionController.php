<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
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

    public function store(Request $request) {
        $user = \Auth::user();

        if ($user->role == User::ROLE_ADMIN) {
            $request->validate([
                'content' => 'required|string',
                'points' => 'required|integer|in:5,7,10,14,20',
                'answers.content.*' => 'required|string',
            ]);

            $post = $request->post();
            $question = Question::createQuestion($post['content'], $post['points']);
            $question->saveAnswers($post['answers']);

            return redirect('/');
        }
    }

    public function edit($id) {
        $user = \Auth::user();

        if ($user->role == User::ROLE_ADMIN) {
            $question = Question::find($id);
            $answers = $question->answers;
            $points = [5, 7, 10, 14, 20];

            return view('admin/edit', compact('question', 'answers', 'points'));
        }
    }

    public function update($id, Request $request) {
        $user = \Auth::user();

        if ($user->role == User::ROLE_ADMIN) {
            $request->validate([
                'content' => 'required|string',
                'points' => 'required|integer|in:5,7,10,14,20',
                'answers.content.*' => 'required|string',
            ]);

            $question = Question::find($id);
            $post = $request->post();
            $question->updateQuestion($post['content'], $post['points']);
            $question->updateAnswers($post['answers']);

            return redirect('/');
        }
    }

    public function destroy($id) {
        $user = \Auth::user();

        if ($user->role == User::ROLE_ADMIN) {
            $question = Question::find($id);
            $question->delete();

            return redirect('/');
        }
    }
}

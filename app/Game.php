<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 21:09:02 +0000.
 */

namespace App;

use Illuminate\Support\Facades\DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Game
 * 
 * @property int $id
 * @property int $user_id
 * @property int $is_finished
 * @property int $score
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property User $user
 * @property \Illuminate\Database\Eloquent\Collection $questions
 *
 * @package App
 */
class Game extends Eloquent
{
	protected $casts = [
		'user_id' => 'int',
		'is_finished' => 'int',
		'score' => 'int'
	];

	protected $fillable = [
		'user_id',
		'is_finished',
		'score'
	];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function questions() {
		return $this->belongsToMany(Question::class, 'games_questions')
            ->withPivot('id', 'is_correctly_answered')
            ->withTimestamps();
	}

    public static function isLastQuestion($game) {
        return !empty($game->questions) && count($game->questions) >= count(Question::getPointsAsArray());
    }

	public static function createGame($user_id) {
	    $game = self::getCurrentGame($user_id);

        if (self::isLastQuestion($game)) {
            $game->is_finished = 1;

            if ($game->save()) {
                return true;
            }
        } elseif (Question::getNthQuestion(0)) {
            if (empty($game)) {
                $game = new Game();
                $game->user_id = $user_id;
                $game->save();
            }

            $question = Question::getNthQuestion(count($game->questions));

            if ($question) {
                $game_question = new GamesQuestion();
                $game_question->game_id = $game->id;
                $game_question->question_id = $question->id;

                if ($game_question->save()) {
                    return true;
                }
            }
        }

        return false;
    }

	public static function getCurrentGame($user_id) {
        return self::where(['user_id' => $user_id, 'is_finished' => 0])->first();
    }

    public static function getCurrentQuestion($user_id) {
	    $current_game = self::getCurrentGame($user_id);
        $current_question = null;

        if (!empty($current_game)) {
            $current_question = GamesQuestion::where(['game_id' => $current_game->id])->orderBy('id', 'desc')->first();
        }

        return $current_question;
    }

    public function answer(GamesQuestion $question, $user_answers) {
	    if ($question->answer($user_answers)) {
	        $this->score += $question->question->points;
	        $this->save();
        }
    }

    public function interrupt() {
        $this->is_finished = 1;
        $this->save();
    }

    public static function getTopGames($limit) {
	    return Game::select('*', DB::raw('max(score) as ms'))
            ->where('score', '!=', 0)
            ->groupBy('user_id')
            ->orderBy('ms', 'desc')
            ->limit($limit)->get();
    }
}

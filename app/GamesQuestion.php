<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 21:09:02 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class GamesQuestion
 * 
 * @property int $id
 * @property int $game_id
 * @property int $question_id
 * @property int $is_answered
 * @property int $is_correctly_answered
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property Game $game
 * @property Question $question
 *
 * @package App
 */
class GamesQuestion extends Eloquent
{
	protected $casts = [
		'game_id' => 'int',
		'question_id' => 'int',
		'is_answered' => 'int',
		'is_correctly_answered' => 'int'
	];

	protected $fillable = [
		'game_id',
		'question_id',
		'is_answered',
		'is_correctly_answered'
	];

	public function game() {
		return $this->belongsTo(Game::class);
	}

	public function question() {
		return $this->belongsTo(Question::class);
	}

    public function answer($user_answers) {
        $is_correctly_answered = 0;

        if ($user_answers == $this->question->getCorrectAnswerIds()) {
            $is_correctly_answered = 1;
        }

        $this->is_answered = 1;
        $this->is_correctly_answered = $is_correctly_answered;
        $this->save();

        return $is_correctly_answered;
    }
}

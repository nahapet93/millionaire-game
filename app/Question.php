<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 21:09:02 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Question
 * 
 * @property int $id
 * @property string $content
 * @property int $points
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $answers
 * @property \Illuminate\Database\Eloquent\Collection $games
 *
 * @package App
 */
class Question extends Eloquent
{
	protected $casts = [
		'points' => 'int'
	];

	protected $fillable = [
		'content',
		'points'
	];

	public function answers() {
		return $this->hasMany(Answer::class);
	}

	public static function getPointsAsArray() {
	    return self::select('points')->groupBy('points')->orderBy('points')->pluck('points')->toArray();
    }

    public static function getNthQuestion($n) {
	    $points = self::getPointsAsArray();

	    if (!empty($points)) {
            return Question::where(['points' => $points[$n]])->inRandomOrder()->first();
        }

	    return false;
    }

	public function games()
	{
		return $this->belongsToMany(Game::class, 'games_questions')
            ->withPivot('id', 'is_correctly_answered')
            ->withTimestamps();
	}

	public static function createQuestion($content, $points) {
        $question = new Question();
        $question->content = $content;
        $question->points = $points;
        $question->save();

        return $question;
    }

    public function updateQuestion($content, $points) {
        $this->content = $content;
        $this->points = $points;
        $this->save();
    }

    public function saveAnswers($answers) {
        foreach ($answers['content'] as $key => $value) {
            $answer = new Answer();
            $answer->content = $value;

            if($answers['correct'][$key] == 1) {
                $answer->is_correct = 1;
            }

            $answer->question_id = $this->id;
            $answer->save();
        }
    }

    public function updateAnswers($answers) {
        foreach ($answers['content'] as $key => $value) {
            if($this->answers[$key]['content'] != $value) {
                $this->answers[$key]['content'] = $value;
            }

            if($this->answers[$key]['correct'] != $answers['correct'][$key]) {
                $this->answers[$key]['is_correct'] = $answers['correct'][$key];
            }

            $this->answers[$key]->save();
        }
    }

	public function getCorrectAnswerIds() {
        $correct_answers = [];

	    foreach ($this->answers as $answer) {
            if($answer->is_correct) $correct_answers[] = "".$answer->id;
        }

	    return $correct_answers;
    }
}

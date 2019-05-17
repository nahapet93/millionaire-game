<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 21:09:02 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Answer
 * 
 * @property int $id
 * @property int $question_id
 * @property string $content
 * @property int $is_correct
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property Question $question
 *
 * @package App
 */
class Answer extends Eloquent
{
	protected $casts = [
		'question_id' => 'int',
		'is_correct' => 'int'
	];

	protected $fillable = [
		'question_id',
		'content',
		'is_correct'
	];

	public function question() {
		return $this->belongsTo(Question::class);
	}
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return  [
            'id' => $this->id,
            'question' => $this->question,
            'chapter_number' => (int)$this->chapter_number,
            'question_age' => (int)$this->question_age,
            'question_mark' => (int)$this->question_mark,
            'question_complexity' => (int)$this->question_complexity,
            'subject_id'=> (int)$this->subject_id,
            'answers'=>$this->answers,
            'subject' => $this->subject
        ];
    }
}

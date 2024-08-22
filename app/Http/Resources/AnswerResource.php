<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return  [
            'id' => $this->id,
            'answer' => $this->answer,
            'is_correct' => (int)$this->is_correct,
            'question_id'=> (int)$this->question_id,
        ];
    }
}

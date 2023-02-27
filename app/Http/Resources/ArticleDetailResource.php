<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        date_default_timezone_set('Asia/Jakarta');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->whenLoaded('category'),
            'writer' => $this->whenLoaded('writer'),
            'content' => $this->content,
            'thumbnail' => $this->thumbnail,
            'created_at' => date_format($this->created_at, 'l, j M Y, G:i ')  . 'WIB'
        ];
    }
}

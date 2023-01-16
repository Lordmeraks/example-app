<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'budget' => $this->budget,
            'genres' => GenreResource::collection($this->genres),
            'homepage' => $this->homepage,
            'id' => $this->id,
            'original_language' => $this->originalLanguage->name,
            'overview' => $this->overview,
            'popularity' => (float)$this->popularity,
            'poster_path' => $this->poster_path,
            'release_date' => $this->release_date,
            'revenue' => $this->revenue,
            'runtime' => $this->runtime,
            'tagline' => $this->tagline,
            'title' => $this->title,
            'vote_average' => (float)$this->vote_average,
            'vote_count' => $this->vote_count,
            'external_ids' => json_decode($this->external_ids),
            'similar' => json_decode($this->similar),
            'certification' => $this->certification->name,
            'directors' => PersonResource::collection($this->directors),
            'writers' => PersonResource::collection($this->writers),
            'cast' => PersonResource::collection($this->cast),
            'trailer_yt' => $this->trailer_yt
        ];
    }
}

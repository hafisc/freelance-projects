<?php

namespace App\Http\Resources\Api\Education;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EducationCollection extends ResourceCollection
{
    /**
     * Resource yang dikumpulkan.
     *
     * @var string
     */
    public $collects = EducationResource::class;

    /**
     * Transform resource collection menjadi array.
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => EducationResource::collection($this->collection),
        ];
    }
}
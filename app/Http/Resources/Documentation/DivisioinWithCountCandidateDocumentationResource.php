<?php

namespace App\Http\Resources\Documentation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisioinWithCountCandidateDocumentationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => 1,
            "event_id" => 1,
            "name" => "BLJ Angkatan 2024",
            "created_at" => "2024-11-15T13:14:37.000000Z",
            "updated_at" => "2024-11-15T13:14:37.000000Z",
            "candidates_count" => 4
        ];
    }

    public static $wrap = null;
}
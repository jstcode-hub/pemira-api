<?php

namespace App\Http\Resources\Documentation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BallotWithUserDocumentationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => 2,
            "event_id" => 1,
            "npm" => "23081010100",
            "ktm_picture" => "events/ballots/ktm/1.webp",
            "verification_picture" => "events/ballots/verification/2.webp",
            "accepted" => true,
            "accepted_at" => "2024-11-15 20:32:39",
            "accepted_by" => "admin",
            "created_at" => "2024-11-15T20:32:39.000000Z",
            "updated_at" => "2024-11-15T20:32:39.000000Z",
            "user" => new UserDocumentationResource($this->whenLoaded('user'))
        ];
    }

    public static $wrap = null;
}

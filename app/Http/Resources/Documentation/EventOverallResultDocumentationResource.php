<?php

namespace App\Http\Resources\Documentation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventOverallResultDocumentationResource extends JsonResource
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
            "title" => "PEMIRA",
            "description" => "Hima KM Informatika 2024",
            "logo" => "events/logo/pemira.png",
            "is_open" => 0,
            "open_election_at" => "2024-11-18T13:14:36.000000Z",
            "close_election_at" => "2024-11-20T13:14:36.000000Z",
            "created_at" => "2024-11-15T13:14:36.000000Z",
            "updated_at" => "2024-11-15T13:14:36.000000Z",
            "ballots_count" => 2,
            "accepted_ballots_count" => 1,
            "rejected_ballots_count" => 0
        ];
    }

    public static $wrap = null;
}

<?php

namespace App\Http\Resources\Documentation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDocumentationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "npm" => "23081010130",
            "name" => "23081010130 Muhammad Naufal Dzaki Adani",
            "provider_id" => null,
            "picture" => null,
            "email" => "23081010130@student.upnjatim.ac.id",
            "email_verified_at" => null,
            "role" => null,
            "created_at" => "2024-11-15T20:31:21.000000Z",
            "updated_at" => "2024-11-15T20:31:21.000000Z"
        ];
    }

    public static $wrap = null;
}

<?php

namespace App\Http\Resources\Documentation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventSummaryDocumentationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'candidates_count' => 13,
            'whitelists_count' => 228,
            'organizers_count' => 1,
        ];
    }

    /**
     * Disable data wrapping for this resource.
     */
    public static $wrap = null;
}

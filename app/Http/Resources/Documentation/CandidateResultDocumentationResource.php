<?php

namespace App\Http\Resources\Documentation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResultDocumentationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => 2,
            'event_id' => 1,
            'division_id' => 1,
            'order' => 2,
            'first' => "23081010135",
            'first_name' => "Luthfiyana Mahrurin Abadi",
            'second' => null,
            'second_name' => null,
            'vision' => "Mewujudkan BLJ Informatika sebagai lembaga yang aktif, profesional, dan berintegritas dalam pengawasan dan mewadahi aspirasi.",
            'mission' => "Menjalankan tanggung jawab dengan berpegang pada prinsip demokratis, inklusifitas, dan humanis.",
            'picture' => "events/candidates/12.webp",
            'created_by' => "0",
            'created_at' => "2024-11-15T13:14:37.000000Z",
            'updated_at' => "2024-11-15T13:14:37.000000Z",
            'ballots_count' => 1,
            'votes_count' => 1,
        ];
    }

    /**
     * Disable data wrapping for this resource.
     */
    public static $wrap = null;
}

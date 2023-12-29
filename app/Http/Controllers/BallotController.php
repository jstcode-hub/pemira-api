<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ballot;
use App\Models\Division;
use App\Models\Candidate;
use Faker\Provider\Image;
use App\Models\BallotDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BallotController extends Controller
{
    public function index($event)
    {
        $ballots = Ballot::where('event_id', $event)->get();
        return response()->json($ballots);
    }

    public function count($event)
    {
        return Ballot::where('event_id', $event)->count();
    }

    public function store(Request $request, $event)
    {
        $closedEvent = Event::where('id', $event)->whereNotNull('close_election_at')->first();

        if ($closedEvent) {
            return response()->json([
                'success' => false,
                'message' => "Event sudah tertutup. Tidak dapat mengumpulkan surat suara."
            ], 409);
        }

        $request->validate([
            'details' => 'required|array',
            'details.*.division_id' => 'required|exists:divisions,id',
            'details.*.candidate_id' => 'required|exists:candidates,id',
            'ktm_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'verification_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        foreach ($request->details as $detail) {
            $division = Division::query()
                ->where('event_id', $event)
                ->where('id', $detail['division_id'])
                ->first();
            if (!$division) {
                return response()->json([
                    'success' => false,
                    'message' => "Ballot invalid"
                ], 409);
            }

            $candidate = Candidate::query()
                ->where('event_id', $event)
                ->where('id', $detail['candidate_id'])
                ->first();
            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => "Ballot invalid"
                ], 409);
            }
        }

        if (Ballot::query()->where('event_id', $event)->where('npm', $request->user()->npm)->first()) {
            return response()->json([
                'success' => false,
                'message' => "User sudah mencoblos"
            ], 409);
        }

        DB::beginTransaction();

        $ktmPicture = Storage::disk('public')->put(
            'events/ballots/ktm',
            $request->ktm_picture
        );
        $verificationPicture = Storage::disk('public')->put(
            'events/ballots/verification',
            $request->verification_picture
        );

        $ballot = Ballot::query()->create([
            'event_id' => $event,
            'npm' => $request->user()->npm,
            'ktm_picture' => $ktmPicture,
            'verification_picture' => $verificationPicture,
        ]);

        foreach ($request->details as $detail) {
            BallotDetail::query()->create([
                'ballot_id' => $ballot->id,
                'division_id' => $detail['division_id'],
                'candidate_id' => $detail['candidate_id']
            ]);
        }

        DB::commit();

        return response()->json(['message' => 'ballot created successfully']);
    }

    public function accept(Request $request, Event $event, Ballot $ballot)
    {
        $ballot->accepted = 1;
        $ballot->accepted_by = $request->user()->npm;
        $ballot->save();

        return response()->json(['message' => 'ballot accepted successfully']);
    }

    public function reject(Request $request, Event $event, Ballot $ballot)
    {
        $ballot->accepted = 0;
        $ballot->accepted_by = $request->user()->npm;
        $ballot->save();

        return response()->json(['message' => 'ballot rejected successfully']);
    }

    public function next(Event $event)
    {
        return Ballot::query()
            ->with('user')
            ->where('event_id', $event->id)
            ->where('accepted', null)
            ->orderBy('created_at', 'asc')
            ->firstOrFail();
    }

    public function user(Request $request)
    {
        return Ballot::query()->where('npm', $request->user()->npm)->firstOrFail();
    }

    public function latest(Event $event)
    {
        return Ballot::query()
            ->with('user')
            ->where('event_id', $event->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function previous(Event $event, Ballot $ballot)
    {
        return Ballot::query()
            ->with('user')
            ->where('event_id', $event->id)
            ->where('id', $ballot->id - 1)
            ->firstOrFail();
    }
}

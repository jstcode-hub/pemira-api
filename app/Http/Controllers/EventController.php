<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Event;
use App\Models\EventOrganizer;
use App\Models\WhiteList;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use App\Exports\BallotExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function summary($event)
    {
        $candidates_count = Candidate::where('event_id', $event)->count();

        $whitelists_count = WhiteList::where('event_id', $event)->count();

        $organizers_count = EventOrganizer::where('event_id', $event)->count();

        return response()->json([
            "candidates_count" => $candidates_count,
            "whitelists_count" => $whitelists_count,
            "organizers_count" => $organizers_count
        ]);
    }

    public function downloadBallots($event)
    {
        return Excel::download(new BallotExport($event), 'data hasil pemilihan.xlsx');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $event = new Event();
        $event->title = $request->input('title');
        $event->description = $request->input('description');

        $event->logo = Storage::disk('public')->put('events/logo', $request->file('logo'));

        $event->save();

        return response()->json(['message' => 'Event created successfully']);
    }

    public function show($event)
    {
        $event = Event::where('id', $event)->firstOrFail();

        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $event = Event::findOrFail($id);

        if ($request->hasFile('logo')) {
            $oldImagePath = $event->logo;
            Storage::delete('images/logo/' . $oldImagePath);

            $image = $request->file('logo');
            $path = $image->store('images/logo',);
            $event->logo = $path;
        }

        $event->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json(['message' => 'Event updated successfully']);
    }

    public function OpenElection(Request $request, Event $event)
    {
        if ($event->is_open) {
            return response()->json(['message' => 'Election is already open'], 400);
        }

        $event->open_election_at = Carbon::now('Asia/Jakarta');
        $event->is_open = true;
        $event->close_election_at = null;
        $event->save();

        return response()->json(['message' => 'Event open date has been set successfully']);
    }

    public function CloseElection(Request $request, Event $event)
    {
        if (!$event->is_open) {
            return response()->json(['message' => 'Election is already closed'], 400);
        }

        $event->close_election_at = Carbon::now('Asia/Jakarta');
        $event->is_open = false;
        $event->save();

        return response()->json(['message' => 'Event close date has been set successfully']);
    }


    public function deleteEvent($event)
    {
        $event = Event::find($event);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function result(Event $event)
    {
        return $event->divisions()
            ->with('candidates', function ($query) {
                $query->withCount(['ballots', 'votes'])
                    ->orderBy('votes_count', 'desc');
            })
            ->get();
    }

    public function resultOverall(Event $event)
    {
        return $event->loadCount(['ballots', 'acceptedBallots', 'rejectedBallots']);
    }
}

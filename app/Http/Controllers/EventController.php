<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Event;
use App\Models\EventOrganizer;
use App\Models\WhiteList;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $event = Event::all();

        if ($event->isEmpty()) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
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

        $eventLogo = $request->file('logo');
        $eventLogofileName = $event->title . '_' . date('YmdHis') . '_' . $eventLogo->getClientOriginalName();
        $eventLogo->storeAs('images/logo', $eventLogofileName);
        $event->logo = $eventLogofileName;
    
        $event->save();

        return response()->json(['message' => 'Event created successfully']);
    }

    public function show($event)
    {
        $event = Event::where('id', $event)->first();

        if ($event->isEmpty()) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        
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

    public function OpenElection(Request $request, $event)
    {

        $events = Event::find($event);

        if (!$events) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $events->open_election_at = now();
        $events->save();

        return response()->json(['message' => 'Event open date has set successfully']);
    }

    public function CloseElection(Request $request, $event)
    {

        $events = Event::find($event);

        if (!$events) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $events->close_election_at = now();
        $events->save();

        return response()->json(['message' => 'Event close date has set successfully']);
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
}

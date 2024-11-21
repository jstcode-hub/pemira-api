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
use App\Http\Resources\EventResource;
use App\Http\Resources\CandidateResource;
use App\Http\Resources\Documentation\EventResultDocumentationResource;
use App\Http\Resources\Documentation\CandidateResultDocumentationResource;
use App\Http\Resources\Documentation\EventSummaryDocumentationResource;
use App\Http\Resources\Documentation\EventOverallResultDocumentationResource;


class EventController extends Controller
{
    /**
     * Display a listing of Events.
     * @description Mengembalikan daftar semua event yang terdaftar dalam sistem.
     * 
     * @status 200
     * @response Event[]
     */
    public function index()
    {
        return Event::all();
    }

    /**
     * Get Event Summary
     * @description Mengembalikan ringkasan jumlah kandidat, whitelist, dan organizer untuk sebuah event tertentu.
     * 
     * @status 200
     * @response EventSummaryDocumentationResource
     */
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
    
    /**
     * Download Ballots Data
     * @description Mengunduh data hasil pemilihan dalam format Excel untuk event tertentu.
     */
    public function downloadBallots($event)
    {
        return Excel::download(new BallotExport($event), 'data hasil pemilihan.xlsx');
    }

    /**
     * Create a new Event.
     * @descripton Menambahkan event baru dengan data seperti judul, deskripsi, dan logo.
     */
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

     /**
     * Display a Event.
     * @description Menampilkan informasi detail tentang event tertentu.
     * 
     * @status 200
     * @response Event
     */
    public function show($event)
    {
        $event = Event::where('id', $event)->firstOrFail();

        return response()->json($event);
    }

    /**
     * Update Event
     * @description Memperbarui data event seperti judul, deskripsi, atau logo.
     */
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

    /**
     * Open Election for Event
     * @description Membuka proses pemilihan untuk sebuah event tertentu.
     */
    public function OpenElection(Request $request, $event)
    {

        $events = Event::find($event);

        if (!$events) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $events->open_election_at = now();
        $events->is_open = true;
        $events->close_election_at = null;
        $events->save();

        return response()->json(['message' => 'Event open date has set successfully']);
    }

    /**
     * Close Election for Event
     * @description Menutup proses pemilihan untuk sebuah event tertentu.
     */
    public function CloseElection(Request $request, Event $event)
    {
        $event->close_election_at = now();
        $events->is_open = false;
        $event->save();

        return response()->json(['message' => 'Event close date has set successfully']);
    }

    /**
     * Delete Event
     * @description  Menghapus event tertentu dari sistem.
     */
    public function deleteEvent($event)
    {
        $event = Event::find($event);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

    /**
     * Get Election Result
     * @description Mengembalikan hasil pemilihan berdasarkan divisi dan kandidat, termasuk jumlah suara.
     * 
     * @status 200
     * @response EventResultDocumentationResource[]
     */
    public function result(Event $event)
    {
        return $event->divisions()
            ->with('candidates', function ($query) {
                $query->withCount(['ballots', 'votes'])
                    ->orderBy('votes_count', 'desc');
            })
            ->get();
    }

     /**
     * Get Overall Event Results
     * @description Mengembalikan ringkasan hasil keseluruhan dari pemilihan untuk sebuah event.
     * 
     * @status 200
     * @response EventOverallResultDocumentationResource
     */
    public function resultOverall(Event $event)
    {
        return $event->loadCount(['ballots', 'acceptedBallots', 'rejectedBallots']);
    }
}

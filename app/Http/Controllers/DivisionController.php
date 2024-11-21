<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Documentation\DivisioinWithCountCandidateDocumentationResource;

class DivisionController extends Controller
{
     /**
     * Get Divisions by Event
     * @description 
     * 
     * @status 200
     * @response DivisioinWithCountCandidateDocumentationResource[]
     */
    public function index($id)
    {
        $divisions = Division::query()
            ->where('event_id', $id)
            ->withCount('candidates')
            ->get();

        if ($divisions->isEmpty()) {
            return response()->json(['message' => 'Divisions not found'], 404);
        }

        return response()->json($divisions);
    }

     /**
     * Get Division Details
     * @description Mengambil detail divisi berdasarkan ID event dan ID divisi.
     * 
     * @status 200
     * @response Division
     */
    public function show($event, $id)
    {
        $division = Division::where('event_id', $event)->where('id', $id)->firstOrFail();

        return response()->json($division);
    }

     /**
     * Create New Division
     * @description Membuat divisi baru untuk suatu event.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $division = new Division();
        $division->event_id = $id;
        $division->name = $request->input('name');
        $division->save();

        return response()->json(['message' => 'Division created successfully']);
    }

     /**
     * Update Division
     * @description Memperbarui data divisi berdasarkan ID event dan ID divisi.
     */
    public function update(Request $request, $event, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $division = Division::where('event_id', $event)->where('id', $id)->first();

        if (!$division) {
            return response()->json(['message' => 'Division not found'], 404);
        }


        $division->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Division updated successfully']);
    }

     /**
     * Delete Division
     * @description Mengambil daftar kandidat berdasarkan ID event dan, jika diberikan, filter berdasarkan division ID.
     */
    public function destroy($event, $id)
    {
        $division = Division::where('event_id', $event)->where('id', $id)->first();
        $candidates = Candidate::where('division_id', $id)->get();

        if (!$division) {
            return response()->json(['message' => 'Division not found'], 404);
        }

        if ($candidates->count() > 0) {
            return response()->json(['message' => 'Cannot delete division. Division is currently being used by one or multiple candidates.'], 400);
        }

        $division->delete();

        return response()->json(['message' => 'Division deleted successfully']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\WhiteList;
use Illuminate\Http\Request;

class WhiteListController extends Controller
{
     /**
     *  Get Whitelist for Event
     * @description Mengambil daftar whitelist untuk sebuah event berdasarkan ID event.
     * 
     * @status 200
     * @response WhiteList[]
     */
    public function index($event)
    {
        $whitelist = WhiteList::where('event_id', $event)->get();
        return response()->json($whitelist);
    }

     /**
     * Update Whitelist for Event
     * @description Menghapus semua whitelist lama untuk sebuah event dan memperbaruinya dengan daftar whitelist baru.
     */
    public function store(Request $request, $event)
    {
        $whitelist = WhiteList::where('event_id', $event)->delete();

        foreach ($request->whitelists as $key => $val) {
            $whitelist = new WhiteList();
            $whitelist->event_id = $event;
            $whitelist->npm = $val;
            $whitelist->save();
        }

        return response()->json(['message' => 'whitelists created successfully!']);
    }
}

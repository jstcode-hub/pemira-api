<?php

namespace App\Exports;

use App\Models\Ballot;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class BallotExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function view(): View
    {
        $event = $this->event;

        $ballots = Ballot::with('user')
            ->where('event_id', $event)
            ->whereHas('user', function ($query) {
                $query->where('role', 0);
            })
            ->orderBy('npm', 'asc')
            ->get();

        return view('exports.ballots', compact('ballots'));
    }
}

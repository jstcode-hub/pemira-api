<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BallotController;
use App\Http\Controllers\CandidatesController;
use App\Http\Controllers\DivisionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventOrganizerController;
use App\Http\Controllers\WhiteListController;

/*
|--------------------------------------------------------------------------|
| API Routes                                                              |
|--------------------------------------------------------------------------|
| Here is where you can register API routes for your application.          |
| These routes are loaded by the RouteServiceProvider and all of them will  |
| be assigned to the "api" middleware group. Make something great!          |
|--------------------------------------------------------------------------|
*/

Route::prefix('events')->middleware(['auth:sanctum'])->group(function () {

    Route::resource('/', EventController::class)->middleware('panitia');

    Route::get('/{event}', [EventController::class, 'show']);
    Route::post('/{event}/open', [EventController::class, 'OpenElection']);
    Route::post('/{event}/close', [EventController::class, 'CloseElection']);
    Route::delete('/{event}', [EventController::class, 'deleteEvent']);
    Route::get('/{event}/summary', [EventController::class, 'summary']);
    Route::get('/{event}/download/ballots', [EventController::class, 'downloadBallots']);
    Route::get('/{event}/result', [EventController::class, 'result']);
    Route::get('/{event}/result/overall', [EventController::class, 'resultOverall']);

    Route::prefix('{event}/organizers')->name('organizers.')->middleware(['auth:sanctum', 'panitia'])->group(function () {
        Route::get('/', [EventOrganizerController::class, 'index']);
        Route::get('{organizer}', [EventOrganizerController::class, 'show']);
        Route::post('/', [EventOrganizerController::class, 'store']);
        Route::delete('{organizer}', [EventOrganizerController::class, 'destroy']);
        Route::put('{organizer}', [EventOrganizerController::class, 'update']);
    });

    Route::prefix('{event}/whitelists')->name('whitelists.')->middleware(['auth:sanctum', 'panitia'])->group(function () {
        Route::get('', [WhiteListController::class, 'index']);
        Route::post('', [WhiteListController::class, 'store']);
    });

    Route::prefix('{event}/ballots')->name('ballots.')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', [BallotController::class, 'user']);
        Route::get('', [BallotController::class, 'index']);
        Route::get('/count', [BallotController::class, 'count']);
        Route::get('/latest', [BallotController::class, 'latest']);
        Route::post('', [BallotController::class, 'store']);
        Route::get('/{ballot}/previous', [BallotController::class, 'previous']);
        Route::get('/latest-ballot', [BallotController::class, 'latestBallot']);
        Route::get('/next', [BallotController::class, 'next']);
        Route::post('/{ballot}/accept', [BallotController::class, 'accept']);
        Route::post('/{ballot}/reject', [BallotController::class, 'reject']);
    });

    Route::prefix('{event}/divisions')->name('divisions.')->middleware(['auth:sanctum', 'panitia'])->group(function () {
        Route::get('/', [DivisionController::class, 'index']);
        Route::post('/', [DivisionController::class, 'store']);
        Route::delete('{id}', [DivisionController::class, 'destroy']);
        Route::put('{id}', [DivisionController::class, 'update']);
    });

    Route::prefix('{event}/candidates')->name('candidates.')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [CandidatesController::class, 'index']);
        Route::get('/ballots', [CandidatesController::class, 'ballots']);
        Route::get('{candidate}', [CandidatesController::class, 'show']);
        Route::post('/', [CandidatesController::class, 'store']);
        Route::put('{candidate}', [CandidatesController::class, 'update']);
        Route::delete('{candidate}', [CandidatesController::class, 'destroy']);
    });
});

Route::prefix('auth')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/callback', [AuthController::class, 'callback']);
});

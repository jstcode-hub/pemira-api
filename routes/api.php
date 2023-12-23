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
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('events')->middleware(['auth:sanctum', 'panitia'])->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::post('/', [EventController::class, 'store']);
    Route::get('/{event}', [EventController::class, 'show']);
    Route::get('/{event}/summary', [EventController::class, 'summary']);
    Route::post('/{event}/open', [EventController::class, 'OpenElection']);
    Route::post('/{event}/close', [EventController::class, 'CloseElection']);
    Route::delete('/{event}', [EventController::class, 'deleteEvent']);
    Route::put('/{event}', [EventController::class, 'update']);
});

Route::prefix('events')->name('events.')->group(function () {
    Route::prefix('{event}')->name('event.')->group(function () {
        Route::prefix('organizers')->name('organizers.')->middleware(['auth:sanctum', 'panitia'])->group(function () {
            Route::get('/', [EventOrganizerController::class, 'index']);
            Route::get('{organizer}', [EventOrganizerController::class, 'show']);
            Route::post('/', [EventOrganizerController::class, 'store']);
            Route::delete('{organizer}', [EventOrganizerController::class, 'destroy']);
            Route::put('{organizer}', [EventOrganizerController::class, 'update']);
        });

        Route::prefix('whitelists')->name('whitelists.')->middleware(['auth:sanctum', 'panitia'])->group(function () {
            Route::get('', [WhiteListController::class, 'index']);
            Route::post('', [WhiteListController::class, 'store']);
        });

        Route::prefix('ballots')->name('ballots.')->middleware(['auth:sanctum'])->group(function () {
            Route::get('', [BallotController::class, 'index']);
            Route::get('/count', [BallotController::class, 'count']);
            Route::post('', [BallotController::class, 'store']);
            Route::get('/next', [BallotController::class, 'next']);
            Route::get('/{ballot}/accept', [BallotController::class, 'accept']);
            Route::get('/{ballot}/reject', [BallotController::class, 'reject']);
        });
    });
});

Route::prefix('events')->name('events.')->group(function () {
    Route::prefix('{event}')->name('event.')->group(function () {
        Route::prefix('divisions')->name('divisions.')->middleware(['auth:sanctum', 'panitia'])->group(function () {
            Route::get('/', [DivisionController::class, 'index']);
            Route::get('{id}', [DivisionController::class, 'show']);
            Route::post('/', [DivisionController::class, 'store']);
            Route::delete('{id}', [DivisionController::class, 'destroy']);
            Route::put('{id}', [DivisionController::class, 'update']);
        });
    });
});

Route::prefix('events')->name('events.')->group(function () {
    Route::prefix('{event}')->name('event.')->group(function () {
        Route::prefix('candidates')->name('candidates.')->middleware(['auth:sanctum', 'panitia'])->group(function () {
            Route::get('/', [CandidatesController::class, 'index']);
            Route::get('/ballots', [CandidatesController::class, 'ballots']);
            Route::get('/{candidate}', [CandidatesController::class, 'show']);
            Route::post('/', [CandidatesController::class, 'store']);
            Route::put('{candidate}', [CandidatesController::class, 'update']);
            Route::delete('{candidate}', [CandidatesController::class, 'destroy']);
        });
    });
});

Route::prefix('auth')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/callback', [AuthController::class, 'callback']);
});

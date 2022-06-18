<?php

use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::controller(ReportController::class)->group(function () {
    Route::get('list-reports', 'index') -> name('reports.index');
    Route::post('generate-report', 'store') -> name('reports.store');
    Route::get('/get-report/{report_id}', 'show') ->name('reports.show');
    Route::get('/get-report/{report_id}/download', 'download') ->name('reports.download');
});

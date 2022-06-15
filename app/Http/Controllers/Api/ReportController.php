<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Jobs\StoreExcel;
use App\Models\Reports;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        $key = "report";
        if(request()->page){
            $key = $key . request()->page;
        }

        if(Cache::has($key)){
            $reports = Cache::get($key);
        }else{
            $reports = Reports::orderBy('id', 'desc')->paginate(8);
            Cache::put($key, $reports);
        }

        return response()->json([
            'reports' => $reports
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreReportRequest $request)
    {

        $report = new Reports();
        $report->title = $request->description;
        $report->report_link = $this->generateExcel($request->startDate, $request->endDate);
        $report->save();

        Cache::flush();

        return response()->json([
            'message' => "Report saved successful",
            'report' => $report
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reports $reports
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $reports = Reports::findOrFail($id);

        return response()->json([
            'report' => $reports
        ], 200);
    }


    public function download($id)
    {
        $reports = Reports::findOrFail($id);
        return Storage::download($reports->report_link);
    }

    private function generateExcel(string $startDate, string $endDate): string
    {
        # $dateStart = DateTime::createFromFormat('d-m-Y', $startDate)->format('Y-m-d');
        # $dateEnd = DateTime::createFromFormat('d-m-Y', $endDate)->format('Y-m-d');

        $fileName = "Users_" . date('Y-m-d H:i:s') . ".xlsx";
        # StoreExcel::dispatch($dateStart, $dateEnd, $fileName);
        StoreExcel::dispatch($startDate, $endDate, $fileName);
        return $fileName;
    }

}

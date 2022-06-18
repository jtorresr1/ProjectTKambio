<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Models\Reports;
use App\Services\GeneratorExcel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="TKambio Documentation",
 *      description="Api TKambio challengue",
 *      @OA\Contact(
 *          email="jaimetr97@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\Server(url="http://localhost:8000/api")
 */

class ReportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/list-reports",
     *     summary="Show all reports",
     *     tags={"ReportController"},
     *     @OA\Response(
     *         response=200,
     *         description="Show all reports.",
     *         @OA\JsonContent(
     *          @OA\Property(
     *             property="data",
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ReportsDTO")
     *          )
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Bad request."
     *     )
     * )
     *
     */
    public function index()
    {
        $key = 'report';
        if (request()->page) {
            $key = $key . request()->page;
        }

        if (Cache::has($key)) {
            $reports = Cache::get($key);
        } else {
            $reports = Reports::orderBy('id', 'desc')->paginate(8);
            Cache::put($key, $reports);
        }

        return response()->json([
            'reports' => $reports
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/generate-report",
     *      tags={"ReportController"},
     *      summary="Generate new report",
     *      description="Returns report data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreReportRequestDTO")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful generate",
     *          @OA\JsonContent(ref="#/components/schemas/ReportsDTO")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Bad Store Report Request"
     *      )
     * )
     */
    public function store(StoreReportRequest $reportRequest)
    {
        $generatorOfExcel = new GeneratorExcel();
        $report = new Reports();
        $report->title = $reportRequest->get('description');
        $report->file = $generatorOfExcel->generate($reportRequest->get('startDate'), $reportRequest->get('endDate'));
        $report->save();
        $report->report_link = url('/get-report/' . $report->id . '/download');
        $report->save();

        Cache::flush();

        return response()->json([
            'message' => 'Report saved successful',
            'report' => $report
        ], 201);
    }

    /**
     * @OA\Get(
     *      path="/get-report/{report_id}",
     *      tags={"ReportController"},
     *      summary="Get a specific report",
     *      description="Returns report data",
     *     @OA\Parameter(
     *          name="report_id",
     *          description="Report id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful generate",
     *          @OA\JsonContent(ref="#/components/schemas/ReportsDTO")
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not Found Request"
     *      )
     * )
     */
    public function show($reportId)
    {
        $reports = Reports::findOrFail($reportId);

        return response()->json([
            'report' => $reports
        ], 200);
    }

    /**
     * @OA\Get (
     *      path="/get-report/{report_id}/download",
     *      tags={"ReportController"},
     *      summary="Download a specific report",
     *      description="Returns Excel file",
     *     @OA\Parameter(
     *          name="report_id",
     *          description="Report id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful generate",
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not Found Request"
     *      )
     * )
     */
    public function download($reportId)
    {
        $reports = Reports::findOrFail($reportId);
        return Storage::download('Excel/' . $reports->file);
    }
}

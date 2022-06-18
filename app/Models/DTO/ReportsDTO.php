<?php

namespace App\Models\DTO;

/**
 * @OA\Schema(
 *     title="Reports",
 *     description="Report model",
 * )
 */
class ReportsDTO
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="id report",
     *     format="int64",
     *     example=1
     * )
     *
     * @var int
     */
    public $reportId;

    /**
     * @OA\Property(
     *      title="title",
     *      description="Title of the Report",
     *      example="Proof title"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="file",
     *      description="File of the Report",
     *      example="Users.xlsx"
     * )
     *
     * @var string
     */
    public $file;

    /**
     * @OA\Property(
     *      title="Report_Link",
     *      description="Link of the Report to download",
     *      example="http://localhost:8000/get-report/2/download"
     * )
     *
     * @var string
     */
    public $report_link;
    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    public $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    public $updated_at;
}

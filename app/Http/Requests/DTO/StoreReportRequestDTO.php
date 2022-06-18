<?php

namespace App\Http\Requests\DTO;

/**
 * @OA\Schema(
 *      title="Store Report request",
 *      description="Store Report request body data",
 *      type="object",
 *      required={"description", "startDate", "endDate"}
 * )
 */
class StoreReportRequestDTO
{
    /**
     * @OA\Property(
     *      title="description",
     *      description="Title of the report",
     *      example="This is new report's title"
     * )
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="startDate",
     *      description="Start date for the Report",
     *      example="1999/01/01"
     * )
     * @var string
     */
    public $startDate;

    /**
     * @OA\Property(
     *      title="endDate",
     *      description="End date for the Report",
     *      example="2000/01/01"
     * )
     * @var string
     */
    public $endDate;
}

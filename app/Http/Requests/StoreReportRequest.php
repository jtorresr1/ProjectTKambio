<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $minRangeAvailable = strtotime('1980-01-01');
        $maxRangeAvailable= strtotime('-18 years');
        return [
            'description' => 'required',
            'startDate' => 'required|date|after_or_equal:'.$minRangeAvailable . '|before:'.$maxRangeAvailable,
            'endDate' => 'required|date|after:startDate|before_or_equal:'.$maxRangeAvailable,
        ];
    }
}

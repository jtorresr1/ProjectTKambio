<?php

namespace App\Http\Requests;

use App\Exceptions\CustomAuthorizationException;
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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'startDate' => 'required|date|after_or_equal:'.Date('1980-01-01') .'|before:'. Date('2010-12-31'),
            'endDate' => 'required|date|after:startDate|before_or_equal:'. Date('2010-12-31'),
        ];
    }

    protected function failedAuthorization()
    {
        throw new CustomAuthorizationException;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChemicalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'chemical')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'chemical_no' => 'numeric2',
            'old_chemical_no' => 'numeric2',
            'cas' => 'numeric2',
        ];
    }
    public function messages()
    {
        return [
            'chemical_no.numeric2' => '化学物質番号は整数で入力してください。',
            'old_chemical_no.numeric2' => '旧化学物質番号は整数で入力してください。',
            'cas.numeric2' => 'CAS登録番号は整数で入力してください。',
        ];
    }

}

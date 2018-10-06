<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize()
    {
        return false;
    }
 
    public function rules()
    {
        $rules = [
            'images' => 'required'
        ];
        $photos = count($this->input('images'));
        foreach(range(0, $photos) as $index) {
            $rules['images.' . $index] = 'image|mimes:jpeg,png,jpg,gif|max:10240|dimensions:min_width=600,min_height=500';
        }
 
        return $rules;
    }
}

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Laravel Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default  error messages used by
    | the Laravel validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'file' => ':attribute phải là một tập tin.',
    'image' => ':attribute phải là một hình ảnh.',
    'required' => ':attribute là bắt buộc.',
    'max' => [
        'array' => ':attribute không được có nhiều hơn :max phần tử.',
        'file' => ':attribute không được lớn hơn :max kilobytes.',
        'numeric' => ':attribute không được lớn hơn :max.',
        'string' => ':attribute không được lớn hơn :max ký tự.',
    ],
    'mimes' => ':attribute phải là tập tin có định dạng: :values.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [],

];

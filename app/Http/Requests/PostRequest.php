<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
{
    /**
     * 设置验证规则.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:20',
            'age' => 'required|int|min:6',
        ];
    }

    /**
     * 设置验证错误信息.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '名字不能为空',
            'name.max' => '名字不能超过20位',
            'age.int' => '年龄必须为数字'
        ];
    }

    /**
     * 自定义字段名称.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }


    // 重写父类方法failedValidation
    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        $error = $validator->errors()->all();
        throw  new HttpResponseException(response()->json(['code' => 400, 'message' => $error[0]]));
    }
}

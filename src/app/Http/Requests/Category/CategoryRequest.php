<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Проверка данных
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'attributes' => [
                'array'
            ],
            'attributes.*.id' => [
                'sometimes',
                'integer'
            ],
            'attributes.*.name' => [
                'required_with:attributes',
                'string'
            ],
            'attributes.*.type' => [
                'required_with:attributes',
                'integer'
            ],
            'attributes.*.required' => [
                'required_with:attributes',
                'boolean'
            ]
        ];
    }

    /**
     * Сообщения об ошибке
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Наименования атрибутов
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'                  => 'Наименование',
            'attributes'            => 'Атрибуты',
            'attributes.*.name'     => 'Имя атрибута',
            'attributes.*.type'     => 'Тип атрибута',
            'attributes.*.required' => 'Обязательность атрибута'
        ];
    }

    /**
     * Фильтрация данных
     *
     * @return array
     */
    public function filters()
    {
        return [];
    }
}

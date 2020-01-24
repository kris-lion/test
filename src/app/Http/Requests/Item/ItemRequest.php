<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * Проверка данных
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => [
                'required',
                'integer'
            ],
            'attributes' => [
                'array'
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
            'category'     => 'Категория',
            'attributes.*' => 'Атрибуты'
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

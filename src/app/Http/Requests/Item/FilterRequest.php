<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    /**
     * Проверка данных
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => [
                'integer'
            ],
            'limit' => [
                'integer'
            ],
            'search' => [
                'string'
            ],
            'category' => [
                'required_with:search',
                'integer'
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
            'page'  => 'Страница',
            'limit' => 'Лимит записей на странице'
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

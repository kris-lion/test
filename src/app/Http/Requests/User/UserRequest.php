<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Проверка данных
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => [
                'required',
                'string'
            ],
            'roles' => [
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
            'login' => 'Имя пользователя',
            'roles' => 'Роли'
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

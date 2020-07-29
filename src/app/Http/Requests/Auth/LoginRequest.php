<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
                'required'
            ],
            'password' => [
                'required'
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
            'login'    => 'Имя пользователя',
            'password' => 'Пароль'
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

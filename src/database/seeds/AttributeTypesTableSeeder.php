<?php

use App\Models\Category\Attribute\Type;
use Illuminate\Database\Seeder;

class AttributeTypesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'Строка',
            'key'  => 'string'
        ]);

        Type::create([
            'name' => 'Целое число',
            'key'  => 'integer'
        ]);

        Type::create([
            'name' => 'Дробное число',
            'key'  => 'double'
        ]);

        Type::create([
            'name' => 'Логический тип',
            'key'  => 'boolean'
        ]);

        Type::create([
            'name' => 'Выбор из списка',
            'key'  => 'select'
        ]);

        Type::create([
            'name' => 'Выбор из списка нескольких вариантов',
            'key'  => 'multiselect'
        ]);

        Type::create([
            'name' => 'Словарь',
            'key'  => 'dictionary'
        ]);

        Type::create([
            'name'   => 'Массив',
            'key'    => 'array',
            'active' => false
        ]);

        Type::create([
            'name'   => 'Объект',
            'key'    => 'object',
            'active' => false
        ]);

        Type::create([
            'name' => 'Международное непатентованное наименование',
            'key'  => 'generic',
            'active' => false
        ]);
    }
}

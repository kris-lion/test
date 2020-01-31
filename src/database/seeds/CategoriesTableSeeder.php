<?php

use App\Models\Category\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        {
            Category::create([
                'name' => 'ИТ (Информационные технологии) - Закупка ПО, запчастей и расходных материалов для нужд ИТ'
            ]);
        }

        {
            $category = Category::create([
                'name' => 'ГСМ и Запчасти к транспортным средствам (ТС)'
            ]);

            Category::create([
                'name'        => 'ГСМ',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Запасные части к транспортным средствам',
                'category_id' => $category->id
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Дезинфицирующие средства и Моющие средства'
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Диагностика (оборудование и расходные материалы КДЛ)'
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Закупки у естественных монополий'
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Инвентарь и хозяйственные принадлежности'
            ]);

            Category::create([
                'name'        => 'Бытовая техника',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Вентиляция и кондиционирование',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Зоотовары',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Канцелярские принадлежности',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Оборудование, обеспечивающее связь, контроль доступа, видеонаблюдение',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Осветительные приборы',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Офисная мебель и техника',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Посуда, столовые приборы, кухонные принадлежности',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Противопожарное оборудование и средства гражданской обороны',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Сад, огород (Цветы, саженцы, рассада)',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Сантехника',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Спецодежда, мягкий инвентарь',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Спортивный инвентарь',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Средства гигиены',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Уборочный инвентарь и материалы',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Электрооборудование',
                'category_id' => $category->id
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Лекарственные средства'
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Медицинские расходные материалы и зап.части для мед.оборудования'
            ]);

            Category::create([
                'name'        => 'Зап.части для мед оборудования',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Изделия медицинского назначения (медицинская техника, инструменты, "легкое" оборудование)',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Медицинские расходные материалы',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Предметы для стоматологии',
                'category_id' => $category->id
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Основные средства'
            ]);

            Category::create([
                'name'        => 'ИТ-оборудование',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Мебель медицинская',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Мебель немедицинская',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Медицинский транспорт',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Медицинское оборудование',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Немедицинский транспорт',
                'category_id' => $category->id
            ]);

            Category::create([
                'name'        => 'Немедицинское оборудование',
                'category_id' => $category->id
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Продукты питания'
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Средства гигиены, парафармацевтика и космецевтика'
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Стройматериалы'
            ]);
        }

        {
            $category = Category::create([
                'name' => 'Услуги'
            ]);
        }
    }
}

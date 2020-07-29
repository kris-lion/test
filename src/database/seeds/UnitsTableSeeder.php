<?php

use App\Models\Category\Unit;
use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        {
            $type = Unit\Type::where(['name' => 'Международные единицы измерения, включенные в ЕСКК'])->first();

            {
                $group = Unit\Group::where(['name' => 'Единицы длины'])->first();

                Unit::create(['name' => 'Миллиметр', 'code' => '003', 'short' => 'мм', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сантиметр', 'code' => '004', 'short' => 'см', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Дециметр', 'code' => '005', 'short' => 'дм', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Метр', 'code' => '006', 'short' => 'м', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Километр; тысяча метров', 'code' => '008', 'short' => 'км; 10^3 м', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Мегаметр; миллион метров', 'code' => '009', 'short' => 'Мм; 10^6 м', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Дюйм (25,4 мм)', 'code' => '039', 'short' => 'дюйм', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Фут (0,3048 м)', 'code' => '041', 'short' => 'фут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ярд (0,9144 м)', 'code' => '043', 'short' => 'ярд', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Морская миля (1852 м)', 'code' => '047', 'short' => 'миля', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы площади'])->first();

                Unit::create(['name' => 'Квадратный миллиметр', 'code' => '050', 'short' => 'мм2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный сантиметр', 'code' => '051', 'short' => 'см2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный дециметр', 'code' => '053', 'short' => 'дм2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный метр', 'code' => '055', 'short' => 'м2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча квадратных метров', 'code' => '058', 'short' => '10^3 м^2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Гектар', 'code' => '059', 'short' => 'га', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный километр', 'code' => '061', 'short' => 'км2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный дюйм (645,16 мм2)', 'code' => '071', 'short' => 'дюйм2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный фут (0,092903 м2)', 'code' => '073', 'short' => 'фут2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный ярд (0,8361274 м2)', 'code' => '075', 'short' => 'ярд2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ар (100 м2)', 'code' => '109', 'short' => 'а', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы объема'])->first();

                Unit::create(['name' => 'Кубический миллиметр', 'code' => '110', 'short' => 'мм3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кубический сантиметр; миллилитр', 'code' => '111', 'short' => 'см3; мл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Литр; кубический дециметр', 'code' => '112', 'short' => 'л; дм3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кубический метр', 'code' => '113', 'short' => 'м3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Децилитр', 'code' => '118', 'short' => 'дл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Гектолитр', 'code' => '122', 'short' => 'гл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Мегалитр', 'code' => '126', 'short' => 'Мл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кубический дюйм (16387,1 мм3)', 'code' => '131', 'short' => 'дюйм3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кубический фут (0,02831685 м3)', 'code' => '132', 'short' => 'фут3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кубический ярд (0,764555 м3)', 'code' => '133', 'short' => 'ярд3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион кубических метров', 'code' => '159', 'short' => '10^6 м3', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы массы'])->first();

                Unit::create(['name' => 'Гектограмм', 'code' => '160', 'short' => 'гг', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллиграмм', 'code' => '161', 'short' => 'мг', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Метрический карат', 'code' => '162', 'short' => 'кар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Грамм', 'code' => '163', 'short' => 'г', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм', 'code' => '166', 'short' => 'кг', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонна; метрическая тонна (1000 кг)', 'code' => '168', 'short' => 'т', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килотонна', 'code' => '170', 'short' => '10^3 т', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сантиграмм', 'code' => '173', 'short' => 'сг', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Брутто-регистровая тонна (2,8316 м3)', 'code' => '181', 'short' => 'БРТ', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Грузоподъемность в метрических тоннах', 'code' => '185', 'short' => 'т грп', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Центнер (метрический) (100 кг); гектокилограмм; квинтал1 (метрический); децитонна', 'code' => '206', 'short' => 'ц', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Технические единицы'])->first();

                Unit::create(['name' => 'Ватт', 'code' => '212', 'short' => 'Вт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Киловатт', 'code' => '214', 'short' => 'кВт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Мегаватт; тысяча киловатт', 'code' => '215', 'short' => 'МВт; 10^3 кВт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Вольт', 'code' => '222', 'short' => 'В', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Киловольт', 'code' => '223', 'short' => 'кВ', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Киловольт-ампер', 'code' => '227', 'short' => 'кВ.А', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Мегавольт-ампер (тысяча киловольт-ампер)', 'code' => '228', 'short' => 'МВ.А', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Киловар', 'code' => '230', 'short' => 'квар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ватт-час', 'code' => '243', 'short' => 'Вт.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Киловатт-час', 'code' => '245', 'short' => 'кВт.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Мегаватт-час; 1000 киловатт-часов', 'code' => '246', 'short' => 'МВт.ч; 10^3 кВт.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Гигаватт-час (миллион киловатт-часов)', 'code' => '247', 'short' => 'ГВт.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ампер', 'code' => '260', 'short' => 'А', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ампер-час (3,6 кКл)', 'code' => '263', 'short' => 'А.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча ампер-часов', 'code' => '264', 'short' => '10^3 А.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кулон', 'code' => '270', 'short' => 'Кл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Джоуль', 'code' => '271', 'short' => 'Дж', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килоджоуль', 'code' => '273', 'short' => 'кДж', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ом', 'code' => '274', 'short' => 'Ом', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Градус Цельсия', 'code' => '280', 'short' => 'град. C', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Градус Фаренгейта', 'code' => '281', 'short' => 'град. F', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кандела', 'code' => '282', 'short' => 'кд', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Люкс', 'code' => '283', 'short' => 'лк', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Люмен', 'code' => '284', 'short' => 'лм', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кельвин', 'code' => '288', 'short' => 'K', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ньютон', 'code' => '289', 'short' => 'Н', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Герц', 'code' => '290', 'short' => 'Гц', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килогерц', 'code' => '291', 'short' => 'кГц', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Мегагерц', 'code' => '292', 'short' => 'МГц', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Паскаль', 'code' => '294', 'short' => 'Па', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сименс', 'code' => '296', 'short' => 'См', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килопаскаль', 'code' => '297', 'short' => 'кПа', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Мегапаскаль', 'code' => '298', 'short' => 'МПа', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Физическая атмосфера (101325 Па)', 'code' => '300', 'short' => 'атм', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Техническая атмосфера (98066,5 Па)', 'code' => '301', 'short' => 'ат', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Гигабеккерель', 'code' => '302', 'short' => 'ГБк', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Милликюри', 'code' => '304', 'short' => 'мКи', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кюри', 'code' => '305', 'short' => 'Ки', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Грамм делящихся изотопов', 'code' => '306', 'short' => 'г Д/И', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллибар', 'code' => '308', 'short' => 'мб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Бар', 'code' => '309', 'short' => 'бар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Гектобар', 'code' => '310', 'short' => 'гб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килобар', 'code' => '312', 'short' => 'кб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Фарад', 'code' => '314', 'short' => 'Ф', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм на кубический метр', 'code' => '316', 'short' => 'кг/м3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Беккерель', 'code' => '323', 'short' => 'Бк', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Вебер', 'code' => '324', 'short' => 'Вб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Узел (миля/ч)', 'code' => '327', 'short' => 'уз', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Метр в секунду', 'code' => '328', 'short' => 'м/с', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Оборот в секунду', 'code' => '330', 'short' => 'об/с', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Оборот в минуту', 'code' => '331', 'short' => 'об/мин', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Километр в час', 'code' => '333', 'short' => 'км/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Метр на секунду в квадрате', 'code' => '335', 'short' => 'м/с2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кулон на килограмм', 'code' => '349', 'short' => 'Кл/кг', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы времени'])->first();

                Unit::create(['name' => 'Секунда', 'code' => '354', 'short' => 'с', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Минута', 'code' => '355', 'short' => 'мин', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Час', 'code' => '356', 'short' => 'ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сутки', 'code' => '359', 'short' => 'сут; дн', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Неделя', 'code' => '360', 'short' => 'нед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Декада', 'code' => '361', 'short' => 'дек', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Месяц', 'code' => '362', 'short' => 'мес', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квартал', 'code' => '364', 'short' => 'кварт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Полугодие', 'code' => '365', 'short' => 'полгода', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Год', 'code' => '366', 'short' => 'г; лет', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Десятилетие', 'code' => '368', 'short' => 'деслет', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Экономические единицы'])->first();

                Unit::create(['name' => 'Килограмм в секунду', 'code' => '499', 'short' => 'кг/с', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонна пара в час', 'code' => '533', 'short' => 'т пар/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кубический метр в секунду', 'code' => '596', 'short' => 'м3/с', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кубический метр в час', 'code' => '598', 'short' => 'м3/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча кубических метров в сутки', 'code' => '599', 'short' => '10^3 м3/сут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Бобина', 'code' => '616', 'short' => 'боб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Лист', 'code' => '625', 'short' => 'л.', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сто листов', 'code' => '626', 'short' => '100 л.', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча стандартных условных кирпичей', 'code' => '630', 'short' => 'тыс станд. усл. кирп', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Дюжина (12 шт.)', 'code' => '641', 'short' => 'дюжина', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Изделие', 'code' => '657', 'short' => 'изд', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сто ящиков', 'code' => '683', 'short' => '100 ящ.', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Набор', 'code' => '704', 'short' => 'набор', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Пара (2 шт.)', 'code' => '715', 'short' => 'пар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Два десятка', 'code' => '730', 'short' => '20', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Десять пар', 'code' => '732', 'short' => '10 пар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Дюжина пар', 'code' => '733', 'short' => 'дюжина пар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Посылка', 'code' => '734', 'short' => 'посыл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Часть', 'code' => '735', 'short' => 'часть', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Рулон', 'code' => '736', 'short' => 'рул', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Дюжина рулонов', 'code' => '737', 'short' => 'дюжина рул', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Дюжина штук', 'code' => '740', 'short' => 'дюжина шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Элемент', 'code' => '745', 'short' => 'элем', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Упаковка', 'code' => '778', 'short' => 'упак', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Дюжина упаковок', 'code' => '780', 'short' => 'дюжина упак', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сто упаковок', 'code' => '781', 'short' => '100 упак', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Штука', 'code' => '796', 'short' => 'шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сто штук', 'code' => '797', 'short' => '100 шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча штук', 'code' => '798', 'short' => 'тыс. шт; 1000 шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион штук', 'code' => '799', 'short' => '10^6 шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллиард штук', 'code' => '800', 'short' => '10^9 шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Биллион штук (Европа); триллион штук', 'code' => '801', 'short' => '10^12 шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квинтильон штук (Европа)', 'code' => '802', 'short' => '10^18 шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Крепость спирта по массе', 'code' => '820', 'short' => 'креп. спирта по массе', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Крепость спирта по объему', 'code' => '821', 'short' => 'креп. спирта по объему', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Литр чистого (100%) спирта', 'code' => '831', 'short' => 'л 100% спирта', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Гектолитр чистого (100%) спирта', 'code' => '833', 'short' => 'Гл 100% спирта', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм пероксида водорода', 'code' => '841', 'short' => 'кг H2О2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм 90%-го сухого вещества', 'code' => '845', 'short' => 'кг 90% с/в', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонна 90%-го сухого вещества', 'code' => '847', 'short' => 'т 90% с/в', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм оксида калия', 'code' => '852', 'short' => 'кг К2О', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм гидроксида калия', 'code' => '859', 'short' => 'кг КОН', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм азота', 'code' => '861', 'short' => 'кг N', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм гидроксида натри', 'code' => '863', 'short' => 'кг NaOH', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм пятиокиси фосфора', 'code' => '865', 'short' => 'кг Р2О5', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм урана', 'code' => '867', 'short' => 'кг U', 'group_id' => $group->id, 'type_id' => $type->id]);
            }
        }

        {
            $type = Unit\Type::where(['name' => 'Национальные единицы измерения, включенные в ЕСКК'])->first();

            {
                $group = Unit\Group::where(['name' => 'Единицы длины'])->first();

                Unit::create(['name' => 'Погонный метр', 'code' => '018', 'short' => 'пог. м', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча погонных метров', 'code' => '019', 'short' => '10^3 пог. м', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условный метр', 'code' => '020', 'short' => 'усл. м', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных метров', 'code' => '048', 'short' => '10^3 усл. м', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Километр условных труб', 'code' => '049', 'short' => 'км усл. труб', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы площади'])->first();

                Unit::create(['name' => 'Тысяча квадратных дециметров', 'code' => '054', 'short' => '10^3 дм2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион квадратных дециметров', 'code' => '056', 'short' => '10^6 дм2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион квадратных метров', 'code' => '057', 'short' => '10^6 м2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча гектаров', 'code' => '060', 'short' => '10^3 га', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условный квадратный метр', 'code' => '062', 'short' => 'усл. м2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных квадратных метров', 'code' => '063', 'short' => '10^3 усл. м2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион условных квадратных метров', 'code' => '064', 'short' => '10^6 усл. м2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный метр общей площади', 'code' => '081', 'short' => 'м2 общ. пл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча квадратных метров общей площади', 'code' => '082', 'short' => '10^3 м2 общ. пл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион квадратных метров общей площади', 'code' => '083', 'short' => '10^6 м2 общ. пл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный метр жилой площади', 'code' => '084', 'short' => 'м2 жил. пл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча квадратных метров жилой площади', 'code' => '085', 'short' => '10^3 м2 жил. пл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион квадратных метров жилой площади', 'code' => '086', 'short' => '10^6 м2 жил. пл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратный метр учебно-лабораторных зданий', 'code' => '087', 'short' => 'м2 уч. лаб. здан', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча квадратных метров учебно-лабораторных зданий', 'code' => '088', 'short' => '10^3 м2 уч. лаб. здан', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион квадратных метров в двухмиллиметровом исчислении', 'code' => '089', 'short' => '10^6 м2 2 мм исч', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы объема'])->first();

                Unit::create(['name' => 'Тысяча кубических метров', 'code' => '114', 'short' => '10^3 м3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллиард кубических метров', 'code' => '115', 'short' => '10^9 м3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Декалитр', 'code' => '116', 'short' => 'дкл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча декалитров', 'code' => '119', 'short' => '10^3 дкл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион декалитров', 'code' => '120', 'short' => '10^6 дкл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Плотный кубический метр', 'code' => '121', 'short' => 'плотн. м3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условный кубический метр', 'code' => '123', 'short' => 'усл. м3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных кубических метров', 'code' => '124', 'short' => '10^3 усл. м3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион кубических метров переработки газа', 'code' => '125', 'short' => '10^6 м3 перераб. газа', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча плотных кубических метров', 'code' => '127', 'short' => '10^3 плотн. м3', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча полулитров', 'code' => '128', 'short' => '10^3 пол. л', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион полулитров', 'code' => '129', 'short' => '10^6 пол. л', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча литров; 1000 литров', 'code' => '130', 'short' => '10^3 л; 1000 л', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы массы'])->first();

                Unit::create(['name' => 'Тысяча каратов метрических', 'code' => '165', 'short' => '10^3 кар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион каратов метрических', 'code' => '167', 'short' => '10^6 кар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонн', 'code' => '169', 'short' => '10^3 т', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион тонн', 'code' => '171', 'short' => '10^6 т', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонна условного топлива', 'code' => '172', 'short' => 'т усл. топл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонн условного топлива', 'code' => '175', 'short' => '10^3 т усл. топл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион тонн условного топлива', 'code' => '176', 'short' => '10^6 т усл. топл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонн единовременного хранения', 'code' => '177', 'short' => '10^3 т единовр. хран', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонн переработки', 'code' => '178', 'short' => '10^3 т перераб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условная тонна', 'code' => '179', 'short' => 'усл. т', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча центнеров', 'code' => '207', 'short' => '10^3 ц', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Технические единицы'])->first();

                Unit::create(['name' => 'Вольт-ампер', 'code' => '226', 'short' => 'В.А', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Метр в час', 'code' => '231', 'short' => 'м/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килокалория', 'code' => '232', 'short' => 'ккал', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Гигакалория', 'code' => '233', 'short' => 'Гкал', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча гигакалорий', 'code' => '234', 'short' => '10^3 Гкал', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион гигакалорий', 'code' => '235', 'short' => '10^6 Гкал', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Калория в час', 'code' => '236', 'short' => 'кал/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килокалория в час', 'code' => '237', 'short' => 'ккал/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Гигакалория в час', 'code' => '238', 'short' => 'Гкал/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча гигакалорий в час', 'code' => '239', 'short' => '10^3 Гкал/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион ампер-часов', 'code' => '241', 'short' => '10^6 А.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион киловольт-ампер', 'code' => '242', 'short' => '10^6 кВ.А', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Киловольт-ампер реактивный', 'code' => '248', 'short' => 'кВ.А Р', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллиард киловатт-часов', 'code' => '249', 'short' => '10^9 кВт.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча киловольт-ампер реактивных', 'code' => '250', 'short' => '10^3 кВ.А Р', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Лошадиная сила', 'code' => '251', 'short' => 'л. с', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча лошадиных сил', 'code' => '252', 'short' => '10^3 л. с', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион лошадиных сил', 'code' => '253', 'short' => '10^6 л. с', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Бит', 'code' => '254', 'short' => 'бит', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Байт', 'code' => '255', 'short' => 'бай', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килобайт', 'code' => '256', 'short' => 'кбайт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Мегабайт', 'code' => '257', 'short' => 'Мбайт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Бод', 'code' => '258', 'short' => 'бод', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Генри', 'code' => '287', 'short' => 'Гн', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тесла', 'code' => '313', 'short' => 'Тл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм на квадратный сантиметр', 'code' => '317', 'short' => 'кг/см^2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллиметр водяного столба', 'code' => '337', 'short' => 'мм вод. ст', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллиметр ртутного столба', 'code' => '338', 'short' => 'мм рт. ст', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сантиметр водяного столба', 'code' => '339', 'short' => 'см вод. ст', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы времени'])->first();

                Unit::create(['name' => 'Микросекунда', 'code' => '352', 'short' => 'мкс', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллисекунда', 'code' => '353', 'short' => 'млс', 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Экономические единицы'])->first();

                Unit::create(['name' => 'Рубль', 'code' => '383', 'short' => 'руб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча рублей', 'code' => '384', 'short' => '10^3 руб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион рублей', 'code' => '385', 'short' => '10^6 руб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллиард рублей', 'code' => '386', 'short' => '10^9 руб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Триллион рублей', 'code' => '387', 'short' => '10^12 руб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадрильон рублей', 'code' => '388', 'short' => '10^15 руб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Пассажиро-километр', 'code' => '414', 'short' => 'пасс.км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Пассажирское место (пассажирских мест)', 'code' => '421', 'short' => 'пасс. мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча пассажиро-километров', 'code' => '423', 'short' => '10^3 пасс.км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион пассажиро-километров', 'code' => '424', 'short' => '10^6 пасс. км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Пассажиропоток', 'code' => '427', 'short' => 'пасс.поток', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонно-километр', 'code' => '449', 'short' => 'т.км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонно-километров', 'code' => '450', 'short' => '10^3 т.км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион тонно-километров', 'code' => '451', 'short' => '10^6 т. км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча наборов', 'code' => '479', 'short' => '10^3 набор', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Грамм на киловатт-час', 'code' => '510', 'short' => 'г/кВт.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Килограмм на гигакалорию', 'code' => '511', 'short' => 'кг/Гкал', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонно-номер', 'code' => '512', 'short' => 'т.ном', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Автотонна', 'code' => '513', 'short' => 'авто т', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонна тяги', 'code' => '514', 'short' => 'т.тяги', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Дедвейт-тонна', 'code' => '515', 'short' => 'дедвейт.т', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонно-танид', 'code' => '516', 'short' => 'т.танид', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Человек на квадратный метр', 'code' => '521', 'short' => 'чел/м2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Человек на квадратный километр', 'code' => '522', 'short' => 'чел/км2', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонна в час', 'code' => '534', 'short' => 'т/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонна в сутки', 'code' => '535', 'short' => 'т/сут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонна в смену', 'code' => '536', 'short' => 'т/смен', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонн в сезон', 'code' => '537', 'short' => '10^3 т/сез', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонн в год', 'code' => '538', 'short' => '10^3 т/год', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Человеко-час', 'code' => '539', 'short' => 'чел.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Человеко-день', 'code' => '540', 'short' => 'чел.дн', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча человеко-дней', 'code' => '541', 'short' => '10^3 чел.дн', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча человеко-часов', 'code' => '542', 'short' => '10^3 чел.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных банок в смену', 'code' => '543', 'short' => '10^3 усл. банк/ смен', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион единиц в год', 'code' => '544', 'short' => '10^6 ед/год', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Посещение в смену', 'code' => '545', 'short' => 'посещ/смен', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча посещений в смену', 'code' => '546', 'short' => '10^3 посещ/смен', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Пара в смену', 'code' => '547', 'short' => 'пар/смен', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча пар в смену', 'code' => '548', 'short' => '10^3 пар/смен', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион тонн в год', 'code' => '550', 'short' => '10^6 т/год', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тонна переработки в сутки', 'code' => '552', 'short' => 'т перераб/сут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонн переработки в сутки', 'code' => '553', 'short' => '10^3 т перераб/ сут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Центнер переработки в сутки', 'code' => '554', 'short' => 'ц перераб/сут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча центнеров переработки в сутки', 'code' => '555', 'short' => '10^3 ц перераб/ сут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча голов в год', 'code' => '556', 'short' => '10^3 гол/год', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион голов в год', 'code' => '557', 'short' => '10^6 гол/год', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча птицемест', 'code' => '558', 'short' => '10^3 птицемест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча кур-несушек', 'code' => '559', 'short' => '10^3 кур. несуш', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Минимальная заработная плата', 'code' => '560', 'short' => 'мин. заработн. плат', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонн пара в час', 'code' => '561', 'short' => '10^3 т пар/ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча прядильных веретен', 'code' => '562', 'short' => '10^3 пряд.верет', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча прядильных мест', 'code' => '563', 'short' => '10^3 пряд.мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Доза', 'code' => '639', 'short' => 'доз', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча доз', 'code' => '640', 'short' => '10^3 доз', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Единица', 'code' => '642', 'short' => 'ед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча единиц', 'code' => '643', 'short' => '10^3 ед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион единиц', 'code' => '644', 'short' => '10^6 ед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Канал', 'code' => '661', 'short' => 'канал', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча комплектов', 'code' => '673', 'short' => '10^3 компл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Место', 'code' => '698', 'short' => 'мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча мест', 'code' => '699', 'short' => '10^3 мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча номеров', 'code' => '709', 'short' => '10^3 ном', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча гектаров порций', 'code' => '724', 'short' => '10^3 га порц', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча пачек', 'code' => '729', 'short' => '10^3 пач', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Процент', 'code' => '744', 'short' => '%', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Промилле (0,1 процента)', 'code' => '746', 'short' => 'промилле', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча рулонов', 'code' => '751', 'short' => '10^3 рул', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча станов', 'code' => '761', 'short' => '10^3 стан', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Станция', 'code' => '762', 'short' => 'станц', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тюбиков', 'code' => '775', 'short' => '10^3 тюбик', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных тубов', 'code' => '776', 'short' => '10^3 усл.туб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион упаковок', 'code' => '779', 'short' => '10^6 упак', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча упаковок', 'code' => '782', 'short' => '10^3 упак', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Человек', 'code' => '792', 'short' => 'чел', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча человек', 'code' => '793', 'short' => '10^3 чел', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион человек', 'code' => '794', 'short' => '10^6 чел', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион экземпляров', 'code' => '808', 'short' => '10^6 экз', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ячейка', 'code' => '810', 'short' => 'яч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ящик', 'code' => '812', 'short' => 'ящ', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Голова', 'code' => '836', 'short' => 'гол', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча пар', 'code' => '837', 'short' => '10^3 пар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион пар', 'code' => '838', 'short' => '10^6 пар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Комплект', 'code' => '839', 'short' => 'компл', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Секция', 'code' => '840', 'short' => 'секц', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Бутылка', 'code' => '868', 'short' => 'бут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча бутылок', 'code' => '869', 'short' => '10^3 бут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ампула', 'code' => '870', 'short' => 'ампул', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча ампул', 'code' => '871', 'short' => '10^3 ампул', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Флакон', 'code' => '872', 'short' => 'флак', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча флаконов', 'code' => '873', 'short' => '10^3 флак', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тубов', 'code' => '874', 'short' => '10^3 туб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча коробок', 'code' => '875', 'short' => '10^3 кор', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условная единица', 'code' => '876', 'short' => 'усл. ед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных единиц', 'code' => '877', 'short' => '10^3 усл. ед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион условных единиц', 'code' => '878', 'short' => '10^6 усл. ед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условная штука', 'code' => '879', 'short' => 'усл. шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных штук', 'code' => '880', 'short' => '10^3 усл. шт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условная банка', 'code' => '881', 'short' => 'усл. банк', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных банок', 'code' => '882', 'short' => '10^3 усл. банк', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион условных банок', 'code' => '883', 'short' => '10^6 усл. банк', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условный кусок', 'code' => '884', 'short' => 'усл. кус', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных кусков', 'code' => '885', 'short' => '10^3 усл. кус', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион условных кусков', 'code' => '886', 'short' => '10^6 усл. кус', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условный ящик', 'code' => '887', 'short' => 'усл. ящ', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных ящиков', 'code' => '888', 'short' => '10^3 усл. ящ', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условная катушка', 'code' => '889', 'short' => 'усл. кат', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных катушек', 'code' => '890', 'short' => '10^3 усл. кат', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условная плитка', 'code' => '891', 'short' => 'усл. плит', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных плиток', 'code' => '892', 'short' => '10^3 усл. плит', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условный кирпич', 'code' => '893', 'short' => 'усл. кирп', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча условных кирпичей', 'code' => '894', 'short' => '10^3 усл. кирп', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион условных кирпичей', 'code' => '895', 'short' => '10^6 усл. кирп', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Семья', 'code' => '896', 'short' => 'семей', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча семей', 'code' => '897', 'short' => '10^3 семей', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион семей', 'code' => '898', 'short' => '10^6 семей', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Домохозяйство', 'code' => '899', 'short' => 'домхоз', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча домохозяйств', 'code' => '900', 'short' => '10^3 домхоз', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион домохозяйств', 'code' => '901', 'short' => '10^6 домхоз', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Ученическое место', 'code' => '902', 'short' => 'учен. мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча ученических мест', 'code' => '903', 'short' => '10^3 учен. мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Рабочее место', 'code' => '904', 'short' => 'раб. мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча рабочих мест', 'code' => '905', 'short' => '10^3 раб. мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Посадочное место', 'code' => '906', 'short' => 'посад. мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча посадочных мест', 'code' => '907', 'short' => '10^3 посад. мест', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Номер', 'code' => '908', 'short' => 'ном', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квартира', 'code' => '909', 'short' => 'кварт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча квартир', 'code' => '910', 'short' => '10^3 кварт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Койка', 'code' => '911', 'short' => 'коек', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча коек', 'code' => '912', 'short' => '10^3 коек', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Том книжного фонда', 'code' => '913', 'short' => 'том книжн. фонд', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча томов книжного фонда', 'code' => '914', 'short' => '10^3 том. книжн. фонд', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условный ремонт', 'code' => '915', 'short' => 'усл. рем', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условный ремонт в год', 'code' => '916', 'short' => 'усл. рем/год', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Смена', 'code' => '917', 'short' => 'смен', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Лист авторский', 'code' => '918', 'short' => 'л. авт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Лист печатный', 'code' => '920', 'short' => 'л. печ', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Лист учетно-издательский', 'code' => '921', 'short' => 'л. уч.-изд', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Знак', 'code' => '922', 'short' => 'знак', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Слово', 'code' => '923', 'short' => 'слово', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Символ', 'code' => '924', 'short' => 'символ', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Условная труба', 'code' => '925', 'short' => 'усл. труб', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча пластин', 'code' => '930', 'short' => '10^3 пласт', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион доз', 'code' => '937', 'short' => '10^6 доз', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион листов-оттисков', 'code' => '949', 'short' => '10^6 лист.оттиск', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Вагоно(машино)-день', 'code' => '950', 'short' => 'ваг (маш).дн', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча вагоно-(машино)-часов', 'code' => '951', 'short' => '10^3 ваг (маш).ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча вагоно-(машино)-километров', 'code' => '952', 'short' => '10^3 ваг (маш).км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча место-километров', 'code' => '953', 'short' => '10 ^3мест.км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Вагоно-сутки', 'code' => '954', 'short' => 'ваг.сут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча поездо-часов', 'code' => '955', 'short' => '10^3 поезд.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча поездо-километров', 'code' => '956', 'short' => '10^3 поезд.км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонно-миль', 'code' => '957', 'short' => '10^3 т.миль', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча пассажиро-миль', 'code' => '958', 'short' => '10^3 пасс.миль', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Автомобиле-день', 'code' => '959', 'short' => 'автомоб.дн', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча автомобиле-тонно-дней', 'code' => '960', 'short' => '10^3 автомоб.т.дн', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча автомобиле-часов', 'code' => '961', 'short' => '10^3 автомоб.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча автомобиле-место-дней', 'code' => '962', 'short' => '10^3 автомоб.мест. дн', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Приведенный час', 'code' => '963', 'short' => 'привед.ч', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Самолето-километр', 'code' => '964', 'short' => 'самолет.км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча километров', 'code' => '965', 'short' => '10^3 км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тоннаже-рейсов', 'code' => '966', 'short' => '10^3 тоннаж. рейс', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион тонно-миль', 'code' => '967', 'short' => '10^6 т. миль', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион пассажиро-миль', 'code' => '968', 'short' => '10^6 пасс. миль', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион тоннаже-миль', 'code' => '969', 'short' => '10^6 тоннаж. миль', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион пассажиро-место-миль', 'code' => '970', 'short' => '10^6 пасс. мест. миль', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кормо-день', 'code' => '971', 'short' => 'корм. дн', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Центнер кормовых единиц', 'code' => '972', 'short' => 'ц корм ед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча автомобиле-километров', 'code' => '973', 'short' => '10^3 автомоб. км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тоннаже-сут', 'code' => '974', 'short' => '10^3 тоннаж. сут', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Суго-сутки', 'code' => '975', 'short' => 'суго. сут.', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Штук в 20-футовом эквиваленте (ДФЭ)', 'code' => '976', 'short' => 'штук в 20-футовом эквиваленте', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Канало-километр', 'code' => '977', 'short' => 'канал. км', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Канало-концы', 'code' => '978', 'short' => 'канал. конц', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча экземпляров', 'code' => '979', 'short' => '10^3 экз', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча долларов', 'code' => '980', 'short' => '10^3 доллар', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысяча тонн кормовых единиц', 'code' => '981', 'short' => '10^3 корм ед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миллион тонн кормовых единиц', 'code' => '982', 'short' => '10^6 корм ед', 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Судо-сутки', 'code' => '983', 'short' => 'суд.сут', 'group_id' => $group->id, 'type_id' => $type->id]);
            }
        }

        {
            $type = Unit\Type::where(['name' => 'Международные единицы измерения, не включенные в ЕСКК'])->first();

            {
                $group = Unit\Group::where(['name' => 'Единицы длины'])->first();

                Unit::create(['name' => 'Гектометр', 'code' => '017', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Миля (уставная) (1609,344 м)', 'code' => '045', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы площади'])->first();

                Unit::create(['name' => 'Акр (4840 квадратных ярдов)', 'code' => '077', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квадратная миля', 'code' => '079', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы объема'])->first();

                Unit::create(['name' => 'Жидкостная унция СК (28,413 см3)', 'code' => '135', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Джилл СК (0,142065 дм3)', 'code' => '136', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Пинта СК (0,568262 дм3)', 'code' => '137', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Кварта СК (1,136523 дм3)', 'code' => '138', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Галлон СК (4,546092 дм3)', 'code' => '139', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Бушель СК (36,36874 дм3)', 'code' => '140', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Жидкостная унция США (29,5735 см3)', 'code' => '141', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Джилл США (11,8294 см3)', 'code' => '142', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Жидкостная пинта США (0,473176 дм3)', 'code' => '143', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Жидкостная кварта США (0,946353 дм3)', 'code' => '144', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Жидкостный галлон США (3,78541 дм3)', 'code' => '145', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Баррель (нефтяной) США (158,987 дм3)', 'code' => '146', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сухая пинта США (0,55061 дм3)', 'code' => '147', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сухая кварта США (1,101221 дм3)', 'code' => '148', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сухой галлон США (4,404884 дм3)', 'code' => '149', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Бушель США (35,2391 дм3)', 'code' => '150', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сухой баррель США (115,627 дм3)', 'code' => '151', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Стандарт', 'code' => '152', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Корд (3,63 м3)', 'code' => '153', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тысячи бордфутов (2,36 м3)', 'code' => '154', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Единицы массы'])->first();

                Unit::create(['name' => 'Нетто-регистровая тонна', 'code' => '182', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Обмерная (фрахтовая) тонна', 'code' => '183', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Водоизмещение', 'code' => '184', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Фунт СК, США (0,45359237 кг)', 'code' => '186', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Унция СК, США (28,349523 г)', 'code' => '187', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Драхма СК (1,771745 г)', 'code' => '188', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Гран СК, США (64,798910 мг)', 'code' => '189', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Стоун СК (6,350293 кг)', 'code' => '190', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Квартер СК (12,700586 кг)', 'code' => '191', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Центал СК (45,359237 кг)', 'code' => '192', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Центнер США (45,3592 кг)', 'code' => '193', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Длинный центнер СК (50,802345 кг)', 'code' => '194', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Короткая тонна СК, США (0,90718474 т) [2*]', 'code' => '195', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Длинная тонна СК, США (1,0160469 т) [2*]', 'code' => '196', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Скрупул СК, США (1,295982 г)', 'code' => '197', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Пеннивейт СК, США (1,555174 г)', 'code' => '198', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Драхма СК (3,887935 г)', 'code' => '199', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Драхма США (3,887935 г)', 'code' => '200', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Унция СК, США (31,10348 г); тройская унция', 'code' => '201', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Тройский фунт США (373,242 г)', 'code' => '202', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Технические единицы'])->first();

                Unit::create(['name' => 'Эффективная мощность (245,7 ватт)', 'code' => '213', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Британская тепловая единица (1,055 кДж)', 'code' => '275', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
            }

            {
                $group = Unit\Group::where(['name' => 'Экономические единицы'])->first();

                Unit::create(['name' => 'Гросс (144 шт.)', 'code' => '638', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Большой гросс (12 гроссов)', 'code' => '731', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Короткий стандарт (7200 единиц)', 'code' => '738', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Галлон спирта установленной крепости', 'code' => '835', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Международная единица', 'code' => '851', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
                Unit::create(['name' => 'Сто международных единиц', 'code' => '853', 'short' => null, 'group_id' => $group->id, 'type_id' => $type->id]);
            }
        }
    }
}

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Саня
 * Date: 17.07.13
 * Time: 17:07
 * To change this template use File | Settings | File Templates.
 */
 
class UniqueComponent extends CApplicationComponent {

    // регион поиска в Яндексе
    public $ya_region = 225;

    // процент уникальности текста, после обработки результатов из поисковика и сравнения текста с результатами из ПС
    public $unique_percent;

//    public function init()
//    {
//        parent::init();
//    }

    // метод для определения уникальности текста
    //$text - текст который необходимо проверить на уникальность
    public function runCheck($text){
        /*берешь текст
        бьешь на части по 500 символов
        из части берешь 3 разных куска размером в Х шинглов (шинглы настраиваются где-то в конфиге)
        чистишь от всего, кроме точек
        вбиваешь в яндекс, причем вбиваешь через оператор ||
         */

        // компонент для анализа и обработки текста
        $shingle = Yii::app()->shingle;

        // получаем список частей(по тексту)+по каждой части - массив шинглов, заданного размера
        $list_parts = $shingle->get3Parts($text);

        // по каждой части делаем запрос к яндексу, где указываем 3 разных шингла
        //array('part_text'=>$part_text, 'shingles_list'=>$list_shingle);
        foreach($list_parts as $row){
            // получаем список источников, которые выдал нам Яндекс при запросе с шинглами
            $urls_yandex = $this->parseYandex($row['shingles_list']);

        }
    }

    /*
     * запрос к яндексу для получения списка ссылок по 3 разным кускам шинглов по тексту
     */
    public function parseYandex($shingle_list){
        // формируем строку для отправки запроса к яндексу
        //("шингл 1") | ("шингл 2")| ("шингл 3")
        $url_shingle = '("'.$shingle_list[0].'")|("'.$shingle_list[1].'")|("'.$shingle_list[2].'")';

        // используем поведение, для отправки запроса к яндексу, через прокси
        // страница результатов яндекса - выдача ПС
//        $ya_page = $this->get(
//            $url_shingle,
//            '',
//
//        );
    }

}

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Александр
 * Date: 14.11.12
 * Time: 10:41
 * To change this template use File | Settings | File Templates.
 */
/*
 * класс для проверки текста на пунктуационные ошибки
 */
class Punctuation{

    // текст для проверки на ошибки, текст для обработки
    public $sourceText;
    public $title; // заголовок поля, которое проверяем классом

    // запуск проверки по поиску ошибок пунктуации в тексте
    public function run(){

        return array('result'=>true, 'msg'=>'');
    }
}
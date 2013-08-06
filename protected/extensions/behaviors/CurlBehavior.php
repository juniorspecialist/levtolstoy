<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Саня
 * Date: 17.07.13
 * Time: 17:22
 * To change this template use File | Settings | File Templates.
 */
/*
 * поведение для отправки запросов через CURL библиотеку - базовый функционал
 */
class CurlBehavior  extends CBehavior{

    /*
     * отправляем POST запрос, с указанием заголовка, адреса, данных для отправки и т.д.
     * $proxy - если указан, значит используем прокси сервер, если указан логин и пароль к ПРОКСИ, значит прокси требует авторизации
     */
    public function post($url, $header='', $data='', $proxy='', $proxy_login='', $proxy_pass=''){

        if( $curl = curl_init() ) {

            if($proxy!=''){

                // если есть прокси, то определяем прокси и сам порт для этого прокси
                $exp_proxy = explode(':', $proxy);

                curl_setopt($curl, CURLOPT_PROXY, $exp_proxy[0]);

                if(!empty($exp_proxy[1])){
                    curl_setopt($curl, CURLOPT_PROXYPORT, $exp_proxy[1]);
                }else{
                    curl_setopt($curl, CURLOPT_PROXYPORT, '8080');
                }

                if(!empty($proxy_login) || !empty($proxy_pass)){
                    curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
                    curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_login.':'.$proxy_pass);
                }
            }

            curl_setopt($curl, CURLOPT_URL, $url);

            if(empty($header)){
                $header = array("HTTP/1.1",
                    "Content-Type: application/x-www-form-urlencoded",
                    "Authorization: Basic "
                );
            }
            $header[] = 'Expect:';

            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

            curl_setopt($curl, CURLOPT_ENCODING,'');

            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);

            curl_setopt($curl, CURLOPT_POST, true);

            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            curl_setopt($curl, CURLOPT_COOKIEFILE, Yii::getPathOfAlias("application.runtime").'/cookie.txt');
            curl_setopt($curl, CURLOPT_COOKIEJAR, Yii::getPathOfAlias("application.runtime").'/cookie.txt');

            curl_setopt($curl, CURLOPT_USERAGENT, $this->rnd_user_agent());

            $out = curl_exec($curl);

            curl_close($curl);

            if (!empty($out)) {
                unset($curl);
                return $out;
            }else{
                echo "Curl Error" . curl_error($curl);
                unset($curl);
            }
        }
    }

    /*
     * отправка GET запроса с помощью прокси, кукисов и т.д.
     */
    public function  get($url, $header='', $proxy='', $proxy_login='', $proxy_pass=''){

       if( $curl = curl_init() ) {

            if($proxy!=''){

                // если есть прокси, то определяем прокси и сам порт для этого прокси
                $exp_proxy = explode(':', $proxy);

                curl_setopt($curl, CURLOPT_PROXY, $exp_proxy[0]);

                if(!empty($exp_proxy[1])){
                    curl_setopt($curl, CURLOPT_PROXYPORT, $exp_proxy[1]);
                }else{
                    curl_setopt($curl, CURLOPT_PROXYPORT, '8080');
                }

                if(!empty($proxy_login) || !empty($proxy_pass)){
                    curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
                    curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_login.':'.$proxy_pass);
                }
            }

            curl_setopt($curl, CURLOPT_URL, $url);

//            if(empty($header)){
//                $header = array("HTTP/1.1",
//                    "Content-Type: application/x-www-form-urlencoded",
//                    "Authorization: Basic "
//                );
//            }
            $header[] = 'Expect:';

            //curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_ENCODING,'');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_COOKIEFILE, Yii::getPathOfAlias("application.runtime").'/cookie.txt');
            curl_setopt($curl, CURLOPT_COOKIEJAR, Yii::getPathOfAlias("application.runtime").'/cookie.txt');
            curl_setopt($curl, CURLOPT_USERAGENT, $this->rnd_user_agent());

            $out = curl_exec($curl);
            curl_close($curl);

            if (!empty($out)) {
                unset($curl);
                return $out;
            }else{
                echo "Curl Error" . curl_error($curl);
                unset($curl);
            }
        }
    }

    /*
     * получаем случайный юзер-агент
     */
    public function rnd_user_agent(){

        $list = array(
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FunWebProducts)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; MRA 4.3 (build 01218); .NET CLR 1.1.4322)',
            'Opera/9.01 (Windows NT 5.1; U; en)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1) Opera 7.54 [en]',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; MRA 4.6 (build 01425))',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; ru) Opera 8.01',
            'Opera/9.00 (Windows NT 5.1; U; ru)',
            'Opera/9.0 (Windows NT 5.1; U; en)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FunWebProducts; MRA 4.6 (build 01425); .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; ru) Opera 8.01',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; MRA 4.6 (build 01425); MRSPUTNIK 1, 5, 0, 19 SW)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
            'Mozilla/4.0 (compatible; MSIE 6.0; AOL 9.0; Windows NT 5.1) ',
        );

        $index = rand(0, sizeof($list));

        return $list[$index];
    }

    /*
     * случайная прокси, для оотправки запросов к ПС
     */
    public function getRndProxy(){

    }

    /*
     * проверим прокси на работоспособность
     * $proxy, формат - ip:port
     */
    public function checkProxy($proxy){

        if(file_exists(Yii::getPathOfAlias("application.runtime").'/proxy.txt')){

            $file = file(Yii::getPathOfAlias("application.runtime").'/proxy.txt');

            // получаем случайное прокси из списка и чекаем их на работоспособность
            for($try=1;$try<20;$try++){

                $index = rand(0, sizeof($file)-1);

                $proxy = $file[$index];

                list($ip,$port)= explode(":",$proxy);

                $ip = trim($ip);

                $port = trim($port);

                $connect = fsockopen($ip, $port, $errn, $errst, 5);
                if ($connect) {
                    return $proxy;
                }
            }

            return 'Не найдено рабочих проксей из обработанного списка';

        }else{
            echo 'Ошибка. Не найден файл с проксями.По пути:'.Yii::getPathOfAlias("application.runtime").'/cookie.txt';
        }
    }
}
 

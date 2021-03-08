<?php

    require_once('./smsimple.config.php');
    require_once('./smsimple.class.php');

    header('Content-type: text/html; charset=utf-8');

    $sms = new SMSimple(array(
        'url' => SMS_API,
        'username' => SMS_USERNAME,
        'password' => SMS_PASSWORD,
    ));

    try {

		$origin_id = 53315; // номер подписи

        $sms->connect();
        $job_id = $sms->addMultisendJob(array(
            'origin_id'   => $origin_id,    // id-подписи отправителя
            //'title'       => 'New job',     // название рассылки
            'messages'    => array(
                                    array('phone' => '89060555242', 'text' => 'asdf1'),
                                    array('phone' => '89255073860', 'text' => 'asdf2'),
                                 ),
            'delete_groups' => 1
        ));
        print 'Job #'.$job_id.' successfully created';

    }
    catch (SMSimpleException $e) {
        print $e->getMessage();
    }

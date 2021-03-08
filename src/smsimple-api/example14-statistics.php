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

		$sms->connect();
        $stat = $sms->sms_statistic(
            2014,07,31,  // year_begin,month_begin,day_begin
            2014,07,31,  // year_end,month_end,day_end
            false,       // count
            0,           // limit
            0);          // offset
        print 'Stat:<pre>';
        var_dump($stat);
        print '</pre>';

    }
    catch (SMSimpleException $e) {
        print $e->getMessage();
    }

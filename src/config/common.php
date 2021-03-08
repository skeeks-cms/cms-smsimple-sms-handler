<?php
return [
    'components' => [
        'cms' => [
            'smsHandlers'             => [
                \skeeks\cms\sms\smsimple\SmsimpleHandler::class
            ]
        ],
    ],
];
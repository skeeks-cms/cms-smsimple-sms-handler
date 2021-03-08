<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\sms\smsimple;

use skeeks\cms\sms\SmsHandler;
use skeeks\yii2\form\fields\FieldSet;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

/**
 *
 * @see https://smsimple.ru/api-http/
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class SmsimpleHandler extends SmsHandler
{
    public $login = "";
    public $password = "";
    public $sender = "0";

    /**
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('skeeks/shop/app', 'Smsimple'),
        ]);
    }


    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['login'], 'required'],
            [['password'], 'required'],

            [['login'], 'string'],
            [['password'], 'string'],

            [['sender'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'login'    => "Логин",
            'password' => "Пароль",

            'sender' => "Отправитель по умолчанию",

        ]);
    }

    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [

        ]);
    }


    /**
     * @return array
     */
    public function getConfigFormFields()
    {
        return [
            'main' => [
                'class'  => FieldSet::class,
                'name'   => 'Основные',
                'fields' => [
                    'login',
                    'password',
                    'sender',
                ],
            ],
        ];
    }


    /**
     * @see https://smsimple.ru/api-http/
     *
     * @param      $phone
     * @param      $text
     * @param null $sender
     * @return $message_id
     */
    public function send($phone, $text, $sender = null)
    {
        $queryString = http_build_query([
            'user'    => $this->login,
            'pass'    => $this->password,
            'or_id'   => $this->sender,
            'phone'   => $phone,
            'message' => $text,
        ]);

        $url = 'https://smsimple.ru/http_send.php?'.$queryString;


        $stream_opts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];

        print_r($url);die;
        $response = file_get_contents($url, false, stream_context_create($stream_opts));
        return $response;

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->setOptions([
                "ssl" => [
                    "verify_peer"      => false,
                    "verify_peer_name" => false,
                ],
            ])
            ->send();

        if (!$response->isOk) {
            throw new Exception($response->content);
        }

        return $response->content;
    }

    /**
     * @param $message_id
     * @return mixed
     */
    public function status($message_id)
    {

    }
}
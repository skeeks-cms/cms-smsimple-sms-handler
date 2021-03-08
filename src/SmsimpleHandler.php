<?php

require_once('./smsimple-api/smsimple.class.php');

/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\sms\smsimple;

use skeeks\cms\sms\SmsHandler;
use skeeks\yii2\form\fields\FieldSet;
use skeeks\yii2\form\fields\NumberField;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class SmsimpleHandler extends SmsHandler
{
    public $host = "http://api.smsimple.ru";
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
            [['host'], 'required'],
            [['login'], 'required'],
            [['password'], 'required'],

            [['host'], 'string'],
            [['login'], 'string'],
            [['password'], 'string'],

            [['sender'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'host' => "Сервер отправки",

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

    protected function _send($to, $text, $sender = null) {

    }

    /**
     * @return array
     */
    public function getConfigFormFields()
    {
        return [
            'main'    => [
                'class'  => FieldSet::class,
                'name'   => 'Основные',
                'fields' => [
                    'login',
                    'password',
                    'sender',
                ],
            ],
            'default' => [
                'class'  => FieldSet::class,
                'name'   => 'Прочее',
                'fields' => [
                    'host',
                ],
            ],
        ];
    }
}
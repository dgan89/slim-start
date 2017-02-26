<?php
namespace App;

class SmsApi extends Sms
{
    public static function fields()
    {
        return [
            'id' => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
            'phone' => ['type' => 'string', 'required' => true],
            'text' => ['type' => 'text', 'required' => true],
            'type' => ['type' => 'integer', 'default' => 0]
        ];
    }
}
<?php
namespace App;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

class Sms extends \Spot\Entity
{
    protected static $table = 'sms';
  
    protected static $mapper = 'App\SmsMapper';
    
    const STATUS_WAIT = 0;
    const STATUS_DELIVERED = 10;
    const STATUS_UNDELIVERED = 20;
    const STATUS_PROCESS = 30;
    
    const TYPE_SYSTEM = 10;
    const TYPE_DEFAULT = 0;
    
    public static $statusList = [
        self::STATUS_WAIT => 'Ожидает выполнения',
        self::STATUS_DELIVERED => 'Выполнено',
        self::STATUS_UNDELIVERED => 'Не выполнено',
        self::STATUS_PROCESS => 'Ожидает выполнения',
    ];
    
    private static $statusIcon = [
        self::STATUS_WAIT => 'android-time',
        self::STATUS_DELIVERED => 'android-done',
        self::STATUS_UNDELIVERED => 'android-sad',
        self::STATUS_PROCESS => 'android-time',
    ];

    public static function fields()
    {
        return [
            'id' => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
            'phone' => ['type' => 'string', 'required' => true],
            'text' => ['type' => 'text', 'required' => true],
            'user_id' => ['type' => 'integer', 'default' => 1],
            'status' => ['type' => 'integer', 'default' => 0, 'index' => true],
            'type' => ['type' => 'integer', 'default' => 0],
            'delivered_at' => ['type' => 'datetime'],
            'created_at' => ['type' => 'datetime', 'value' => new \DateTime()]
        ];
    }
  
    public function statusName()
    {
        return self::$statusList[$this->status];
    }
    
    public function statusIcon()
    {
        return self::$statusIcon[$this->status];
    }
}
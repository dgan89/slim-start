<?php
namespace App;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

class Log extends \Spot\Entity
{
    protected static $table = 'log';
    
    protected static $mapper = 'App\LogMapper';
    
    const TYPE_BALANCE = 'balance';
    const TYPE_STATE = 'state';
    const TYPE_REBOOT = 'reboot';
    const TYPE_ERROR = 'error';
    
    public static $statusList = [
        self::TYPE_BALANCE => 'Баланс',
        self::TYPE_STATE => 'Запущен',
        self::TYPE_REBOOT => 'Перезагрузка',
        self::TYPE_ERROR => 'Ошибка',
    ];
    
    private static $statusIcon = [
        self::TYPE_BALANCE => 'social-yen',
        self::TYPE_STATE => 'flag',
        self::TYPE_REBOOT => 'loop',
        self::TYPE_ERROR => 'sad'
    ];
    
    public static function fields()
    {
        return [
            'id' => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
            'type' => ['type' => 'string', 'required' => true],
            'value' => ['type' => 'string', 'value' => NULL],
            'created_at' => ['type' => 'datetime', 'value' => new \DateTime()]
        ];
    }
    
    public function name()
    {
        return self::$statusList[$this->type];
    }
    
    public function icon()
    {
        return self::$statusIcon[$this->type];
    }
}
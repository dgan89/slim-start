<?php
namespace App;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

class Sms extends \Spot\Entity
{
    protected static $table = 'sms';
  
    protected static $mapper = 'App\SmsMapper';

    public static function fields()
    {
        return [
            'id' => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
        ];
    }
  

}
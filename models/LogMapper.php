<?php
namespace App;

use Spot\Mapper;

class LogMapper extends Mapper
{
    const TYPE_BALANCE = 'balance';
    
    public function scopes()
    {
        return [
            'balance' => function ($query) {
                return $query->where(['type' => self::TYPE_BALANCE]);
            }
        ];
    }
    
    public function currentBalance()
    {
        return $this->select()->balance()
            ->order(['created_at' => 'DESC'])->first();
    }
    
    public function itemList()
    {
        return $this->select()->order(['created_at' => 'DESC']);
    }
    
    public function trash()
    {
        return $this->delete();
    }
}
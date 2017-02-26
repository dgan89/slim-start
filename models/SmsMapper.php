<?php
namespace App;

use Spot\Mapper;

class SmsMapper extends Mapper
{
    const STATUS_WAIT = 0;
    const STATUS_DELIVERED = 10;
    const STATUS_UNDELIVERED = 20;
    const STATUS_PROCESS = 30;
    
    const TYPE_SYSTEM = 10;
    const TYPE_DEFAULT = 0;
    
    const SYSTEM_PHONE = "+7 (999) 999-99-99";
    
    public function scopes()
    {
        return [
            'isAuthor' => function ($query) {
                return $query->where(['user_id' => 1]);
            },
            'new' => function ($query) {
                return $query->where(['status' => self::STATUS_WAIT]);
            },
            'system' => function ($query) {
                return $query->where(['type' => self::TYPE_SYSTEM]);
            },
            'default' => function ($query) {
                return $query->where(['type' => self::TYPE_DEFAULT]);
            },
            'inProcess' => function ($query) {
                return $query->where(['status' => self::STATUS_PROCESS]);
            },
        ];
    }
    
    public function itemList()
    {
        return $this->select()->isAuthor()->default()
            ->order(['created_at' => 'DESC']);
    }
    
    public function commandList()
    {
        return $this->select()->system()
            ->order(['created_at' => 'DESC']);
    }
    
    public function listToDelivery()
    {
        return $this->select(['id', 'phone', 'text', 'type'])->new()
            ->order(['created_at' => 'ASC'])
            ->limit(5)->toArray();
    }
    
    public function listSystem()
    {
        return $this->select(['id', 'phone', 'text', 'type'])->new()->system()
            ->order(['created_at' => 'ASC'])
            ->limit(5)->toArray();
    }
    
    public function setAsDelivered($ids = [])
    {
        foreach ($ids as $id) {
            $this->resolver()->update($this->table(), [
                'status' => self::STATUS_DELIVERED, 
                'delivered_at' => date('Y-m-d H:i:s')
            ], ['id' => $id]); 
        } 
    }
    
    public function setInProccess($ids = [])
    {
        foreach ($ids as $id) {
            $this->resolver()->update($this->table(), [
                'status' => self::STATUS_PROCESS
            ], ['id' => $id]);
        }
    }
    
    public function reconciliation($ids = [])
    {
        $result = $this->select(['id'])->inProcess()->where(['id' => $ids])->toArray();

        if ($result) {
            self::setAsDelivered(array_column($result, 'id'));
            /*
            foreach (array_column($result, 'id') as $id) {
                $this->resolver()->update($this->table(), [
                    'status' => self::STATUS_DELIVERED
                ], ['id' => $id]);   
            } */
        }
    }
    
    public function addCommand($command = null)
    {
        return $this->insert([
            'phone' => self::SYSTEM_PHONE,
            'text' => $command,
            'type' => self::TYPE_SYSTEM
        ]);
    }
    
    public function addSms($params = [])
    {
        if ($params) {
            $cleared = preg_replace('/[() .+-]/', '', $params['phone']);
            if (preg_match("/^[0-9]/", $cleared) && strlen($cleared) == 11) { 
                return $this->insert($params);
            }
        }
        
        return false;
    }
    
    public function trashSystem()
    {
        $this->delete(['type' => self::TYPE_SYSTEM]);
    }
}
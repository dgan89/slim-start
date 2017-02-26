<?php

/**
 * 200 - view GET
 * 201 - create POST
 * 200 - update PUT
 * 204 - delete DELETE
*/

$app->group('/api', function () {
    /**
     * список на отправление
     */
    $this->get('/messages', function ($request, $response, $args) {
        $mapper = $this->spot->mapper('App\SmsApi');

        $data = $request->getQueryParam('system') ? $mapper->listSystem() : $mapper->listToDelivery();
        
        if ($data) {
           // $ids = implode(',', array_column($data, 'id'));
            $ids = array_column($data, 'id');
            $mapper->setInProccess($ids);
        }

        header('Content-Type: application/json; charset=windows-1251');
        header('charset: windows-1251');
        
        return $response->withJson($data, 200, JSON_UNESCAPED_UNICODE);
        //return json_encode($data, JSON_UNESCAPED_UNICODE);       
    });
    
    /**
     * запись лога
     */
    $this->post('/log', function ($request, $response, $args) { 
        $this->spot->mapper('App\Log')->insert($request->getParsedBody());     
    });
    
    /**
     * пометить как отправленные
     */
    $this->put('/delivered', function ($request, $response, $args) { 
        $mapper = $this->spot->mapper('App\SmsApi');
        //$ids = $request->getParsedBody()['ids'];
        $ids = explode(',', $request->getParsedBody()['ids']);

        if ($ids) {
            $mapper->setAsDelivered($ids);
        }  
    });
    
    /**
     * сверка на отправлении в базе и очереди в ардуино
     */
    $this->put('/reconciliation', function ($request, $response, $args) { 
        $mapper = $this->spot->mapper('App\SmsApi');
        $ids = explode(',', $request->getParsedBody()['ids']);

        if ($ids) {
            $mapper->reconciliation($ids);
        }  
    });
});

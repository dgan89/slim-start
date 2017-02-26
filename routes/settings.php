<?php

$app->group('/settings', function () { 
    $this->get('', function ($request, $response, $args) {
        $pagination = new razmik\helper\Paginator([
            'items' => $this->spot->mapper('App\Log')->itemList(),
            'pageSize' => 15,
        ]);
        
        $balance = $this->spot->mapper('App\Log')->currentBalance();
        
        $commands = new razmik\helper\Paginator([
            'items' => $this->spot->mapper('App\Sms')->commandList(),
            'pageSize' => 5,
            'queryParam' => 'p'
        ]);
        
        return $this->renderer->render($response, 'settings/index.phtml', [
            "title" => "Управление и логи", 
            'pagination' => $pagination,
            'balance' => $balance,
            'messages' => $this->flash->getMessages(),
            'commands' => $commands
        ]);
    });
    
    $this->post('', function ($request, $response, $args) {
        $command = $request->getParsedBodyParam('command');
        $result = false;
        
        switch ($command) {
            case 'reboot':
            case 'balance':
                $result = $this->spot->mapper('App\SmsApi')->addCommand($command);
            break;
            case 'trash':
                $this->spot->mapper('App\Log')->trash();
                $this->spot->mapper('App\SmsApi')->trashSystem();
                $result = true;
            break;
        }
        
        if ($result) {
            $this->flash->addMessage('success', 'Команда успешно выполнена');
        } else {
            $this->flash->addMessage('danger', 'Неизвестная команда');
        }

        return $response->withRedirect('/settings');
    });
})->add($container->get('csrf'));

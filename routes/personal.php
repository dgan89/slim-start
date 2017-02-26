<?php

$app->group('/personal', function () { 
    $this->get('/list', function ($request, $response, $args) {
        $pagination = new razmik\helper\Paginator([
            'items' => $this->spot->mapper('App\Sms')->itemList(),
            'pageSize' => 5,
        ]);

        return $this->renderer->render($response, 'personal/list.phtml', [
            "title" => "Мои сообщения", 
            'pagination' => $pagination,
            'messages' => $this->flash->getMessages()
        ]);
    });
    
    $this->post('/list', function ($request, $response, $args) {
        $result = $this->spot->mapper('App\Sms')->addSms($request->getParsedBodyParam('Sms'));

        if ($result) {
            $this->flash->addMessage('success', 'Сообщение добавлено в очередь');
        } else {
            $this->flash->addMessage('danger', 'Не удалось добавить сообщение');
        }
        
        return $response->withRedirect('list');
    });
})->add($container->get('csrf'));

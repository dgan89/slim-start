<?php

$app->group('/api', function () {
    $this->get('/sms', function ($request, $response, $args) { 
        $data = array('name' => 'Bob', 'age' => 40);
        return $response->withJson($data, 201);
      
    });
});

//$first = $this->spot->mapper("App\Sms")->itemList(); var_dump($first);die;
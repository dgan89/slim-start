<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
   // $this->logger->info("Slim-Skeleton '/' route");
   // $this->db->select()->from('sms')->execute()->fetch();
      // new Sms();          
  //$first = $this->spot->mapper("models\Sms");
    // Render index view
    $this->renderer->setAttributes(["title" => "Главная"]);
    return $this->renderer->render($response, 'index.phtml');
});

$app->get('/create', function ($request, $response, $args) {

    
    return $this->renderer->render($response, 'create.phtml', $args);
});

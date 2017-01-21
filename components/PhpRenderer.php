<?php
/**
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/slimphp/PHP-View
 * @copyright Copyright (c) 2011-2015 Josh Lockhart
 * @license   https://github.com/slimphp/PHP-View/blob/master/LICENSE.md (MIT License)
 */
namespace Components;

use \InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class PhpRenderer extends \Slim\Views\PhpRenderer
{
    public function renderPartial(ResponseInterface $response, $template, array $data = [])
    {
        $output = $this->fetch($template, $data);

        $response->getBody()->write($output);

        return $response;
    }
  
    public function render(ResponseInterface $response, $template, array $data = [])
    {
        $content = $this->fetch($template, $data);
        
        $this->addAttribute('content', $content);
        $output = $this->fetch('main.phtml', $this->getAttributes());

        $response->getBody()->write($output);

        return $response;
    }
}
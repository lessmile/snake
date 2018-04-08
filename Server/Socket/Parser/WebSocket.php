<?php
namespace App\Socket\Parser;


use EasySwoole\Core\Socket\AbstractInterface\ParserInterface;
use EasySwoole\Core\Socket\Common\CommandBean;

use App\Socket\Controller\WebSocket\Index;

class WebSocket implements ParserInterface
{

    public function decode($raw, $client)
    {
        // TODO: Implement decode() method.
        $CommandBean = new CommandBean();
        $commandLine = json_decode($raw, true);

        $control = isset($commandLine['class']) ? 'App\\Socket\\Controller\\WebSocket\\'. ucfirst($commandLine['class']) : '';
        $action = $commandLine['action'] ?? 'none';
        $data = $commandLine['data'] ?? null;

        $CommandBean->setControllerClass(class_exists($control) ? $control : Index::class);
        $CommandBean->setAction(class_exists($control) ? $action : 'controllerNotFound');
        $CommandBean->setArg('data', $data);

        return $CommandBean;
    }

    public function encode(string $raw, $client, $commandBean): ?string
    {
        // TODO: Implement encode() method.
        return $raw;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketController extends Controller implements MessageComponentInterface
{
    private $connections = [];
    
    function onOpen(ConnectionInterface $conn){
        $this->connections[$conn->resourceId] = $conn;
        echo "New connection: " . $conn->resourceId . "\n";
    }
    
    function onClose(ConnectionInterface $conn){
        unset($this->connections[$conn->resourceId]);
        echo "Lost connection: " . $conn->resourceId . "\n";
    }
    
    function onError(ConnectionInterface $conn, \Exception $e){
        unset($this->connections[$conn->resourceId]);
        $conn->close();
    }
    
    function onMessage(ConnectionInterface $conn, $msg)
    {
        echo "ID". $conn->resourceId . ": " . $msg . "\n";

        foreach($this->connections as &$client)
        {
            $client->send($msg);
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Http\Controllers\WebSocketController;

// https://medium.com/@mohyaddinalaoddin/web-sockets-made-easy-with-laravel-and-ratchet-149a0e63a74f
/*
composer require cboden/ratchet
php artisan make:command WebSocketServer --command=websocket:init
php artisan make:controller WebSocketController

php artiasn websocket:init
php artisan serve
*/

class WebSocketServer extends Command
{
    // The name and signature of the console command.
    protected $signature = 'websocket:init';

    // Description
    protected $description = 'Command description';

    // Create a new command instance.
    public function __construct()
    {
        parent::__construct();
    }

    // Command function
    public function handle()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketController()
                )
            ),
            8090
        );
        $this->info("WebSocket server is running!");
        $server->run();
    }
}

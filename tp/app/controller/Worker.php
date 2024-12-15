<?php

namespace app\controller;

use think\worker\Server;
use Workerman\Lib\Timer;


class Worker extends Server
{
    protected $socket = 'websocket://127.0.0.1:8282';

    public $con;

    public function onConnect($connection)
    {
        $connection->send(json_encode([
            "data"=>"ok"
        ]));
    }

    public function onMessage($connection,$data)
    {

        $this->con = $connection;
        echo $data;

    }

    public function onClose($connection)
    {

    }

    public function onError($connection,$code,$msg)
    {
        echo 'error' . $code  . $msg;

    }

    public function onWorkerStart($worker)
    {
        
        Timer::add(1,function()use($worker)
        {
            $worker->send(json_encode([
                "data"=>"nihao"
            ]));
            // $time_now = time();
            // foreach ($worker->connections as $connection) {
            //     if($time_now - $connection->lastMessageTime > 55)
            //     {
            //         $connection->close();
            //     }else{
            //         $connection->send("xtiao!");
            //     }
            // }
        });
    }
}

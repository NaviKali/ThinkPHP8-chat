<?php

namespace app\controller;

use think\worker\Server;
use Workerman\Lib\Timer;
use app\chat_server\model\Friend\FriendApply as ModelFriendApply;
use app\workerlogic;


class Worker extends Server
{
    protected $socket = 'websocket://127.0.0.1:8282';

    public $con;

    public function onConnect($connection)
    {
        $this->con = $connection;


    }

    public function onMessage($connection, $data)
    {
        $this->con = $connection;//*连接

        $data = json_decode($data);

        if (!isset($data->Timer)) {
            $connection->send(base64_encode(json_encode((new workerlogic($data))->run())));
        } else {
            $data = [
                "notice" => [
                    "friend_apply" => [
                        "data" => ModelFriendApply::where("")
                    ]
                ]
            ];
            Timer::add(1, function () use ($connection, $data) {
                $connection->send(base64_encode(json_encode($data)));
            });
        }

    }

    public function onClose($connection)
    {

    }

    public function onError($connection, $code, $msg)
    {
        echo 'error' . $code . $msg;

    }

    public function onWorkerStart($worker)
    {

    }
}

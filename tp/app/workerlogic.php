<?php

/**
 * 逻辑处理
 */

namespace app;

use app\Base;
use app\chat_server\attribute\socketType;
use ReflectionFunction;
use ReflectionMethod;

class workerlogic
{
    /**
     * 握手类型列表
     */
    public static array $typeList = [
        "handle",
        "get",
    ];
    /**
     * 握手类型
     * @var string
     */
    public string $type;
    /**
     * 握手执行Api
     * @var string
     */
    public string $api;
    /**
     * 携带参数
     * @var array defalut []
     */
    public array $params = [];
    /**
     * 命名空间
     * @var string
     */
    public string $namespace;
    /**
     * 是否允许启动Api 
     * @var bool default true
     */
    private bool $CanRun = true;
    /**
     * 处理好的函数名
     * @var string
     */
    public string $void;
    /**
     * 调用类
     * @var mixed
     */
    public mixed $Class;
    /**
     * 反射实例信息
     * @var array
     */
    public array $ReflectionInfo = [];

    public function __construct(object $_return)
    {
        $this->type = $_return->type;
        $this->api = base64_decode($_return->api);
        $this->params = (array) $_return->params;
        $this->HandleApi();
        $this->Class = (new $this->namespace);

    }
    /**
     * 运行Api
     * @return mixed
     */
    public function run(): mixed
    {
        //?是否允许启动Api
        if (!$this->CanRun)
            return [
                "code" => 110,
                "message" => (new Base())->ErrorMessage("执行Api被阻断!")
            ];

        $this->HandleReflection();

        //!反射抛出
        if ($this->ReflectionInfo != [])
            return $this->ReflectionInfo;

        $void = $this->void;
        $_return = $this->Class->$void($this->params);

        //*获取其他属性
        if (is_array($_return)) {
            $_return["type"] = $this->type;
            $_return["api"] = [
                "void" => $this->void,
                "namespace" => $this->namespace,
                "data" => $this->api,
            ];
        }

        return $_return;
    }
    /**
     * 处理反射
     * @return void
     */
    private function HandleReflection(): void
    {
        $func = new ReflectionMethod($this->namespace, $this->void);
        $data = (array) $func->getAttributes(socketType::class)[0]->newInstance();

        //?判断WebSocket传入的SocketType是否与Api定义属性一致
        if ($data["type"] != $this->type)
            $this->ReflectionInfo = (new Base)->socketError((new Base)->ErrorMessage("WebSocket发起的Api中的SocketType与服务端不一致!"));
        //?判断后端定义的SocketType是否存在于现有的SocketType列表中
        if (!$data["attribute_response"]["status"])
            $this->ReflectionInfo = (new Base)->socketError((new Base)->ErrorMessage($data["attribute_response"]["message"]));

    }

    /**
     * 处理Api路径逻辑
     * @throws \Exception
     * @return void
     */
    private function HandleApi(): void
    {
        $firstLength = strlen(explode(".", $this->api)[0]) + 1;
        $secondLength = strlen(explode("/", $this->api)[0]) + 1;
        try {
            if ($firstLength > $secondLength)
                $this->CanRun = false;

            $Shuff = explode("/", $this->api);
            $this->void = $Shuff[1];

            $Shuff[0] = str_replace(".", "\\", $Shuff[0]);
            $this->namespace = "\app\chat_server\controller\\" . $Shuff[0];

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }
}
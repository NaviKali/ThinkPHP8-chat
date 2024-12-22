<?php

namespace app\chat_server\attribute;

use app\workerlogic;
use app\Base;
use Attribute;

#[Attribute]
class socketType
{
    public function __construct(public string $type, public array $attribute_response = [])
    {
        if (!in_array($this->type, workerlogic::$typeList)) {
            $this->attribute_response = [
                "status"=>false,
                "message" => (new Base())->ErrorMessage("类型特性不存在!")
            ];
        }else
        {
            $this->attribute_response = [
                "status"=>true
            ];
        }
    }

}
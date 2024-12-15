<?php

namespace app;

use think\response\Json;


class Base extends BaseController
{
    /**
     * MsgOther
     * @var array
     */
    public array $MsgOther = [];
    /**
     * Get Author
     * @access public
     * @return string
     */
    public function getAuthor(): string
    {
        return apache_request_headers()['Author'] ?? "";
    }

    /**
     * Message
     * @access public
     * @param int $code
     * @param string $msg default:""
     * @param array|object $data default:[]
     * @param array $other default:[]
     * @return Json
     */
    public function Message(int $code, string $msg = "", array|object $data = [], array $other = []): Json
    {
        return json([
            "code" => $code,
            "msg" => $msg,
            "data" => $data,
            "other" => $this->MsgOther == [] ? $this->MsgOther : $other,
        ]);
    }
    /**
     * Error
     * @access public
     * @param string $msg
     * @return Json
     */
    public function Error(string $msg):Json
    {
         return $this->Message(500, $msg);
    }
    /**
     * Success
     * @access public
     * @param string $msg
     * @param array|object $data default:[]
     * @param array $other default:[]
     * @return Json
     */
    public function Success(string $msg, array|object $data = [], array $other = []): Json
    {
        return $this->Message(200, $msg, $data, $this->MsgOther == [] ? $this->MsgOther : $other);
    }



}
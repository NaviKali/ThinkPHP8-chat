<?php

namespace app\chat_server\controller\User;

use app\Base;
use app\Request;
use think\response\Json;
use app\chat_server\model\User\User as ModelUser;


class User extends Base
{
    /**
     * AccountLogin
     * @access public
     * @param Request $request
     * @api User.User/AccountLogin
     * @return Json
     */
    public function AccountLogin(Request $request):Json
    {
        $params = $request->param();
        $this->validate($params,[
            "user_account|Account"=>"require",
            "user_password|Password"=>"require",
        ]);


        $find = (new ModelUser())->where([
            "user_account"=>$params["user_account"],
            "user_password"=>$params["user_password"]
        ])->find();

        if(!$find)
            return $this->Error("AccountLogin Error!");

        return $this->Success("AccountLogin Success!");

    }
}
<?php

namespace app\chat_server\controller\User;

use app\Base;
use app\Request;
use think\captcha\facade\Captcha;
use think\Response;
use think\response\Json;
use app\chat_server\model\User\User as ModelUser;
use app\chat_server\model\Friend\Friend as ModelFriend;

class User extends Base
{
    /**
     * AccountLogin
     * @access public
     * @param Request $request
     * @api User.User/AccountLogin
     * @return Json
     */
    public function AccountLogin(Request $request): Json
    {
        $params = $request->param();
        $this->validate($params, [
            "user_account|Account" => "require",
            "user_password|Password" => "require",
        ]);


        $find = (new ModelUser())->where([
            "user_account" => $params["user_account"],
            "user_password" => $params["user_password"]
        ])->find();

        if (!$find)
            return $this->Error("AccountLogin Error!");

        return $this->Success("AccountLogin Success!",$find);
    }
    /**
     * Signin
     * @access public
     * @param Request $request
     * @api User.User/Signin
     * @return Json
     */
    public function Signin(Request $request): Json
    {
        $params = $request->param();
        $this->validate($params, [
            "user_account|Account" => "require",
            "user_password|Password" => "require",
        ]);

        $find = (new ModelUser())->where([
            "user_account" => $params["user_account"],
            "user_password" => $params["user_password"]
        ])->find();

        if ($find)
            return $this->Error("This Account is Have!");

        $user = ModelUser::create([
            (new ModelUser())->getPk() => $this->MakeGuid(),
            "user_account" => $params["user_account"],
            "user_password" => $params["user_password"],
        ]);

        //*Create Friend Data
        ModelFriend::create([
            (new ModelFriend())->getPk()=>$this->MakeGuid(),
            "user_guid"=>$user["user_guid"],
            "friend_user_id"=>"",
        ]);

        return $this->Success("Signin Success!");

    }
}
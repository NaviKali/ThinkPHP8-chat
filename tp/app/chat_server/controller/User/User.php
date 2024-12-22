<?php

namespace app\chat_server\controller\User;

use app\Base;
use app\chat_server\attribute\socketType;
use app\Request;
use Attribute;
use think\captcha\facade\Captcha;
use think\facade\Filesystem;
use think\Response;
use think\response\Json;
use app\chat_server\model\User\User as ModelUser;
use app\chat_server\model\Friend\Friend as ModelFriend;
use const app\chat_server\model\User\USER_STATUS_OFFLINE;
use const app\chat_server\model\User\USER_STATUS_ONLINE;

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

        $find->save([
            "user_status" => USER_STATUS_ONLINE,
        ]);

        return $this->Success("AccountLogin Success!", $find);
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
            (new ModelFriend())->getPk() => $this->MakeGuid(),
            "user_guid" => $user["user_guid"],
            "friend_user_id" => "",
        ]);

        return $this->Success("Signin Success!");

    }
    /**
     * 头像上传
     * @access public
     * @api User.User/UploadAvater
     * @param \app\Request $request
     * @return Json
     */
    public function UploadAvater(Request $request): Json
    {
        $file = $request->file("file");
        $path = Filesystem::disk("public")->putFile("UserAvater", $file);

        return $this->Success("上传成功!", [
            "path" => $path
        ]);

    }
    /**
     * 用户填写信息
     * @access public
     * @api User.User/WriteUserInfo
     * @param array $params must
     * @return array
     */
    #[socketType(SOCKET_TYPE_HANDLE)]
    public function WriteUserInfo(array $params): array
    {
        $find = ModelUser::where("user_guid", $params["author"])->find();
        if (!$find)
            return $this->socketSuccess([], $this->ErrorMessage("未找到对应用户!"));

        $find->save([
            "user_avater" => $params['user_avater'],
            "user_name" => $params['user_name'],
        ]);

        return $this->socketSuccess($find, [
            "content" => "填写成功!",
            "type" => "success",
        ]);
    }
    /**
     * 获取用户信息
     * @access public
     * @api User.User/getUserInfo
     * @param array $params must
     * @return array
     */
    #[socketType(SOCKET_TYPE_GET)]
    public function getUserInfo(array $params): array
    {
        $find = ModelUser::where("user_guid", $params["author"])->find();
        if (!$find)
            return $this->socketSuccess([], $this->ErrorMessage("未找到对应用户!"));
        return $this->socketSuccess($find, []);
    }
    /**
     * 获取其他用户列表
     * @access public
     * @api User.User/getOtherUserList
     * @param array $params
     * @return array
     */
    #[socketType(SOCKET_TYPE_GET)]
    public function getOtherUserList(array $params): array
    {
        $con = [
            ["user_guid", "<>", $params["author"]],
        ];
        $list = ModelUser::where($con)
            ->whereNotNull("user_name")
            ->field([
                "user_guid",
                "user_name",
                "user_avater",
                "create_datetime",
                "user_status",
            ])
            ->order("create_datetime", "desc")
            ->select()
            ->filter(function (object $v): object {
                $v["user_status_text"] = ModelUser::$UserStatus[$v["user_status"]];
                return $v;
            });

        return $this->socketSuccess($list, $this->SuccessMessgae("随即获取用户列表成功!"));

    }

    /**
     * 离开Chat
     * @param array $params
     * @return void
     */
    #[socketType(SOCKET_TYPE_HANDLE)]
    public function Out(array $params): array
    {
        $find = ModelUser::where("user_guid", $params["author"])->find();
        if (!$find)
            return $this->socketSuccess([], $this->ErrorMessage("未找到对应用户!"));

        $find->save([
            "user_status" => USER_STATUS_OFFLINE,
        ]);

        return $this->socketSuccess(message: $this->SuccessMessgae("再见了，希望我们还能再见面!"));

    }

}
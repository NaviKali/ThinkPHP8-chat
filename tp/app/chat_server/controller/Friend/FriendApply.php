<?php

namespace app\chat_server\controller\Friend;

use app\Base;
use app\chat_server\attribute\socketType;
use app\chat_server\model\Friend\FriendApply as ModelFriendApply;


class FriendApply extends Base
{

    /**
     * 发起好友申请
     * @access public
     * @api Friend.FriendApply/SendFriendApply
     * @param array $params must
     * @return array
     */
    #[socketType(SOCKET_TYPE_HANDLE)]
    public function SendFriendApply(array $params): array
    {
        $find = ModelFriendApply::where([
            "friend_apply_send_user_guid" => $params["author"],
            "friend_apply_over_user_guid" => $params["over_user_guid"]
        ])->find();

        if ($find)
            return $this->socketSuccess(message:$this->ErrorMessage("您已经对该用户发起过申请!"));

        ModelFriendApply::create([
            (new ModelFriendApply())->getPk() => $this->MakeGuid(),
            "friend_apply_send_user_guid" => $params["author"],
            "friend_apply_over_user_guid" => $params["over_user_guid"]
        ]);

        return $this->socketSuccess([], $this->SuccessMessgae("发起成功!"));
    }

}
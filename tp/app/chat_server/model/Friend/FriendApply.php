<?php

namespace app\chat_server\model\Friend;

use think\Model;
use think\model\concern\SoftDelete;

const FRIEND_APPLY_STATUS_WAIT = 0; //等待
const FRIEND_APPLY_STATUS_SUCCESS = 1; //成功
const FRIEND_APPLY_STATUS_ERROR = 2;//拒绝

class FriendApply extends Model
{
    use SoftDelete;
    protected $table = "friend_apply";
    protected $key = "friend_apply_id";
    protected $pk = "friend_apply_guid";

    protected $schema = [
        'friend_apply_id' => "int",
        'friend_apply_guid' => "varchar",
        'friend_apply_send_user_guid' => "varchar",
        'friend_apply_over_user_guid' => "varchar",
        'friend_apply_status' => "int",
        'create_datetime' => "datetime",
        'update_datetime' => "datetime",
        'delete_datetime' => "datetime",
    ];

    protected $json = [];
    protected $type = [];
    protected $autoWriteTimestamp = true;

    protected $createTime = "create_datetime";
    protected $updateTime = "update_datetime";
    protected $deleteTime = "delete_datetime";

    /**
     * 好友申请状态
     */
    public static array $FriendApplyStatus = [
        FRIEND_APPLY_STATUS_WAIT => "等待",
        FRIEND_APPLY_STATUS_SUCCESS => "成功",
        FRIEND_APPLY_STATUS_ERROR => "拒绝",
    ];

}
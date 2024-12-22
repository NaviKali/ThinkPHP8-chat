<?php

namespace app\chat_server\model\Friend;

use think\Model;
use think\model\concern\SoftDelete;


class Friend extends Model
{
    use SoftDelete;
    protected $table = "friend";
    protected $key = "friend_id";
    protected $pk = "friend_guid";

    protected $schema = [
        'friend_id'=>"int",
        'friend_guid'=>"varchar",
        'user_guid'=>"varchar",
        'friend_user_id',"varchar",
        'create_datetime'=>"datetime",
        'update_datetime'=>"datetime",
        'delete_datetime'=>"datetime",
    ];

    protected $json = [];
    protected $type = [];
    protected $autoWriteTimestamp = true;

    protected $createTime = "create_datetime";
    protected $updateTime = "update_datetime";
    protected $deleteTime = "delete_datetime";

}
<?php

namespace app\chat_server\model\User;

use think\Model;
use think\model\concern\SoftDelete;



class User extends Model
{
    use SoftDelete;
    protected $table = "user";
    protected $key = "user_id";
    protected $pk = "user_guid";

    protected $schema = [
        'user_id'=>"int",
        'user_guid'=>"varchar",
        'user_account'=>"varchar",
        'user_password'=>"varchar",
        'user_name'=>"varchar",
        'user_avater'=>"varchar",
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
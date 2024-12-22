<?php

namespace app\chat_server\model\User;

use think\Model;
use think\model\concern\SoftDelete;


const USER_STATUS_OFFLINE = 0;//离线
const USER_STATUS_ONLINE = 1;//在线
class User extends Model
{
    use SoftDelete;

    protected $table = "user";
    protected $key = "user_id";
    protected $pk = "user_guid";

    protected $schema = [
        'user_id' => "int",
        'user_guid' => "varchar",
        'user_account' => "varchar",
        'user_password' => "varchar",
        'user_name' => "varchar",
        'user_avater' => "varchar",
        "user_status"=>"int",
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
     * 用户状态
     * @access public
     * @static
     * @var array
     */
    public static array $UserStatus = [
        USER_STATUS_OFFLINE => "离线",
        USER_STATUS_ONLINE => "在线",
    ];
}
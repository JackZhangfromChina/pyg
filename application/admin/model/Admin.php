<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{

    protected $insert = ['password'=>'123456'];

    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    public function role(){
        return $this->belongsTo('Role')->bind('role_name');
    }

    public function getLastLoginTimeAttr($value){
        return date('Y-m-d H:i:s', $value);
    }

    public function setPasswordAttr($value)
    {
        return encrypt_password($value);
    }
}

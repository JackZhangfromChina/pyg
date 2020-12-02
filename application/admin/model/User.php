<?php

namespace app\admin\model;

use think\Model;

class User extends Model
{
    //
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
}

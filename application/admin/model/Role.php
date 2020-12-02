<?php

namespace app\admin\model;

use think\Model;

class Role extends Model
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    public function users(){
        return $this->hasMany('Admin');
    }

}

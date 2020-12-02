<?php

namespace app\admin\model;

use think\Model;

class Type extends Model
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    public function attrs()
    {
        return $this->hasMany('Attribute');
    }
    public function specs()
    {
        return $this->hasMany('Spec','type_id');
    }
}

<?php

namespace app\admin\model;

use think\Model;

class Attribute extends Model
{

    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    public function getAttrValuesAttr($value)
    {
        return $value ? explode(',', $value) : [];
    }
}

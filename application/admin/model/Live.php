<?php

namespace app\admin\model;

use think\Model;

class Live extends Model
{
    public function getStartTimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }
}

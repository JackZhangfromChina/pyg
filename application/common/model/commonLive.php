<?php

namespace app\common\model;

use think\Model;

class Live extends Model
{
    //设置获取器方法，对开始时间进行转化
    public function getStartTimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }
}

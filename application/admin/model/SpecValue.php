<?php

namespace app\admin\model;

use think\Model;

class SpecValue extends Model
{

    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    public function spec()
    {
        return $this->belongsTo('Spec')->bind('spec_name');
    }
}

<?php

namespace app\admin\model;

use think\Model;

class Cart extends Model
{
    use \traits\model\SoftDelete;

    protected $hidden = ['create_time', 'update_time', 'delete_time'];
}

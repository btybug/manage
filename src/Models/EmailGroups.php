<?php
/**
 * Created by PhpStorm.
 * User: Comp1
 * Date: 6/15/2017
 * Time: 2:16 PM
 */

namespace App\Modules\Manage\Models;


use Illuminate\Database\Eloquent\Model;

class EmailGroups extends Model
{
    protected $table = 'email_groups';

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at'];

    public function emails()
    {
        return $this->hasMany('App\Modules\Manage\Models\Emails','group_id');
    }
}
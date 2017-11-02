<?php

namespace Btybug\Manage\Models;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
    /**
     * @var string
     */
    protected $table = 'tags';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'page_id'];

    public static function boot()
    {
        self::creating(function ($model) {
            if (self::where('name', $model->name)->count()) {
                return false;
            }
        });
    }

    public function pages()
    {
        return $this->belongsToMany('Btybug\Manage\Models\FrontendPage', 'frontend_pages_tags', 'tags_id', 'frontend_page_id', 'id');
    }
}

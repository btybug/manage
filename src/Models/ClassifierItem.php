<?php
/**
 * Copyright (c) 2017.
 * *
 *  * Created by PhpStorm.
 *  * User: Edo
 *  * Date: 10/3/2016
 *  * Time: 10:44 PM
 *
 */

/**
 * Created by PhpStorm.
 * User: Comp2
 * Date: 11/9/2016
 * Time: 11:25 PM
 */

namespace Sahakavatar\Manage\Models;

use Illuminate\Database\Eloquent\Model;
use Sahakavatar\Cms\Helpers\Arrays;


class ClassifierItem extends Model {


    protected $table = 'classifier_items';

    protected $dates = ['created_at', 'updated_at'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $guarded = array('created_at');

    public function classifier(){

        return $this->belongsTo('Sahakavatar\Manage\Models\Classifier', 'classifier_id', 'id');
    }

    public function parent(){

        return $this->belongsTo('Sahakavatar\Manage\Models\ClassifierItem', 'parent_id');

    }

    public function child(){

        return $this->hasMany('Sahakavatar\Manage\Models\ClassifierItem', 'parent_id');
    }

    public function page() {
        return $this->belongsToMany('Sahakavatar\Manage\Models\FrontendPage', 'classify_items_pages', 'classifier_item_id', 'front_page_id');
    }

    public function getParentPageSlug() {
       return $this->parent()->first()
           ? $this->parent()->first()->page()->where('type', 'classify')->first()->url
           : $this->classifier()->first()->page()->where('type', 'classify')->first()->url;
    }


    public function rebuildChildren()
    {
        $children = $this->child;
        $this->rebuildChild($children);
    }

    public function rebuildChild($children){
        if(count($children)){
            foreach ($children as $child){
                $child->buildSlug();

                if($child->save()){
                    $new = self::find($child->id);
                    $page = $new->page()->where('type', 'classify')->first();
                    $page->url = $new->slug;
                    $page->save();
                    $this->rebuildChild($new->childs);
                }
            }
        }
    }

    public function getFrontParentPages() {
        $page = $this->parent()->first()
            ? $this->parent()->first()->page()->where('type', 'classify')->first()
            : $this->classifier()->first()->page()->where('type', 'classify')->first();

        if ($page) {
            return \DB::select('SELECT T2.id, T2.title,T2.url FROM (SELECT @r AS _id,(SELECT @r := parent_id FROM frontend_pages WHERE id = _id) AS parent_id, @l := @l + 1 AS lvl FROM (SELECT @r := ' . $page->id . ', @l := 0) vars, frontend_pages m WHERE @r <> 0) T1 JOIN frontend_pages T2 ON T1._id = T2.id ORDER BY T1.lvl DESC;');
        }

        return [];
    }

    public function buildSlug() {
        $text = $this->title;
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }
        $parentFrontendPageUrl = $this->getParentPageSlug();
        $text = $parentFrontendPageUrl . '/' . $text;
        $text = self::where('slug', $text)->count() ? $text . '-1' : $text;
        $this->slug = $text;

    }


    public function getAllMediaFolders($tax_id)
    {
        $data = self::select('*')->
        with('child')
            ->where('parent_id', 0)
            ->where('classifier_id', $tax_id)
            ->get();
        return $data->toArray();
    }

    /**
     * Add new Term and generates new media folder path :)
     *
     * @param $req
     * @return string
     */
    public function mkMediaFolder($req)
    {
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $req['title']);
        $slug = str_slug($slug, "-");

        if ($req['parent'] > 0) {
            $parent = $this->model->find($req['parent']);
            if ($parent) {
                $slug = $parent->slug . "/" . $slug;
            }
        }

        $term = self::create(
            [
                'classifier_id' => $req['taxonomy_id'],
                'title' => $req['title'],
                'parent_id' => $req['parent'],
                'slug' => $slug,
                'description' => $slug
            ]
        );

        return $term;
    }

    /**
     *
     * @param $req
     */
    public function updateMediaParent($req)
    {
        $id = $req['id'];
        $parent_id = (int)$req['parent'];

        $term = self::find($id);
        $src = $term->description;
        $description = $term->slug;

        $parent = self::find($parent_id);

        if ($parent) {
            $description = $parent->description . "/" . $description;
        }
        $term->parent_id = $parent_id;
        $term->description = $description;
        $term->save();
        //Change physical location of folder
        \File::move(Config('config.MEDIA_PATH').$src, Config('config.MEDIA_PATH').$description);
    }

    /**
     *
     */
    protected static function boot ()
    {
        parent::boot();

        static::deleting(function ($model) {
            // before delete() method call this
            $child = $model->child()->first();
            while($child) {
                $nextChild = $child->child()->first();
                $page = $child->page()->where('type', 'classify')->first();
                if($page) {
                    $page->urlManager()->where('type', 'classify')->first()->delete();
                    $page->delete();
                }
                $child->delete();
                $child = $nextChild;
            }
            $modelPage = $model->page()->where('type', 'classify')->first();
            if($modelPage) {
                $modelPage->urlManager()->where('type', 'classify')->first()->delete();
                $modelPage->delete();
            }

            $model->child()->delete();
        });
    }
}


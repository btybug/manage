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
 * Date: 11/8/2016
 * Time: 10:59 PM
 */

namespace Sahakavatar\Manage\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminPages
 * @package Sahakavatar\Backend\Models
 */
class Classifier extends Model
{

    public $incrementing = false;
    protected $primaryKey = 'id';
    /**
     * @var string
     */
    protected $table = 'classifiers';


    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];


    /**
     * @var array
     */
    protected $guarded = ['created_at'];

    /**
     * @param $taxonomy
     * @param $request
     * @return array
     */
    public static function syncrinizeTerms($taxonomy, $request, $edit = true)
    {
        $taxonomyData = $request->except('_token', 'terms');
        $terms = $request->get('terms');
        $newTerms = [];
        try {

            if (isset($terms['new'])) {
                foreach ($terms['new'] as $key => $new_term) {
                    $created = $taxonomy->classifierItem()->create($new_term);
                    $newTerms[$created->id] = $created->toArray();
                    foreach ($terms['new'] as $k => $v) {
                        if ($v['parent_id'] == $key) {
                            $terms['new'][$k]['parent_id'] = $created->id;
                        }
                    }

                    if (isset($terms['edit'])) {
                        foreach ($terms['edit'] as $k => $v) {
                            if ($v['parent_id'] == $key) {
                                $terms['edit'][$k]['parent_id'] = $created->id;
                            }
                        }
                    }
                }
            }


            if (isset($terms['edit']) && !empty($terms['edit'])) {
                $data = array_merge($newTerms, $terms['edit']);
                foreach ($terms['edit'] as $k => $v) {
                    $taxonomy->classifierItem()->where('id', $v['id'])->update($v);
                }

                if (!empty($data)) {
                    $deleted_data = [];
                    foreach ($data as $item) {
                        $deleted_data[] = $item['id'];
                    }

                    $taxonomy->classifierItem()->whereNotIn('id', $deleted_data)->delete();
                }
            } else {
                if (!isset($terms['new'])) {
                    $taxonomy->classifierItem()->delete();
                }
            }

            $taxonomy->update($taxonomyData);

            return ['error' => false, 'message' => 'Succesfully done'];
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }

    }

    /**
     * @param $terms
     * @param int $i
     */
    public static function RecursiveTerms($terms, $i = 0)
    {
        if (count($terms)) {
            $term = $terms[$i];
            //open li and put parent and item datas
            echo '<li data-parent="' . $term->parent_id . '" data-item="' . $term->id . '">';
            //open div set sortable class
            echo '<div class="drag-handle not-selected">';
            //set icon
            echo ' <i class="' . $term->icon . '" bb-icon="' . $term->id . '" aria-hidden="true"></i>';
            //print item title
            echo '<span class="title-area-' . $term->id . '">' . $term->title . '</span>';
            //open Edit button
            echo '<button type="button" class="edit-term btn btn-primary btn-sm pull-right " data-classifier="' . $term->classifier_id . '" data-id="' . $term->id . '" >';
            //set edit icon
            echo '<i class="fa fa-edit"></i>';
            //close Edit button
            echo '</button>';
            //open Delete button
            echo '<button type="button" data-href="/admin/manage/frontend/classify/delete-item" data-key="' . $term->id . '" data-type="Classify Item" class="delete-button btn btn-danger btn-sm  pull-right m-r-5">';
            //set delete icon
            echo '<i class="fa fa-trash"></i>';
            //close Delete button
            echo '</button>';
            //close sortable div
            echo '</div>';

            echo "<input type='hidden' name='terms[edit][" . $term->id . "][id]' value='" . @$term->id . "' />";
            echo "<input type='hidden' name='terms[edit][" . $term->id . "][title]' value='" . @$term->title . "' class='title_" . $term->id . "' />";
            echo "<input type='hidden' name='terms[edit][" . $term->id . "][description]' value='" . @$term->description . "' class='description_" . $term->id . "' />";
            echo "<input type='hidden' name='terms[edit][" . $term->id . "][icon]' value='" . @$term->icon . "' class='icon_" . $term->id . "' />";
            echo "<input type='hidden' name='terms[edit][" . $term->id . "][parent_id]' value='" . @$term->parent_id . "' class='icon_parent_" . $term->id . "' />";

            if (count($term->child)) {
                //open child ol
                echo "<ol>";
                self::RecursiveTerms($term->child, 0);
                //close child ol
                echo "</ol>";
            }

            //close li
            echo "</li>";

            $i = $i + 1;
            if ($i != count($terms)) {
                self::RecursiveTerms($terms, $i);
            }
        }
    }

    public static function RecursiveTermsFields($terms, $i = 0)
    {
        $result = '';
        if (count($terms)) {
            $term = $terms[$i];
            //open li and put parent and item datas
            $result .= '<li data-parent="' . $term->parent_id . '" data-item="' . $term->id . '">';
            //open div set sortable class


            $result .= '<div class="drag-handle not-selected">';
            //set icon

            $result .= ' <i class="' . $term->icon . '" bb-icon="' . $term->id . '" aria-hidden="true"> <input name="classify_child[]" type="checkbox"></i>';
            //print item title
            $result .= ' <span class="title-area-' . $term->id . '">' . $term->title . '</span>';
            //close sortable div
            $result .= '</div>';

            if (count($term->child)) {
                //open child ol
                $result .= '<button type="button" data-collapsible="button" class="btnplus"><i class="fa fa-minus" aria-hidden="true"></i></button>';

                $result .= "<ul class='list-unstyled p-l-15'>";
                $result .= self::RecursiveTermsFields($term->child, 0);
                //close child ol
                $result .= "</ul>";
            }
            //close li
            $result .= "</li>";
            $i++;
            if ($i != count($terms)) {
                $result .= self::RecursiveTermsFields($terms, $i);
            }
        }
        return $result;
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            // before delete() method call this
            $model->classifierItem()->delete();
        });
    }

    public function page()
    {
        return $this->belongsToMany('Sahakavatar\Manage\Models\FrontendPage', 'classify_items_pages', 'classifier_id', 'front_page_id');
    }

    public function buildSlug()
    {
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

        $this->slug = $this->validateSlug($text);
    }

    public function validateSlug($text)
    {
        return self::where('slug', $text)->count() ? $text . '-1' : $text;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classifierItem()
    {
        return $this->hasMany('Sahakavatar\Manage\Models\ClassifierItem', 'classifier_id', 'id');
    }

}
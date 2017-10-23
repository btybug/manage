<?php
/**
 * Created by PhpStorm.
 * User: Comp2
 * Date: 28-Feb-17
 * Time: 14:48
 */

namespace Sahakavatar\Manage\Models;

use Illuminate\Database\Eloquent\Model;


class ClassifierItemPage extends Model
{

    public $incrementing = false;
    protected $table = 'classify_items_pages';
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = ['front_page_id', 'classifier_id', 'classifier_item_id'];


    /**
     * @var array
     */
    protected $guarded = ['created_at'];

    public static function createClassifierPageRelations($classifiers, $pageId)
    {
        if ($classifiers && is_array($classifiers)) {
            $existingRelationsDeleted = self::deleteRelationsByPageId($pageId);
            if ($existingRelationsDeleted) {
                foreach ($classifiers as $classifierID => $classifier) {
                    $classifierPageItem = new self();
                    if (is_array($classifier)) {
                        foreach ($classifier as $classifierItem) {
                            $classifierPageItem = new self();
                            $dataToInsert = [
                                'front_page_id' => $pageId,
                                'classifier_id' => $classifierID,
                                'classifier_item_id' => $classifierItem
                            ];
                            $classifierPageItem->attributes = $dataToInsert;
                            $classifierPageItem->save();
                        }
                    } else {
                        $dataToInsert = [
                            'front_page_id' => $pageId,
                            'classifier_id' => $classifierID,
                            'classifier_item_id' => $classifier
                        ];
                        $classifierPageItem->attributes = $dataToInsert;
                        $classifierPageItem->save();
                    }
                }
            }
        }
    }

    public static function deleteRelationsByPageId($pageId)
    {
        $existingRelations = self::where('front_page_id', $pageId);
        if ($existingRelations->count()) {
            return $existingRelations->delete();
        }
        return true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function classifier()
    {
        return $this->belongsTo(Classifier::class, 'classifier_id', 'id');
    }

    public function getClassifierItemsByClassifier()
    {
        $result = [];
        if ($this->isMultiple()) {
            $classifiersRelations = self::where('classifier_id', $this->classifier_id)->get();
            foreach ($classifiersRelations as $classifiersRelation) {
                $result[] = $classifiersRelation->classifierItem()->pluck('title', 'id')->toArray();
            }
        }
        return $result;
    }

    public function isMultiple()
    {
        if ($this->classifier_id) {
            return $multiple = self::where('classifier_id', $this->classifier_id)->count() > 1 ? true : false;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function classifierItem()
    {
        return $this->belongsTo(ClassifierItem::class, 'classifier_item_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function frontPage()
    {
        return $this->belongsTo(FrontendPage::class, 'front_page_id', 'id');
    }


}
<?php

namespace wolverineo250kr\blog\models;

use Yii;
use wolverineo250kr\blog\models\Blog;
/**
 * 
 */
class BlogGroup extends \yii\db\ActiveRecord
{
    const ACTIVE   = 1;
    const DISABLED = 0;

    public static function tableName()
    {
        return '{{pevnev_blog_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
            [['is_active'], 'default', 'value' => self::DISABLED],
            [['is_active'], 'in', 'range' => [self::ACTIVE, self::DISABLED]],
        ];
    }

    public function getBlogToGroup()
    {
        return $this->hasMany(Blog::class, ['blog_group_id' => 'id'])
            ->andOnCondition([Blog::tableName().'.is_active' => Blog::ACTIVE])
                    ->andOnCondition(['<', 'timestamp_start', date('Y-m-d H:i:s')]);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => 'Рублика',
            'is_active' => 'Активность',
        ];
    }
}

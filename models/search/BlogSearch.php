<?php

namespace wolverineo250kr\modules\blog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use wolverineo250kr\modules\blog\models\Blog;

/**
 * Class BlogSearch
 */
class BlogSearch extends Blog
{
    const COUNT = 10;

    public $id;
    public $name;
    public $url;
        public $views;
    public $is_active;
    public $text_announcement;
    public $meta_title;
    public $meta_keywords;
    public $meta_description;
    public $timestamp;
    public $timestamp_update;
    public $timestamp_start;

    /**
     * Правила валидации
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'name',
                    'url',
                               'views',
                    'is_active',
                    'text_announcement',
                    'meta_title',
                    'meta_keywords',
                    'meta_description',
                    'timestamp',
                    'timestamp_update',
                    'timestamp_start',
                ],
                'safe'
            ],
        ];
    }

    /**
     * Сценарии
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Названия дополнительных полей
     * поиска документов
     * @return array
     */
    public function attributeLabels()
    {
        $label = parent::attributeLabels();

        return $label;
    }

    /**
     * Создает DataProvider на основе переданных данных
     * @param $params - параметры
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Blog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $this::COUNT,
            ],
            'sort' => array(
                'defaultOrder' => ['id' => SORT_ASC],
            ),
        ]);

        $this->load($params);

        // Если валидация не пройдена, то ничего не выводить
        if (!$this->validate()) {
            return $dataProvider;
        }

        // Фильтрация
        if (mb_strlen($this->id)) {
            $query->andWhere(['id' => $this->id,]);
        }
        if (mb_strlen($this->is_active)) {
            $query->andWhere(['is_active' => $this->is_active]);
        }
        if (mb_strlen($this->timestamp)) {
            $query->andFilterWhere(['like', 'timestamp', $this->timestamp]);
        }
                if (mb_strlen($this->views)) {
            $query->andFilterWhere(['like', 'views', $this->views]);
        }
        if (mb_strlen($this->timestamp_update)) {
            $query->andFilterWhere(['like', 'timestamp_update', $this->timestamp_update]);
        }
        if (mb_strlen($this->timestamp_start)) {
            $query->andFilterWhere(['like', 'timestamp_start', $this->timestamp_start]);
        }
        if (mb_strlen($this->url)) {
            $query->andFilterWhere(['like', 'url', $this->url]);
        }
        if (mb_strlen($this->name)) {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }
        if (mb_strlen($this->text_announcement)) {
            $query->andFilterWhere(['like', 'text_announcement', $this->text_announcement]);
        }

        return $dataProvider;
    }
}
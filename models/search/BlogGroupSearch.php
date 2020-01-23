<?php

namespace wolverineo250kr\modules\blog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use wolverineo250kr\modules\blog\models\BlogGroup;

/**
 * Class BlogSearch
 */
class BlogGroupSearch extends BlogGroup
{
    const COUNT = 10;

    public $id;
    public $name; 
    public $is_active; 

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
                    'is_active', 
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
        $query = BlogGroup::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $this::COUNT,
            ],
            'sort' => array(
                'defaultOrder' => ['id' => SORT_DESC],
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
        if (mb_strlen($this->name)) {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }

        return $dataProvider;
    }
}
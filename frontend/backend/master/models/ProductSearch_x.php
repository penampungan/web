<?php

namespace frontend\backend\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\backend\master\models\Product;

/**
 * ItemSearch represents the model behind the search form of `app\backend\master\models\Item`.
 */
class ProductSearch extends Product
{
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		return array_merge(parent::attributes(), ['productHargaTbl','productStockTbl']);
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STORE_ID', 'PRODUCT_ID', 'YEAR_AT', 'MONTH_AT'], 'required'],
            [['PRODUCT_SIZE', 'STOCK_LEVEL', 'CURRENT_STOCK', 'CURRENT_HPP', 'CURRENT_PRICE'], 'number'],
            [['INDUSTRY_ID', 'INDUSTRY_GRP_ID', 'STATUS', 'YEAR_AT', 'MONTH_AT'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['DCRP_DETIL'], 'string'],
            [['ACCESS_GROUP'], 'string', 'max' => 15],
            [['STORE_ID'], 'string', 'max' => 20],
            [['GROUP_ID', 'PRODUCT_QR', 'PRODUCT_NM', 'PRODUCT_HEADLINE'], 'string', 'max' => 100],
            [['PRODUCT_ID'], 'string', 'max' => 35],
            [['PRODUCT_WARNA', 'PRODUCT_SIZE_UNIT', 'UNIT_ID', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
            [['INDUSTRY_NM', 'INDUSTRY_GRP_NM', 'IMG_FILE', 'CREATE_UUID', 'UPDATE_UUID'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
				'pageSize' => 500,
			]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS,
            'STORE_ID' => $this->STORE_ID,
			'PRODUCT_ID' => $this->PRODUCT_ID,
            'PRODUCT_NM' => $this->PRODUCT_NM,
           
        ]);

        $query->orderBy(['ACCESS_GROUP'=>SORT_DESC,'PRODUCT_ID'=>SORT_DESC,'STORE_ID'=>SORT_DESC]);
        $query->groupBy([
            'PRODUCT_ID'
        ]);

        /* $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'ITEMGRP', $this->ITEMGRP])
            ->andFilterWhere(['like', 'PRODUCT_NM', $this->PRODUCT_NM]);
		*/
        return $dataProvider;
    }
}

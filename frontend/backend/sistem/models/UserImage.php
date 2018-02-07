<?php

namespace frontend\backend\sistem\models;

use Yii;

/**
 * This is the model class for table "user_image".
 *
 * @property string $ID
 * @property string $ACCESS_ID
 * @property string $ACCESS_IMAGE
 * @property string $CREATE_BY USER pembuat
 * @property string $CREATE_AT Tanggal dibuat
 * @property string $UPDATE_BY user Ubah
 * @property string $UPDATE_AT Tanggal diubah
 * @property int $STATUS 0=disable; 1=enable
 * @property string $DCRP_DETIL
 * @property int $YEAR_AT partisi unix
 * @property int $MONTH_AT partisi unix
 */
class UserImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ACCESS_ID', 'YEAR_AT', 'MONTH_AT'], 'required'],
            [['ACCESS_IMAGE', 'DCRP_DETIL'], 'string'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['STATUS', 'YEAR_AT', 'MONTH_AT'], 'integer'],
            [['ACCESS_ID', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ACCESS_ID' => 'Access  ID',
            'ACCESS_IMAGE' => 'Access  Image',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
            'STATUS' => 'Status',
            'DCRP_DETIL' => 'Dcrp  Detil',
            'YEAR_AT' => 'Year  At',
            'MONTH_AT' => 'Month  At',
        ];
    }
}

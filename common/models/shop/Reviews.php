<?php

namespace common\models\shop;

use common\models\shop\query\ReviewsQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $product_id
 * @property string|null $data
 * @property int|null $rating
 * @property int|null $is_visible
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Reviews extends ActiveRecord
{
    public const VISIBLE_YES = 1;
    public const VISIBLE_NO = 0;

    public const LIMIT_FOR_USER = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'rating', 'is_visible', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'data' => 'Data',
            'rating' => 'Rating',
            'is_visible' => 'Is Visible',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ReviewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewsQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
}

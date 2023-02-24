<?php

namespace frontend\models\review;

use common\models\shop\Reviews;
use common\models\User;
use yii\base\Model;

class RemoveReviewForm extends Model
{
    public $reviewId;

    /** @var User */
    protected $user;

    public function rules()
    {
        return [
            [['reviewId'], 'required'],
            [['reviewId'], 'integer'],
            [['reviewId'], 'exist', 'targetClass' => Reviews::class, 'targetAttribute' => ['reviewId' => 'id']]
        ];
    }

    public function remove()
    {
        if (!$this->validate()) {
            return false;
        }
        return (bool)Reviews::deleteAll(['id' => $this->reviewId]);
    }
}
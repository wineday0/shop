<?php

namespace frontend\models\review;

use common\models\shop\Reviews;
use common\models\User;
use yii\base\Model;

class ChangeReviewForm extends Model
{
    public $reviewId;
    public $text;
    public $rating;

    /** @var User */
    protected $user;

    public function rules()
    {
        return [
            [['reviewId', 'text', 'rating'], 'required'],
            [['reviewId'], 'integer'],
            [['rating'], 'integer', 'min' => 0, 'max' => 5],
            [['text'], 'string', 'length' => [4, 250]],
            [['text'], 'trim'],
            [['reviewId'], 'exist', 'targetClass' => Reviews::class, 'targetAttribute' => ['reviewId' => 'id']]
        ];
    }

    public function change()
    {
        if (!$this->validate()) {
            return false;
        }
        $review = Reviews::findOne(['id' => $this->reviewId]);
        if (empty($review)) {
            $this->addError('error', 'Error, review not found');
            return false;
        }
        $review->data = $this->text;
        $review->rating = $this->rating;
        if (!$review->update()) {
            $this->addError('error', 'Error, try again later');
            return false;
        }
        return true;
    }
}
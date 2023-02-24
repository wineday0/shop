<?php

namespace frontend\models\review;

use common\models\shop\Products;
use common\models\shop\Reviews;
use common\models\User;
use yii\base\Model;

class CreateReviewForm extends Model
{
    public $text;
    public $rating;
    public $productId;

    /** @var User */
    protected $user;

    public function rules()
    {
        return [
            [['text', 'rating', 'productId'], 'required'],
            [['text'], 'string', 'length' => [4, 250]],
            [['text'], 'trim'],
            [['productId'], 'integer'],
            [['rating'], 'integer', 'min' => 0, 'max' => 5],

        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        if (!$this->validateReviewsCounter()) {
            $this->addError('error', 'Review limit is ' . Reviews::LIMIT_FOR_USER);
            return false;
        }
        $review = new Reviews();
        $review->user_id = $this->getUser()->getId();
        $review->product_id = $this->getProduct()->id;
        $review->data = $this->text;
        $review->rating = $this->rating;
        $review->is_visible = Reviews::VISIBLE_YES;
        if (!$review->save()) {
            $this->addError('error', 'Error, try again later');
            return false;
        }
        return true;
    }

    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function getProduct()
    {
        return Products::findOne(['id' => $this->productId]);
    }

    public function validateReviewsCounter()
    {
        $count = Reviews::find()
            ->where(['user_id' => $this->getUser()->getId(), 'product_id' => $this->getProduct()->id])
            ->count('id');

        if (Reviews::LIMIT_FOR_USER <= $count) {
            return false;
        }
        return true;
    }
}
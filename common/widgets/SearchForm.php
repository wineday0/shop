<?php

namespace common\widgets;

use common\models\shop\Products;
use yii\base\Widget;
use yii\widgets\ActiveForm;

class SearchForm extends Widget
{
    public $model;
    public $activeForm;
    public $paramsForm;
    public $paramsField;

    public function init()
    {
        /** @var Products $model */

        parent::init();
        $this->activeForm = ActiveForm::class;
        $this->paramsForm = [
            'action' => ['shop/index'],
            'method' => 'get',
        ];

        $this->paramsField = [
            'type' => 'text',
            'attribute' => 'searchWord',
            'placeholder' => 'e.g. lorem ips'
        ];
    }

    public function run()
    {
        return $this->render(
            'searchFormView',
            [
                'activeForm' => $this->activeForm,
                'paramsForm' => $this->paramsForm,
                'paramsField' => $this->paramsField,
                'model' => $this->model
            ]
        );
    }
}

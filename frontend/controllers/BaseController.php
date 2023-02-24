<?php

namespace frontend\controllers;

use yii\base\Controller;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
    public const CODE_SUCCESS = 'success';
    public const CODE_ERROR = 'error';

    /**
     * @return string[]
     */
    public static function getSuccessResponse(): array
    {
        return ['code' => static::CODE_SUCCESS];
    }

    /**
     * @return string[]
     */
    public static function getErrorResponse(): array
    {
        return ['code' => static::CODE_ERROR];
    }
}

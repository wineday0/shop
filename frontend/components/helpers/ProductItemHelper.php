<?php

namespace frontend\components\helpers;

/**
 * Class ProductItemHelper
 */
class ProductItemHelper
{
    public const RATING_MAX = 5;
    public const RATING_STAR_ON = '★';
    public const RATING_STAR_OFF = '☆';

    /**
     * @param int $rating
     * @param int $max
     * @return string
     */
    public static function getRatingStars(int $rating, int $max = self::RATING_MAX): string
    {
        return str_repeat(self::RATING_STAR_ON, $rating)
            . str_repeat(self::RATING_STAR_OFF, $max - $rating);
    }
}

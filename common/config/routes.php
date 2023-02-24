<?php

return [
    '/shop' => 'shop/index',
    '/todo' => 'site/index',
    '/account' => 'site/account',
    '<controller:\w+>/index' => '<controller>/index',
    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
];
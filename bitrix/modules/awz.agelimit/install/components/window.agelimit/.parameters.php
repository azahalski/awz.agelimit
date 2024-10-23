<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
$arComponentParameters = [
    'GROUPS' => [
        'DEFAULT' => [
            'NAME' => Loc::getMessage('AWZ_WINDOW_AGELIMIT_PARAM_GROUP_DEF'),
            'SORT' => 210
        ]
    ]
];
$arComponentParameters['PARAMETERS']['INLINE_STYLES'] = array(
    'PARENT' => 'DEFAULT',
    'NAME' => Loc::getMessage('AWZ_WINDOW_AGELIMIT_PARAM_INLINE_STYLES'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);
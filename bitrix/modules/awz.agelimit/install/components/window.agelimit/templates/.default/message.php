<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;

Loc::loadLanguageFile(__DIR__.'/template.php');

/**
 * @var CBitrixComponentTemplate $this
 * @var string $componentPath
 * @var string $templateName
 * @var string $templateFolder
 * @var array $arParams
 * @var array $arResult
 */
?>
<?if($arParams['INLINE_STYLES']=='Y'){?>
    <style><?=file_get_contents(__DIR__.'/style.css')?></style>
<?}?>
<div class="awz_agelimit__message" id="awz_agelimit__message">
    <div class="awz_agelimit__message_wrap">
        <div class="awz_agelimit__icon">
            <svg fill="#ec4242" width="100px" height="100px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="M18,5h1V6a1,1,0,0,0,2,0V5h1a1,1,0,0,0,0-2H21V2a1,1,0,0,0-2,0V3H18a1,1,0,0,0,0,2ZM7,7V17a1,1,0,0,0,2,0V7A1,1,0,0,0,7,7ZM21.6,9a1,1,0,0,0-.78,1.18,9,9,0,1,1-7-7,1,1,0,1,0,.4-2A10.8,10.8,0,0,0,12,1,11,11,0,1,0,23,12a10.8,10.8,0,0,0-.22-2.2A1,1,0,0,0,21.6,9ZM11,9v1a3,3,0,0,0,.78,2A3,3,0,0,0,11,14v1a3,3,0,0,0,3,3h1a3,3,0,0,0,3-3V14a3,3,0,0,0-.78-2A3,3,0,0,0,18,10V9a3,3,0,0,0-3-3H14A3,3,0,0,0,11,9Zm5,6a1,1,0,0,1-1,1H14a1,1,0,0,1-1-1V14a1,1,0,0,1,1-1h1a1,1,0,0,1,1,1Zm0-6v1a1,1,0,0,1-1,1H14a1,1,0,0,1-1-1V9a1,1,0,0,1,1-1h1A1,1,0,0,1,16,9Z"/></svg>
        </div>
        <div class="awz_agelimit__title">
            <?=Loc::getMessage('AWZ_AGELIMIT_COMPONENT_TITLE')?>
        </div>
        <div class="awz_agelimit__desc">
            <?=Loc::getMessage('AWZ_AGELIMIT_COMPONENT_DESC')?>
        </div>
        <div class="awz_agelimit__btn">
            <a href="#" class="awz_agelimit__save"><?=Loc::getMessage('AWZ_AGELIMIT_COMPONENT_BTN')?></a>
        </div>
        <div class="awz_agelimit__close_wrap">
            <a href="#" class="awz_agelimit__close"><?=Loc::getMessage('AWZ_AGELIMIT_COMPONENT_CLOSE')?></a>
        </div>
    </div>
</div>
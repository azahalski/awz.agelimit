<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;

/**
 * @var CBitrixComponentTemplate $this
 * @var string $componentPath
 * @var string $templateName
 * @var string $templateFolder
 * @var array $arParams
 * @var array $arResult
 */
CJSCore::init(['ajax']);
$this->setFrameMode(true);
$randStr = 'awz_agelimit_'.$this->randString();
$cmpId = 'awz_agelimit_'.$this->randString();
/** @var \Bitrix\Main\Page\FrameBuffered $frame */
$frame = $this->createFrame($randStr, false)->begin();
if($arResult['SHOW_MESSAGE']==='Y'){
    include('message.php');
    $options = [
        'signedParameters'=>$this->getComponent()->getSignedParameters()
    ];
    ?>
    <script type="text/javascript">
        <?if($arParams['INLINE_STYLES']=='Y'){?><?=file_get_contents(__DIR__.'/script.js')?><?}?>
        var <?=$cmpId?> = new window.AwzAgeLimitComponent(<?=CUtil::PHPToJSObject($options)?>);
    </script>
<?}
$frame->beginStub();
?><div id="<?=$randStr?>"></div><?php
$frame->end();
?>
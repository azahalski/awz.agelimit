<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\UI\Extension;
use Awz\Agelimit\Access\AccessController;
use Bitrix\Main\SiteTable;

Loc::loadMessages(__FILE__);
global $APPLICATION;
$module_id = "awz.agelimit";
if(!Loader::includeModule($module_id)) return;
Extension::load('ui.sidepanel-content');
$request = Application::getInstance()->getContext()->getRequest();
$APPLICATION->SetTitle(Loc::getMessage('AWZ_AGELIMIT_OPT_TITLE'));

if($request->get('IFRAME_TYPE')==='SIDE_SLIDER'){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
    require_once('lib/access/include/moduleright.php');
    CMain::finalActions();
    die();
}
if(!AccessController::isViewSettings())
    $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$siteRes = SiteTable::getList(['select'=>['LID','NAME'],'filter'=>['ACTIVE'=>'Y']])->fetchAll();
$context = Application::getInstance()->getContext();
$request = $context->getRequest();

if ($request->getRequestMethod()==='POST' && AccessController::isEditSettings() && $request->get('Update'))
{
    $shows = $request->get('SHOW');
    if(!is_array($shows)) $shows = [];
    foreach($siteRes as $arSite){
        if(!isset($shows[$arSite['LID']]) || !$shows[$arSite['LID']]) {
            $shows[$arSite['LID']] = 'N';
        }
        Option::set($module_id, 'SHOW', $shows[$arSite['LID']], $arSite['LID']);
    }
}

$aTabs = array();

$aTabs[] = array(
    "DIV" => "edit1",
    "TAB" => Loc::getMessage('AWZ_AGELIMIT_OPT_SECT1'),
    "ICON" => "vote_settings",
    "TITLE" => Loc::getMessage('AWZ_AGELIMIT_OPT_SECT1')
);

$saveUrl = $APPLICATION->GetCurPage(false).'?mid='.htmlspecialcharsbx($module_id).'&lang='.LANGUAGE_ID.'&mid_menu=1';
$tabControl = new CAdminTabControl("tabControl", $aTabs);
$tabControl->Begin();
?>
    <style>.adm-workarea option:checked {background-color: rgb(206, 206, 206);}</style>
    <form method="POST" action="<?=$saveUrl?>" id="FORMACTION">

        <?
        $tabControl->BeginNextTab();
        Extension::load("ui.alerts");
        ?>
        <tr>
            <td colspan="2">
                <div class="ui-alert ui-alert-primary">
                    <span class="ui-alert-message">
                        <?=Loc::getMessage('AWZ_AGELIMIT_OPT_SHOW_DESC')?>.
                    </span>
                </div>
                <textarea style="background: #ffffff;padding:10px;width:100%;height:100px;">
<?='<?'?>$APPLICATION->IncludeComponent("awz:window.agelimit",".default",
    Array(
        "COMPONENT_TEMPLATE" => ".default"
    ),
    null, array("HIDE_ICONS"=>"Y")
);<?='?>'?>
                </textarea>
            </td>
        </tr>
        <?
        foreach($siteRes as $arSite){
        ?>
        <tr class="heading">
            <td colspan="2">
                <b><?=$arSite['NAME']?></b>
            </td>
        </tr>
        <tr>
            <td style="width:50%;"><?=Loc::getMessage('AWZ_AGELIMIT_OPT_SHOW')?></td>
            <td>
                <?$val = Option::get($module_id, "SHOW", "N",$arSite['LID']);?>
                <input type="checkbox" value="Y" name="SHOW[<?=$arSite['LID']?>]" <?if ($val=="Y") echo "checked";?>>
            </td>
        </tr>
        <?
        }
        ?>

        <?
        $tabControl->Buttons();
        ?>
        <input <?if (!AccessController::isEditSettings()) echo "disabled" ?> type="submit" class="adm-btn-green" name="Update" value="<?=Loc::getMessage('AWZ_AGELIMIT_OPT_L_BTN_SAVE')?>" />
        <input type="hidden" name="Update" value="Y" />
        <?if(AccessController::isViewRight()){?>
            <button class="adm-header-btn adm-security-btn" onclick="BX.SidePanel.Instance.open('<?=$saveUrl?>');return false;">
                <?=Loc::getMessage('AWZ_AGELIMIT_OPT_SECT2')?>
            </button>
        <?}?>
        <?$tabControl->End();?>
    </form>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
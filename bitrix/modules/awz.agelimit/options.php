<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\SiteTable;

Loc::loadMessages(__FILE__);
global $APPLICATION;
$module_id = "awz.agelimit";
$MODULE_RIGHT = $APPLICATION->GetGroupRight($module_id);
$zr = "";
if (! ($MODULE_RIGHT >= "R"))
    $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));

$APPLICATION->SetTitle(Loc::getMessage('AWZ_AGELIMIT_OPT_TITLE'));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

Loader::includeModule($module_id);

$siteRes = SiteTable::getList(['select'=>['LID','NAME'],'filter'=>['ACTIVE'=>'Y']])->fetchAll();
$context = Application::getInstance()->getContext();
$request = $context->getRequest();

if ($request->isPost() && $MODULE_RIGHT == "W" && strlen($request->get("Update")) > 0 && check_bitrix_sessid())
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

$aTabs[] = array(
    "DIV" => "edit3",
    "TAB" => Loc::getMessage('AWZ_AGELIMIT_OPT_SECT2'),
    "ICON" => "vote_settings",
    "TITLE" => Loc::getMessage('AWZ_AGELIMIT_OPT_SECT2')
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);
$tabControl->Begin();
?>
    <style>.adm-workarea option:checked {background-color: rgb(206, 206, 206);}</style>
    <form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($module_id)?>&lang=<?=LANGUAGE_ID?>&mid_menu=1" id="FORMACTION">

        <?
        $tabControl->BeginNextTab();
        \Bitrix\Main\UI\Extension::load("ui.alerts");
        ?>
        <tr>
            <td colspan="2">
                <div class="ui-alert ui-alert-primary">
                    <span class="ui-alert-message">
                        <?=Loc::getMessage('AWZ_AGELIMIT_OPT_SHOW_DESC')?>.
                    </span>
                </div>
                <pre style="background: #ffffff;padding:10px;">
<?='<?'?>$APPLICATION->IncludeComponent("awz:window.agelimit",".default",
    Array(
        "COMPONENT_TEMPLATE" => ".default"
    ),
    null, array("HIDE_ICONS"=>"Y")
);<?='?>'?>
                </pre>
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
        $tabControl->BeginNextTab();
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");
        ?>

        <?
        $tabControl->Buttons();
        ?>
        <input <?if ($MODULE_RIGHT<"W") echo "disabled" ?> type="submit" class="adm-btn-green" name="Update" value="<?=Loc::getMessage('AWZ_AGELIMIT_OPT_L_BTN_SAVE')?>" />
        <input type="hidden" name="Update" value="Y" />
        <?$tabControl->End();?>
    </form>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
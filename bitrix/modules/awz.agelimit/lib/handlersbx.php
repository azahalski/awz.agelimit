<?php
namespace Awz\AgeLimit;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;

class HandlersBx {

    public static function OnEndBufferContent(&$content){
        $context = Application::getInstance()->getContext();
        if($context->getRequest()->isAdminSection()) return;
        if(
            Option::get("awz.agelimit", 'SHOW', 'N', SITE_ID)==="Y" &&
            mb_strpos(mb_substr($content,-20), '</body>')!==false
        ){
            global $APPLICATION;
            ob_start();
            $APPLICATION->IncludeComponent("awz:window.agelimit",".default",
                Array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "INLINE_STYLES"=>"Y"
                ),
                null, array("HIDE_ICONS"=>"Y")
            );
            $html = ob_get_contents();
            $html = preg_replace("/(\s+)/is"," ", $html);
            $html = str_replace(["\n","\t","\r"],"", $html);
            $html = preg_replace("/\s?([:,;{}><=])\s?/is","$1", $html);

            ob_end_clean();
            $content = str_replace('</body>',$html."\n".'</body>',$content);
        }
    }

}
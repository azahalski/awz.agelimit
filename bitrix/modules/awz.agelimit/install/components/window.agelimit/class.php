<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}

use Bitrix\Main\Context;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Errorable;

Loc::loadMessages(__FILE__);

class AwzWindowAgeLimitComponent extends CBitrixComponent implements Controllerable, Errorable
{
    const SETT_KEY = 'awz_agelimit';
    const SETT_KEY_OK_VALUE = 'Y';

    /** @var ErrorCollection */
    protected $errorCollection;

    /** @var  Bitrix\Main\HttpRequest */
    protected $request;

    /** @var Context $context */
    protected $context;

    public $arParams = array();
    public $arResult = array();

    public $userGroups = array();

    /**
     * Ajax actions
     *
     * @return array[][]
     */
    public function configureActions(): array
    {
        return [
            'allow' => [
                'prefilters' => [
                    new ActionFilter\HttpMethod([
                        ActionFilter\HttpMethod::METHOD_POST
                    ]),
                    new ActionFilter\Csrf()
                ],
            ],
        ];
    }

    /**
     * Signed params
     *
     * @return string[]
     */
    protected function listKeysSignedParameters(): array
    {
        return ["COMPONENT_TEMPLATE","INLINE_STYLES"];
    }

    /**
     * Create default component params
     *
     * @param array $arParams параметры
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $this->errorCollection = new ErrorCollection();
        $this->arParams = &$arParams;

        return $arParams;
    }

    /**
     * Show public component
     *
     * @throws LoaderException
     */
    public function executeComponent(): void
    {
        if(!$this->isRequiredModule())
        {
            return;
        }
        $this->arResult['SHOW_MESSAGE'] = 'Y';
        $context = Application::getInstance()->getContext();
        $session = Application::getInstance()->getSession();
        if($session->get(self::SETT_KEY) == self::SETT_KEY_OK_VALUE){
            $this->arResult['SHOW_MESSAGE'] = 'N';
        }elseif($context->getRequest()->getCookie(self::SETT_KEY) == self::SETT_KEY_OK_VALUE){
            $this->arResult['SHOW_MESSAGE'] = 'N';
        }
        $this->includeComponentTemplate('');
    }

    public function allowAction()
    {
        if(!$this->isRequiredModule()) return '';

        $context = Application::getInstance()->getContext();
        $session = Application::getInstance()->getSession();
        $session->set(self::SETT_KEY, self::SETT_KEY_OK_VALUE);
        $cookie = new Cookie(self::SETT_KEY, self::SETT_KEY_OK_VALUE);
        $cookie->setPath('/');
        $context->getResponse()->addCookie($cookie);
        return "";
    }

    /**
     * Добавление ошибки
     *
     * @param string|Error $message
     * @param int|string $code
     */
    public function addError($message, $code=0)
    {
        if($message instanceof Error){
            $this->errorCollection[] = $message;
        }elseif(is_string($message)){
            $this->errorCollection[] = new Error($message, $code);
        }
    }

    /**
     * Массив ошибок
     *
     * Getting array of errors.
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errorCollection->toArray();
    }

    /**
     * Getting once error with the necessary code.
     *
     * @param string|int $code Code of error.
     * @return Error|null
     */
    public function getErrorByCode($code): ?Error
    {
        return $this->errorCollection->getErrorByCode($code);
    }

    /**
     * проверка установки обязательных модулей
     *
     * @return bool
     * @throws LoaderException
     */
    public function isRequiredModule(): bool
    {
        return true;
    }

}

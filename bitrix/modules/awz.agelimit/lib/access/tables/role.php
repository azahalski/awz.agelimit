<?php
namespace Awz\Agelimit\Access\Tables;

use Bitrix\Main\Access\Role\AccessRoleTable;

class RoleTable extends AccessRoleTable
{
    public static function getTableName()
    {
        return 'awz_agelimit_role';
    }
}
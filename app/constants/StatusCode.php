<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/19
 * Time: 2:46 PM
 */

namespace app\constants;


class StatusCode
{
    /**
     * 状态 正常
     * @Message("normal")
     */
    const STATUS_NORMAL = 1;

    /**
     * 状态 禁用
     * @Message("disable")
     */
    const STATUS_DISABLE = 2;

    /**
     * 是否隐藏 是
     */
    const HIDDEN_YES = 1;

    /**
     * 是否隐藏 否
     */
    const HIDDEN_NO = 2;

    /**
     * 菜单类型 导航菜单
     */
    const MENU_TYPE_NAVIGATION = 1;
    /**
     * 菜单类型 按钮
     */
    const MENU_TYPE_BUTTON = 2;
    /**
     * 菜单类型 外链
     */
    const MENU_TYPE_LINK = 3;
    /**
     * 权限全局白名单 是
     */
    const MENU_ADOPT_YES = 1;
    /**
     * 权限全局白名单 否
     */
    const MENU_ADOPT_NO = 2;
}
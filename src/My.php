<?php

/**
 * @brief _template_, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Jean-Christian Denis, Franck Paul and contributors
 *
 * @copyright Jean-Christian Denis, Franck Paul
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\_template_;

use Dotclear\App;
use Dotclear\Module\MyPlugin;

/**
 * Plugin definitions
 */
class My extends MyPlugin
{
    /**
     * Check permission depending on given context
     *
     * @param      int   $context  The context
     *
     * @return     null|bool  null if not relevant, true if allowed, else false
     */
    protected static function checkCustomContext(int $context): ?bool
    {
        return match ($context) {
            // Limit backend to content admin and pages user
            self::BACKEND, self::MANAGE, self::MENU, self::WIDGETS => App::task()->checkContext('BACKEND')
                && App::blog()->isDefined()
                && App::auth()->check(App::auth()->makePermissions([
                    App::auth()::PERMISSION_CONTENT_ADMIN,
                    App::auth()::PERMISSION_ADMIN,
                ]), App::blog()->id()),

            default => null,
        };
    }

    /**
     * Makes an url including optionnal parameters.
     *
     * @param      array   $params  The parameters
     *
     * @deprecated since 2.27, use My::manageUrl($param)
     */
    public static function makeUrl(array $params = []): string
    {
        return static::manageUrl($params);
    }
}

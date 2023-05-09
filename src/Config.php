<?php
/**
 * @brief _template_, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\_template_;

use dcCore;
use dcPage;
use dcNsProcess;
use Exception;

class Config extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = My::checkContext(My::CONFIG);

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        try {
            // ToDo

            dcPage::addSuccessNotice(
                __('Configuration has been successfully updated.')
            );
            dcCore::app()->adminurl->redirect('admin.plugins', [
                'module' => My::id(),
                'conf'   => '1',
                'redir'  => dcCore::app()->admin->__get('list')->getRedir(),
            ]);
        } catch (Exception $e) {
            dcCore::app()->error->add($e->getMessage());
        }

        return true;
    }

    public static function render(): void
    {
        if (!static::$init) {
            return;
        }

        // Form
    }
}

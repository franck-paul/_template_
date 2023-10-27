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

use Dotclear\App;
use Dotclear\Core\Backend\Notices;
use Dotclear\Core\Process;
use Exception;

class Config extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::CONFIG));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        try {
            // ToDo

            Notices::addSuccessNotice(
                __('Configuration has been successfully updated.')
            );
            My::redirect([
                'module' => My::id(),
                'conf'   => '1',
                'redir'  => App::backend()->__get('list')->getRedir(),
            ]);
        } catch (Exception $exception) {
            App::error()->add($exception->getMessage());
        }

        return true;
    }

    public static function render(): void
    {
        if (!self::status()) {
            return;
        }

        // Form
    }
}

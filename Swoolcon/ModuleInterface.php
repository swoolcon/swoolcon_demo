<?php
/**
 * Phanbook : Delightfully simple forum software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
namespace Swoolcon;

use Phalcon\Events\EventsAwareInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * \Phanbook\Common\ModuleInterface
 *
 * @package Phanbook\Common
 */
interface ModuleInterface extends ModuleDefinitionInterface, EventsAwareInterface
{
    /**
     * Initialize the module.
     */
    public function initialize();

    /**
     * Gets controllers/tasks namespace.
     *
     * @return string
     */
    public function getHandlersNamespace();
}

<?php

namespace TMS\Theme\Savel;

use \TMS\Theme\Base;
/**
 * Class ACFController
 *
 * @package TMS\Theme\Savel
 */
class ACFController extends Base\ACFController implements Base\Interfaces\Controller {

    /**
     * Get ACF base dir
     *
     * @return string
     */
    protected function get_base_dir() : string {
        return __DIR__ . '/ACF';
    }

}

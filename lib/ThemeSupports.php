<?php

namespace TMS\Theme\Savel;

use Closure;
use TMS\Theme\Base\Interfaces\Controller;

/**
 * Class ThemeSupports
 *
 * @package TMS\Theme\Sara_Hilden
 */
class ThemeSupports implements Controller {

    /**
     * Initialize the class' variables and add methods
     * to the correct action hooks.
     *
     * @return void
     */
    public function hooks(): void {
        // Allow custom url links to be added in menus
        \add_filter(
            'tms/theme/remove_custom_links',
            '__return_false'
        );
    }
}

<?php

namespace TMS\Theme\Savel;

use TMS\Theme\Base\Interfaces\PostType;

/**
 * Class PostTypeController
 *
 * @package TMS\Theme\Savel
 */
class PostTypeController extends \TMS\Theme\Base\PostTypeController implements PostType {

    /**
     * Get namespace for CPT instances
     *
     * @return string
     */
    protected function get_namespace(): string {
        return __NAMESPACE__;
    }

    /**
     * Get custom post type files
     *
     * @return array
     */
    protected function get_post_type_files(): array {
        return array_diff( scandir( __DIR__ . '/PostType' ), [ '.', '..' ] );
    }
}

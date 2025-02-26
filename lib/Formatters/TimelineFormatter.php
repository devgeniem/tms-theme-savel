<?php

namespace TMS\Theme\Savel\Formatters;

/**
 * Class TimelineFormatter
 *
 * @package TMS\Theme\Base\Formatters
 */
class TimelineFormatter implements \TMS\Theme\Base\Interfaces\Formatter {

    /**
     * Define formatter name
     */
    const NAME = 'Timeline';

    /**
     * Hooks
     */
    public function hooks(): void {
        \add_filter(
            'tms/acf/layout/timeline/data',
            [ $this, 'format' ],
            30
        );
    }

    /**
     * Format layout data
     *
     * @param array $layout ACF Layout data.
     *
     * @return array
     */
    public function format( array $layout ): array {

        $layout['repeater'] = array_map( function ( $item ) {
            $author              = \get_field( 'author_name', $item['image']['ID'] );
            $item['author_name'] = $author ?? '';

            return $item;
        }, $layout['repeater'] );

        return $layout;
    }
}

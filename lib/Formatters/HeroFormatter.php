<?php

namespace TMS\Theme\Savel\Formatters;

/**
 * Class HeroFormatter
 *
 * @package TMS\Theme\Base\Formatters
 */
class HeroFormatter implements \TMS\Theme\Base\Interfaces\Formatter {

    /**
     * Define formatter name
     */
    const NAME = 'Hero';

    /**
     * Hooks
     */
    public function hooks(): void {
        \add_filter(
            'tms/acf/layout/hero/data',
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
        $info_one = [
            'title' => $layout['info_one']['info_one_title'] ?? false,
            'text'  => $layout['info_one']['info_one_text'] ?? false,
            'image' => $layout['info_one']['info_one_image'] ?? false,
            'link'  => $layout['info_one']['info_one_button'] ?? false,
        ];

        if ( ! empty( $info_one['title'] ) || ! empty( $info_one['text'] ) ) {
            $layout['columns'][] = $info_one;
        }

        $info_two = [
            'title' => $layout['info_two']['info_two_title'] ?? false,
            'text'  => $layout['info_two']['info_two_text'] ?? false,
            'image' => $layout['info_two']['info_two_image'] ?? false,
            'link'  => $layout['info_two']['info_two_button'] ?? false,
        ];

        if ( ! empty( $info_two['title'] ) || ! empty( $info_two['text'] ) ) {
            $layout['columns'][] = $info_two;
        }

        $info_three = [
            'title' => $layout['info_three']['info_three_title'] ?? false,
            'text'  => $layout['info_three']['info_three_text'] ?? false,
            'image' => $layout['info_three']['info_three_image'] ?? false,
            'link'  => $layout['info_three']['info_three_button'] ?? false,
        ];

        if ( ! empty( $info_three['title'] ) || ! empty( $info_three['text'] ) ) {
            $layout['columns'][] = $info_three;
        }

        $info_four = [
            'title' => $layout['info_four']['info_four_title'] ?? false,
            'text'  => $layout['info_four']['info_four_text'] ?? false,
            'image' => $layout['info_four']['info_four_image'] ?? false,
            'link'  => $layout['info_four']['info_four_button'] ?? false,
        ];

        if ( ! empty( $info_four['title'] ) || ! empty( $info_four['text'] ) ) {
            $layout['columns'][] = $info_four;
        }

        return $layout;
    }
}

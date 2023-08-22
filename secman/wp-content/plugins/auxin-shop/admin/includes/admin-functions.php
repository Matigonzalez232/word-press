<?php
/**
 * Pair Value Repeater Controller Html
 *
 * @return string            The HTML Output
 */

function auxin_pair_value_repeater_html(){

    $html  = '<div class="aux-pair-repeater-controller aux-controller-wrapper">';
        $html .= '<div class="aux-control aux-controller-container aux-pair-repeater-container" data-type="container" data-selector="body">';
            $html .= '<div class="aux-control" data-type="repeater" data-name="meta-fields" data-default="">';
                $html .= '<a class="aux-add button-primary">' . __( 'Add', 'auxin-shop' ) . '</a>';
                $html .= '<div class="aux-repeater-item aux-control" data-selector="inherit">';
                    $html .= '<span>' . __( 'Meta Name', 'auxin-shop' ) . '</span><div class="aux-control" data-type="text" data-name="meta-key" data-default=""><input type="text"/></div>';
                    $html .= '<span>' . __( 'Meta Value', 'auxin-shop' ) . '</span><div class="aux-control" data-type="text" data-name="meta-value" data-default=""><input type="text"/></div>';
                    $html .= '<span class="description"><a class="aux-delete ">' . __( 'Delete', 'auxin-shop' ) . '</a></span>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
    $html .= '</div>';

    return $html;

}

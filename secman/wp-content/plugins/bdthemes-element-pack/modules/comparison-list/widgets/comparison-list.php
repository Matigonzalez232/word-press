<?php

namespace ElementPack\Modules\ComparisonList\Widgets;

use Elementor\Repeater;
use ElementPack\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Text_Stroke;
use ElementPack\Utils;
use ElementPack\Element_Pack_Loader;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Comparison_List extends Module_Base {

    public function get_name() {
        return 'bdt-comparison-list';
    }

    public function get_title() {
        return BDTEP . esc_html__('Comparison List', 'bdthemes-element-pack');
    }

    public function get_icon() {
        return 'bdt-wi-comparison-list';
    }

    public function get_categories() {
        return ['element-pack'];
    }

    public function get_keywords() {
        return ['comparison-list', 'tabs', 'toggle'];
    }

    public function get_style_depends() {
        if ($this->ep_is_edit_mode()) {
            return ['ep-styles'];
        } else {
            return ['ep-comparison-list'];
        }
    }

    public function get_custom_help_url() {
        return 'https://youtu.be/DP3XNV1FEk0';
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_comparison_list',
            [
                'label' => esc_html__('Comparison List', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list_title',
            [
                'label'       => esc_html__('Titles', 'bdthemes-element-pack'),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Feature list|Free|Ultimate', 'bdthemes-element-pack'),
                'description' => esc_html__('Separate with "|" pipe character. First one is for title and rest of them are for feature list.', 'bdthemes-element-pack'),
                'default'     => esc_html__('Feature list|Free|Ultimate', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'active_item',
            [
                'label' => esc_html__('Active Item', 'bdthemes-element-pack'),
                'type'  => Controls_Manager::NUMBER,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label'       => esc_html__('Title', 'bdthemes-element-pack'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your title', 'bdthemes-element-pack'),
                'default'     => esc_html__('Title', 'bdthemes-element-pack'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label'       => esc_html__('Description', 'textdomain'),
                'type'        => Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__('Type your description here', 'textdomain'),
            ]
        );

        $repeater->add_control(
            'feature_ability',
            [
                'label'       => esc_html__('Feature Ability', 'bdthemes-element-pack'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('0|1|0', 'bdthemes-element-pack'),
                'label_block' => true,
                'description' => esc_html__('Separate with "|" pipe character. 0 for disable and 1 for enable.', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list',
            [
                'label'   => esc_html__('Comparison List', 'bdthemes-element-pack'),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'title'       => esc_html__('Feature Title #1', 'bdthemes-element-pack'),
                        'description' => esc_html__('#1 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                    labore et dolore magna aliqua.', 'bdthemes-element-pack'),
                        'feature_ability' => '0|1',
                    ],
                    [
                        'title'       => esc_html__('Feature Title #2', 'bdthemes-element-pack'),
                        'description' => esc_html__('#2 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                    labore et dolore magna aliqua.', 'bdthemes-element-pack'),
                        'feature_ability' => '0|1',
                    ],
                    [
                        'title'       => esc_html__('Feature Title #3', 'bdthemes-element-pack'),
                        'description' => esc_html__('#3 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                    labore et dolore magna aliqua.', 'bdthemes-element-pack'),
                        'feature_ability' => '1|1',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        //Style
        $this->start_controls_section(
            'section_style_comparison_list_header',
            [
                'label' => esc_html__('Header Feature', 'bdthemes-element-pack'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'comparison_list_header_tabs'
        );

        $this->start_controls_tab(
            'style_feature_title_tab',
            [
                'label' => esc_html__('Feature Title', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'header_feature_title_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-list-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_feature_title_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-list-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'header_feature_title_typography',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-list-title',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_regular_title_tab',
            [
                'label' => esc_html__('Regular Title', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'header_regular_title_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_regular_title_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'header_regular_title_typography',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-title',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_active_title_tab',
            [
                'label' => esc_html__('Active Title', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'header_active_title_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-heightlight-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_active_title_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-heightlight-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'header_active_title_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-heightlight-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'header_active_title_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-heightlight-title',
            ]
        );

        $this->add_responsive_control(
            'header_active_title_radius',
            [
                'label'      => esc_html__('Border Radius', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-heightlight-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_active_title_padding',
            [
                'label'     => esc_html__('Padding', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-heightlight-title' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'header_active_title_shadow',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-heightlight-title',
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'header_active_title_typography',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-head-heightlight-title',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_comparison_list_item',
            [
                'label' => esc_html__('List item', 'bdthemes-element-pack'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'comparison_list_item_tabs'
        );

        $this->start_controls_tab(
            'style_list_normal_item_tab',
            [
                'label' => esc_html__('Normal', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list_item_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'comparison_list_item_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-item',
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_radius',
            [
                'label'      => esc_html__('Border Radius', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_padding',
            [
                'label'     => esc_html__('Padding', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-item' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'comparison_list_item_shadow',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-item',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_list_item_active_tab',
            [
                'label' => esc_html__('Active', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list_item_active_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-comparison-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'comparison_list_item_active_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-comparison-item',
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_active_radius',
            [
                'label'      => esc_html__('Border Radius', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-comparison-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_active_padding',
            [
                'label'     => esc_html__('Padding', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-comparison-item' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'comparison_list_item_active_shadow',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-comparison-item',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_comparison_list_item_title',
            [
                'label' => esc_html__('List item Title', 'bdthemes-element-pack'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'list_item_title_tabs'
        );

        $this->start_controls_tab(
            'list_item_title_normal_tab',
            [
                'label' => esc_html__('Normal', 'textdomain'),
            ]
        );

        $this->add_control(
            'item_item_title_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-item-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_item_title_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-item-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'comparison_list_item_plus_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-item-title::before, {{WRAPPER}} .bdt-comparison-item-title::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_plus_icon_width',
            [
                'label' => esc_html__('Icon Size', 'bdthemes-element-pack'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-item-title::before, {{WRAPPER}} .bdt-comparison-item-title::after' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'item_item_title_typography',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-comparison-item-title',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_item_title_active_tab',
            [
                'label' => esc_html__('Active', 'textdomain'),
            ]
        );

        $this->add_control(
            'item_item_active_title_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-comparison-item-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'comparison_list_item_plus_icon_active_color',
            [
                'label'     => esc_html__('Icon Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-open .bdt-comparison-item-title::before, {{WRAPPER}} .bdt-open .bdt-comparison-item-title::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // check icon style

        $this->start_controls_section(
            'section_style_comparison_list_item_check_icon',
            [
                'label' => esc_html__('Feature Ability (Check)', 'bdthemes-element-pack'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'comparison_list_item_check_icon_tabs'
        );

        $this->start_controls_tab(
            'style_list_normal_item_check_icon_tab',
            [
                'label' => esc_html__('Normal', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list_item_check_icon_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-check-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'comparison_list_item_check_icon_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-check-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'comparison_list_item_check_icon_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-check-icon',
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_check_icon_radius',
            [
                'label'      => esc_html__('Border Radius', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-check-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_check_icon_padding',
            [
                'label'     => esc_html__('Padding', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-check-icon' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'comparison_list_item_check_icon_shadow',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-check-icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_list_hover_item_check_icon_tab',
            [
                'label' => esc_html__('Hover', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list_item_check_icon_hover_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-check-icon:hover' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'comparison_list_item_check_icon_hover_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-check-icon:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'comparison_list_item_check_icon_hover_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-check-icon:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_list_item_check_icon_active_tab',
            [
                'label' => esc_html__('Active', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list_item_check_icon_active_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-check-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'comparison_list_item_check_icon_active_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-check-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'comparison_list_item_check_icon_active_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-check-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'comparison_list_item_check_icon_active_shadow',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-check-icon',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // close icon style

        $this->start_controls_section(
            'section_style_comparison_list_item_close_icon',
            [
                'label' => esc_html__('Feature Ability (Close)', 'bdthemes-element-pack'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'comparison_list_item_close_icon_tabs'
        );

        $this->start_controls_tab(
            'style_list_normal_item_close_icon_tab',
            [
                'label' => esc_html__('Normal', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list_item_close_icon_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-close-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'comparison_list_item_close_icon_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-close-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'comparison_list_item_close_icon_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-close-icon',
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_close_icon_radius',
            [
                'label'      => esc_html__('Border Radius', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-close-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_close_icon_padding',
            [
                'label'     => esc_html__('Padding', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-close-icon' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'comparison_list_item_close_icon_shadow',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-close-icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_list_hover_item_close_icon_tab',
            [
                'label' => esc_html__('Hover', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list_item_close_icon_hover_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-close-icon:hover' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'comparison_list_item_close_icon_hover_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-close-icon:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'comparison_list_item_close_icon_hover_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-close-icon:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_list_item_close_icon_active_tab',
            [
                'label' => esc_html__('Active', 'bdthemes-element-pack'),
            ]
        );

        $this->add_control(
            'comparison_list_item_close_icon_active_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-close-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'comparison_list_item_close_icon_active_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-close-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'comparison_list_item_close_icon_active_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-close-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'comparison_list_item_close_icon_active_shadow',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-open .bdt-close-icon',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Content icon style

        $this->start_controls_section(
            'section_style_comparison_list_item_content',
            [
                'label' => esc_html__('Content', 'bdthemes-element-pack'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'comparison_list_item_content_color',
            [
                'label'     => esc_html__('Color', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-accordion-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'comparison_list_item_content_typography',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-accordion-content',
            ]
        );



        $this->add_control(
            'comparison_list_item_content_background',
            [
                'label'     => esc_html__('Background', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-accordion-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'comparison_list_item_content_border',
                'label'       => esc_html__('Border', 'bdthemes-element-pack'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-accordion-content',
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_content_radius',
            [
                'label'      => esc_html__('Border Radius', 'bdthemes-element-pack'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'comparison_list_item_content_padding',
            [
                'label'     => esc_html__('Padding', 'bdthemes-element-pack'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-accordion-content' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'comparison_list_item_content_shadow',
                'selector' => '{{WRAPPER}} .bdt-comparison-list-wrap .bdt-accordion-content',
            ]
        );

        $this->end_controls_section();

    }


    protected function render_check_icon() {
?>
        <div class="bdt-comparison-icon-item">
            <div class="bdt-comparison-icon bdt-check-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                </svg>
            </div>
        </div>
    <?php
    }

    protected function render_close_icon() {
    ?>
        <div class="bdt-comparison-icon-item">
            <div class="bdt-comparison-icon bdt-close-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </div>
        </div>
    <?php
    }
    protected function render_blank_icon() {
    ?>
        <div class="bdt-comparison-icon-item">

        </div>
    <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $comparison_list_title = explode('|', $settings['comparison_list_title']);

    ?>
        <div class="bdt-ep-comparison-list-container">
            <div class="bdt-comparison-list-wrap bdt-overflow-auto">

                <div class="bdt-compatison-header bdt-flex-middle bdt-flex">
                    <div class="bdt-list-title">
                        <?php
                        if (isset($comparison_list_title[0])) {
                            printf('%s', esc_html($comparison_list_title[0]));
                        }
                        ?>
                    </div>
                    <div class="bdt-head-title-wrap <?php printf('bdt-child-width-1-%s', esc_attr(count($comparison_list_title) - 1)); ?> bdt-text-center" bdt-grid>
                        <?php
                        $key = -1;
                        foreach ($comparison_list_title as $title) :
                            $key++;
                            if ($title === $comparison_list_title[0]) continue;
                            if (empty($settings['active_item'])) {
                                $settings['active_item'] = count($comparison_list_title) - 1;
                            }
                            $class = ($key == $settings['active_item'] ? 'bdt-comparison-head-heightlight-title' : '');
                            printf('<div class="bdt-head-title-item"><div class="bdt-comparison-head-title %s">%s</div></div>', esc_attr($class), esc_html($title));
                        endforeach;
                        ?>
                    </div>
                </div>

                <ul class="bdt-comparison-item-list-wrap" bdt-accordion="collapsible: true">
                    <?php foreach ($settings['comparison_list'] as $items) : ?>
                        <li>
                            <div class="bdt-comparison-item bdt-accordion-title bdt-flex-middle bdt-flex">
                                <div class="bdt-comparison-item-title">
                                    <span><?php printf('%s', $items['title']); ?></span>
                                </div>
                                <div class="bdt-comparison-icon-wrap <?php printf('bdt-child-width-1-%s', esc_attr(count($comparison_list_title) - 1)); ?> bdt-text-center" bdt-grid>
                                    <?php
                                    $feature_ability = explode('|', $items['feature_ability']);
                                    foreach ($feature_ability as $ability) :
                                        switch ($ability) {
                                            case '0':
                                                $this->render_close_icon();
                                                break;
                                            case '1':
                                                $this->render_check_icon();
                                                break;
                                            default:
                                                $this->render_blank_icon();
                                                break;
                                        }
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                            <div class="bdt-accordion-content">
                                <?php
                                printf('%s', wp_kses_post($items['description']));
                                ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>
<?php
    }
}

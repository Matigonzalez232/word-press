<?php
/**
 * General Hooks
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

function auxin_define_news_theme_options( $fields_sections_list ){

    $options  = $fields_sections_list['fields'  ];
    $sections = $fields_sections_list['sections'];

    /* ---------------------------------------------------------------------------------------------------
        News Section
    --------------------------------------------------------------------------------------------------- */

    // News section ==================================================================

     // Sub section - News Single Page -------------------------------
    $sections[] = array(
        'id'          => 'news-section',
        'parent'      => '', // section parent's id
        'title'       => __( 'News', 'auxin-news' ),
        'description' => __( 'News Setting', 'auxin-news' ),
        'icon'        => 'axicon-doc'
    );

    $sections[] = array(
        'id'          => 'news-section-single',
        'parent'      => 'news-section', // section parent's id
        'title'       => __( 'Single News', 'auxin-news' ),
        'description'  => __( 'Preview a Single News Page', 'auxin-news'),
        'preview_link' => auxin_get_last_post_permalink( array( 'post_type' => 'news' ) )
    );

    $options[] = array(
        'title'       => __( 'Single News Sidebar Position', 'auxin-news' ),
        'description' => __( 'Specifies position of sidebar on single news.', 'auxin-news' ),
        'id'          => 'news_single_sidebar_position',
        'section'     => 'news-section-single',
        'dependency'  => array(),
        'post_js'     => '$(".single-news main.aux-single").alterClass( "*-sidebar", to );',
        'choices'     => array(
            'no-sidebar' => array(
                'label'     => __( 'No Sidebar', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'     => __( 'Right Sidebar', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar'  => array(
                'label'     => __( 'Left Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'     => __( 'Left Left Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'     => __( 'Right Right Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'     => __( 'Left Right Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'     => __( 'Right Left Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'default'   => 'right-sidebar',
        'type'      => 'radio-image'
    );

    $options[] =    array(
        'title'       => __( 'Single News Sidebar Style', 'auxin-news' ),
        'description' => 'Specifies style of sidebar on single news.',
        'id'          => 'news_single_sidebar_decoration',
        'section'     => 'news-section-single',
        'dependency'  => array(
            array(
                 'id'      => 'news_single_sidebar_position',
                 'value'   => 'no-sidebar',
                 'operator'=> '!='
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-news main.aux-single").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple'  => array(
                'label'  => __( 'Simple' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    $options[] =    array(
        'title'       => __( 'Single News Featured Color', 'auxin-news' ),
        'description' => __( 'Specifies featured color for news posts.', 'auxin-news' ),
        'id'          => 'news_single_featured_color',
        'section'     => 'news-section-single',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'type'        => 'color',
        'selectors'   => ' ',
        'default'     => '#1bb0ce'
    );

    $options[] =    array(
        'title'       => __( 'Title Alignment', 'auxin-news' ),
        'description' => __( 'Specifies title alignment on single news.', 'auxin-news' ),
        'id'          => 'news_single_title_alignment',
        'section'     => 'news-section-single',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-news main .entry-main > .entry-header, .single-news main .entry-main > .entry-info").alterClass( "aux-text-align-*", "aux-text-align-" + to );',
        'choices'     => array(
            'default' => array(
                'label'     => __( 'Left', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-text-align-left',
            ),
            'center' => array(
                'label'     => __( 'Center', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-text-align-center'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'default'
    );

    $options[] = array(
        'title'       => __( 'Content Style', 'auxin-news' ),
        'description' => __( 'You can reduce the width of text lines and increase the readability of context in single post of news (does not affect the width of media).', 'auxin-news' ),
        'id'          => 'news_single_content_style',
        'section'     => 'news-section-single',
        'dependency'  => array(),
        'choices'     => array(
            'simple'  => array(
                'label'  => __( 'Default' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/content-normal.svg'
            ),
            'narrow' => array(
                'label'  => __( 'Narrow Content' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/content-less.svg'
            )
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".single-news .aux-primary .hentry").toggleClass( "aux-narrow-context", "narrow" == to );',
        'default'   => 'simple',
        'type'      => 'radio-image'
    );

    $options[] = array(
        'title'       => __( 'Display News Info', 'auxin-news' ),
        'description' => __( 'Enable it to display news date, categories and author name in news page .', 'auxin-news' ),
        'id'          => 'show_news_single_meta_info',
        'section'     => 'news-section-single',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'default'     => '1',
        'type'        => 'switch'
    );


    $options[] = array(
        'title'         => __( 'Display news date', 'auxin-news' ),
        'description'   => __( 'Enable it to show the news date.', 'auxin-news' ),
        'id'            => 'aux_news_meta_date_show',
        'section'       => 'news-section-single',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_news_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Display news author', 'auxin-news' ),
        'description'   => __( 'Enable it to show the news author.', 'auxin-news' ),
        'id'            => 'aux_news_meta_author_show',
        'section'       => 'news-section-single',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_news_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Author avatar size', 'auxin-news' ),
        'id'            => 'aux_news_avatar_size',
        'section'       => 'news-section-single',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'type'          => 'text',
        'dependency'  => array(
            array(
                 'id'      => 'show_news_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                 'id'      => 'aux_news_meta_author_show',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '100'
    );

    $options[] = array(
        'title'         => __( 'Display news caregories', 'auxin-news' ),
        'description'   => __( 'Enable it to show the news categories.', 'auxin-news' ),
        'id'            => 'aux_news_meta_categories_show',
        'section'       => 'news-section-single',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_news_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Tags Section', 'auxin-news' ),
        'description' => __( 'Enable it to display tags section under the news content.', 'auxin-news' ),
        'id'          => 'show_news_single_tags_section',
        'section'     => 'news-section-single',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Display Share Button', THEME_DOMAIN ),
        'description' => __( 'Enable it to display %s share button%s on single news.', THEME_DOMAIN ),
        'id'          => 'show_news_post_share_button',
        'section'     => 'news-section-single',
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-news .entry-info .aux-post-share").auxToggle( to );',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_news_single_tags_section',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Share Button Type', THEME_DOMAIN ),
        'description' => __( 'Enable it to display text instead of icon on single news.', THEME_DOMAIN ),
        'id'          => 'news_post_share_button_type',
        'section'     => 'news-section-single',
        'transport'   => 'postMessage',
        'type'        => 'select',
        'choices'       => array(
            'icon'  => __( 'Icon', THEME_DOMAIN ),
            'text'  => __( 'Text', THEME_DOMAIN )
        ),
        'dependency'  => array(
            array(
                'id'      => 'show_news_single_tags_section',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'show_news_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_news_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        ),
        'default'     => 'icon',
    );

    $options[] = array(
        'title'       => __( 'Share Button Icon', THEME_DOMAIN ),
        'id'          => 'news_post_share_button_icon',
        'section'     => 'news-section-single',
        'transport'   => 'refresh',
        'type'        => 'icon',
        'default'     => 'auxicon-share',
        'dependency'  => array(
            array(
                'id'      => 'show_news_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'news_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_news_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Icon Color', THEME_DOMAIN ),
        'description'   => __( 'Share icon color',THEME_DOMAIN ),
        'id'            => 'news_post_share_button_icon_color',
        'section'       => 'news-section-single',
        'transport'     => 'postMessage',
        'type'          => 'color',
        'selectors'     => '.single-news .aux-post-share span::before',
        'placeholder'   => 'color:{{VALUE}}',
        'default'       => '',
        'dependency'  => array(
            array(
                'id'      => 'show_news_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'news_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_news_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Icon Hover Color', THEME_DOMAIN ),
        'description'   => __( 'Share icon hover color',THEME_DOMAIN ),
        'id'            => 'news_post_share_button_icon_hover_color',
        'section'       => 'news-section-single',
        'transport'     => 'postMessage',
        'type'          => 'color',
        'selectors'     => '.single-news .aux-post-share span:hover::before',
        'placeholder'   => 'color:{{VALUE}}',
        'default'       => '',
        'dependency'  => array(
            array(
                'id'      => 'show_news_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'news_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_news_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Share Button Icon Size', THEME_DOMAIN ),
        'id'          => 'news_post_share_button_icon_size',
        'section'     => 'news-section-single',
        'transport'   => 'postMessage',
        'type'        => 'text',
        'dependency'  => array(
            array(
                'id'      => 'show_news_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'news_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_news_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        ),
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'news_post_share_button_icon_size' ) );
            }
            if( ! is_numeric( $value ) ){
                $value = 10;
            }
            return $value ? ".single-news .aux-post-share span::before { font-size:{$value}px; }" : '';
        }
    );

    $options[] = array(
        'title'          => __( 'Share Button Margin', THEME_DOMAIN ),
        'id'             => 'news_post_share_button_margin',
        'section'        => 'news-section-single',
        'type'           => 'responsive_dimensions',
        'selectors'      => '.single-news .aux-post-share',
        'transport'      => 'postMessage',
        'placeholder'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
        'dependency'  => array(
            array(
                'id'      => 'show_news_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'news_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_news_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        ),
    );

    if ( class_exists( 'wp_ulike' ) ) {
        $options[] = array(
            'title'       => __( 'Display Like Button', THEME_DOMAIN ),
            'description' => sprintf(__( 'Enable it to display %s like button%s on single news. Please note WP Ulike plugin needs to be activaited in order to use this option.', THEME_DOMAIN ), '<strong>', '</strong>'),
            'id'          => 'show_news_post_like_button',
            'section'     => 'news-section-single',
            'transport'   => 'postMessage',
            'post_js'     => '$(".single-news .entry-info .wpulike").auxToggle( to );',
            'type'        => 'switch',
            'dependency'  => array(
                array(
                    'id'      => 'show_news_single_meta_info',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'show_news_single_tags_section',
                    'value'   => array('1'),
                    'operator'=> ''
                )
            ),
            'default'     => '1'
        );

        $options[] = array(
            'title'       => __( 'Like Button Type', THEME_DOMAIN ),
            'description' => __( 'Enable it to display text instead of icon on single news.', THEME_DOMAIN ),
            'id'          => 'news_post_like_button_type',
            'section'     => 'news-section-single',
            'transport'   => 'postMessage',
            'type'        => 'select',
            'choices'     => array(
                'icon'  => __( 'Icon', THEME_DOMAIN ),
                'text'  => __( 'Text', THEME_DOMAIN)
            ),
            'dependency'  => array(
                array(
                    'id'      => 'show_news_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
               )
            ),
            'default'     => 'icon',
        );

        $options[] = array(
            'title'       => __( 'Like Icon', THEME_DOMAIN ),
            'id'          => 'news_post_like_icon',
            'section'     => 'news-section-single',
            'transport'   => 'refresh',
            'type'        => 'icon',
            'default'     => 'auxicon-heart-2',
            'dependency'  => array(
                array(
                    'id'      => 'show_news_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'news_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            )
        );

        $options[] = array(
            'title'         => __( 'Icon Liked Color', THEME_DOMAIN ),
            'description'   => __( 'Like icon color',THEME_DOMAIN ),
            'id'            => 'news_post_like_icon_color',
            'section'       => 'news-section-single',
            'transport'     => 'postMessage',
            'type'          => 'color',
            'selectors'     => '.single-news .wp_ulike_btn:before, .single-news .wp_ulike_is_liked .wp_ulike_btn:before',
            'placeholder'   => 'color:{{VALUE}}',
            'default'       => '',
            'dependency'  => array(
                array(
                    'id'      => 'show_news_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'news_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            )
        );

        $options[] = array(
            'title'         => __( 'Icon Not Liked Color', THEME_DOMAIN ),
            'description'   => __( 'Like icon color',THEME_DOMAIN ),
            'id'            => 'news_post_not_like_icon_color',
            'section'       => 'news-section-single',
            'transport'     => 'postMessage',
            'type'          => 'color',
            'selectors'     => '.single-news .wp_ulike_is_unliked .wp_ulike_btn:before',
            'placeholder'   => 'color:{{VALUE}}',
            'default'       => '',
            'dependency'  => array(
                array(
                    'id'      => 'show_news_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'news_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            )
        );

        $options[] = array(
            'title'         => __( 'Icon Hover Color', THEME_DOMAIN ),
            'description'   => __( 'Like icon hover color',THEME_DOMAIN ),
            'id'            => 'news_post_like_icon_hover_color',
            'section'       => 'news-section-single',
            'transport'     => 'postMessage',
            'type'          => 'color',
            'selectors'     => '.single-news .wp_ulike_general_class .wp_ulike_btn:hover:before',
            'placeholder'   => 'color:{{VALUE}}',
            'default'       => '',
            'dependency'  => array(
                array(
                    'id'      => 'show_news_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'news_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            )
        );

        $options[] = array(
            'title'       => __( 'Like Button Icon Size', THEME_DOMAIN ),
            'id'          => 'news_post_like_icon_size',
            'section'     => 'news-section-single',
            'transport'   => 'postMessage',
            'type'        => 'text',
            'dependency'  => array(
                array(
                    'id'      => 'show_news_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'news_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            ),
            'style_callback' => function( $value = null ){
                if( ! $value ){
                    $value = esc_attr( auxin_get_option( 'news_post_like_icon_size' ) );
                }
                if( ! is_numeric( $value ) ){
                    $value = 10;
                }
                return $value ? ".single-news .wp_ulike_general_class .wp_ulike_btn:before { font-size:{$value}px; }" : '';
            }
        );

        $options[] = array(
            'title'          => __( 'Like Button Margin', THEME_DOMAIN ),
            'id'             => 'news_post_like_margin',
            'section'        => 'news-section-single',
            'type'           => 'responsive_dimensions',
            'selectors'      => '.single-news .wp_ulike_general_class button',
            'transport'      => 'postMessage',
            'placeholder'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            'dependency'  => array(
                array(
                    'id'      => 'show_news_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'news_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            ),
        );
    }

    $options[] = array(
        'title'       => __( 'Display Author Section', 'auxin-news' ),
        'description' => sprintf(__( 'Enable it to display %s author information%s after news content on single news.', 'auxin-news' ), '<strong>', '</strong>'),
        'id'          => 'show_news_author_section',
        'section'     => 'news-section-single',
        'dependency'  => array(),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'default'     => '0',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Display Author Biography Text', 'auxin-news' ),
        'description' => sprintf(__( 'Enable it to display %s author biography text%s in author section on single news.', 'auxin-news' ), '<strong>', '</strong>'),
        'id'          => 'show_news_author_section_text',
        'section'     => 'news-section-single',
        'dependency'  => array(
            array(
                 'id'      => 'show_news_author_section',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Display Author Socials', 'auxin-news' ),
        'description' => sprintf(__( 'Enable it to display %s author socials%s in author section on single news.', 'auxin-news' ), '<strong>', '</strong>'),
        'id'          => 'show_news_author_section_social',
        'section'     => 'news-section-single',
        'dependency'  => array(
            array(
                 'id'      => 'show_news_author_section',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Display Next & Previous News', 'auxin-news' ),
        'description' => __( 'Enable it to display links to next and previous news on single news page.', 'auxin-news' ),
        'id'          => 'show_news_single_next_prev_nav',
        'section'     => 'news-section-single',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.single-news .aux-single .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/single', 'news' );
            }
        ),
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] =    array(
        'title'       => __( 'Skin for Next & Previous Links', 'auxin-news' ),
        'description' => __( 'Specifies the skin for next and previous navigation block.', 'auxin-news' ),
        'id'          => 'news_single_next_prev_nav_skin',
        'section'     => 'news-section-single',
        'dependency'  => array(
            array(
                 'id'      => 'show_news_single_next_prev_nav',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'transport'   => 'postMessage',
        'choices'     => array(
            'minimal' => array(
                'label'     => __( 'Minimal (default)', 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-1.svg'
            ),
            'thumb-arrow' => array(
                'label'     => __( 'Thumbnail with Arrow', 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-2.svg'
            ),
            'thumb-no-arrow' => array(
                'label'     => __( 'Thumbnail without Arrow', 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-3.svg'
            ),
            'boxed-image' => array(
                'label'     => __( 'Navigation with Light Background', 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-4.svg'
            ),
            'boxed-image-dark' => array(
                'label'     => __( 'Navigation with Dark Background', 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-5.svg'
            ),
            'thumb-arrow-sticky' => array(
                'label'     => __( 'Sticky Thumbnail with Arrow', 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-6.svg'
            )
        ),
        'partial'     => array(
            'selector'              => '.single-news .aux-single .aux-next-prev-posts-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_single_page_navigation(
                    array(
                        'prev_text'      => __( 'Previous News', 'auxin-news' ),
                        'next_text'      => __( 'Next News'    , 'auxin-news' ),
                        'skin'           => esc_attr( auxin_get_option( 'news_single_next_prev_nav_skin' ) ) // minimal, thumb-no-arrow, thumb-arrow, boxed-image
                    )
                );
            }
        ),
        'type'        => 'radio-image',
        'default'     => 'minimal'
    );


    // Sub section - News Title bar -------------------------------

    $sections[] = array(
        'id'           => 'news-section-single-titlebar',
        'parent'       => 'news-section', // section parent's id
        'title'        => __( 'News Title', 'auxin-news' ),
        'description'  => __( 'Preview a news page', 'auxin-news' ),
        'preview_link' => auxin_get_last_post_permalink( array( 'post_type' => 'news' ) )
    );

    $options[] = array(
        'title'         => __( 'Display Title Bar Section', 'auxin-news' ),
        'description'   => __( 'Enable it to show the title section.', 'auxin-news' ),
        'id'            => 'news_title_bar_show',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Layout presets', 'auxin-news' ),
        'description'   => '',
        'id'            => 'news_title_bar_preset',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'normal_title_1',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'normal_title_1' => array(
                'label'   => __( 'Default', 'auxin-news' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-4.svg',
                'presets' => array(
                    'news_title_bar_content_width_type'      => 'boxed',
                    'news_title_bar_content_section_height'  => 'auto',
                    'news_title_bar_heading_bordered'        => 0,
                    'news_title_bar_heading_boxed'           => 0,
                    'news_title_bar_meta_enabled'            => 0,
                    'news_title_bar_bread_enabled'           => 1,
                    'news_title_bar_bread_bordered'          => 0,
                    'news_title_bar_bread_sep_style'         => 'arrow',
                    'news_title_bar_text_align'              => 'left',
                    'news_title_bar_vertical_align'          => 'top',
                    'news_title_bar_scroll_arrow'            => 'none',
                    'news_title_bar_color_style'             => 'dark',
                    'news_title_bar_overlay_color'           => ''
                )
            ),
            'normal_bg_light_1' => array(
                'label'   => __( 'Title bar with light overlay which is aligned center', 'auxin-news' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-1.svg',
                'presets' => array(
                    'news_title_bar_content_width_type'      => 'boxed',
                    'news_title_bar_content_section_height'  => 'auto',
                    'news_title_bar_heading_bordered'        => 0,
                    'news_title_bar_heading_boxed'           => 0,
                    'news_title_bar_bread_enabled'           => 1,
                    'news_title_bar_bread_bordered'          => 0,
                    'news_title_bar_bread_sep_style'         => 'arrow',
                    'news_title_bar_text_align'              => 'center',
                    'news_title_bar_vertical_align'          => 'top',
                    'news_title_bar_scroll_arrow'            => 'none',
                    'news_title_bar_color_style'             => 'dark',
                    'news_title_bar_overlay_color'           => ''
                )
            ),
            'full_bg_light_1' => array(
                'label'   => __( 'Fullscreen title bar with light overlay on background', 'auxin-news' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-2.svg',
                'presets' => array(
                    'news_title_bar_content_width_type'      => 'boxed',
                    'news_title_bar_content_section_height'  => 'full',
                    'news_title_bar_heading_bordered'        => 0,
                    'news_title_bar_heading_boxed'           => 0,
                    'news_title_bar_bread_enabled'           => 1,
                    'news_title_bar_bread_bordered'          => 1,
                    'news_title_bar_bread_sep_style'         => 'slash',
                    'news_title_bar_text_align'              => 'center',
                    'news_title_bar_vertical_align'          => 'middle',
                    'news_title_bar_scroll_arrow'            => 'round',
                    'news_title_bar_color_style'             => 'dark',
                    'news_title_bar_overlay_color'           => 'rgba(255,255,255,0.50)'
                )
            ),
            'full_bg_dark_1' => array(
                'label'   => __( 'Fullscreen title bar with dark overlay on background', 'auxin-news' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-3.svg',
                'presets' => array(
                    'news_title_bar_content_width_type'      => 'boxed',
                    'news_title_bar_content_section_height'  => 'full',
                    'news_title_bar_heading_bordered'        => 0,
                    'news_title_bar_heading_boxed'           => 0,
                    'news_title_bar_bread_enabled'           => 1,
                    'news_title_bar_bread_bordered'          => 0,
                    'news_title_bar_bread_sep_style'         => 'slash',
                    'news_title_bar_text_align'              => 'center',
                    'news_title_bar_vertical_align'          => 'middle',
                    'news_title_bar_scroll_arrow'            => 'round',
                    'news_title_bar_color_style'             => 'light',
                    'news_title_bar_overlay_color'           => 'rgba(0,0,0,0.6)'
                )
            ),
            'full_bg_dark_2' => array(
                'label'   => __( 'Fullscreen title bar with border around the title', 'auxin-news' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-6.svg',
                'presets' => array(
                    'news_title_bar_content_width_type'      => 'boxed',
                    'news_title_bar_content_section_height'  => 'full',
                    'news_title_bar_heading_bordered'        => 1,
                    'news_title_bar_heading_boxed'           => 0,
                    'news_title_bar_bread_enabled'           => 0,
                    'news_title_bar_bread_bordered'          => 1,
                    'news_title_bar_bread_sep_style'         => 'slash',
                    'news_title_bar_text_align'              => 'center',
                    'news_title_bar_vertical_align'          => 'middle',
                    'news_title_bar_scroll_arrow'            => 'round',
                    'news_title_bar_color_style'             => 'dark',
                    'news_title_bar_overlay_color'           => 'rgba(250,250,250,0.3)'
                )
            ),
            'full_bg_dark_3' => array(
                'label'   => __( 'Fullscreen title bar with dark box around the title', 'auxin-news' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-7.svg',
                'presets' => array(
                    'news_title_bar_content_width_type'      => 'boxed',
                    'news_title_bar_content_section_height'  => 'full',
                    'news_title_bar_heading_bordered'        => 0,
                    'news_title_bar_heading_boxed'           => 1,
                    'news_title_bar_bread_enabled'           => 0,
                    'news_title_bar_bread_bordered'          => 0,
                    'news_title_bar_bread_sep_style'         => 'slash',
                    'news_title_bar_text_align'              => 'center',
                    'news_title_bar_vertical_align'          => 'middle',
                    'news_title_bar_scroll_arrow'            => 'round',
                    'news_title_bar_color_style'             => 'light',
                    'news_title_bar_overlay_color'           => 'rgba(0,0,0,0.5)'
                )
            ),
            'normal_bg_dark_1' => array(
                'label'   => __( 'Title aligned left with dark overlay on background', 'auxin-news' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-5.svg',
                'presets' => array(
                    'news_title_bar_content_width_type'      => 'boxed',
                    'news_title_bar_content_section_height'  => 'auto',
                    'news_title_bar_heading_bordered'        => 0,
                    'news_title_bar_heading_boxed'           => 0,
                    'news_title_bar_bread_enabled'           => 1,
                    'news_title_bar_bread_bordered'          => 0,
                    'news_title_bar_bread_sep_style'         => 'gt',
                    'news_title_bar_text_align'              => 'left',
                    'news_title_bar_vertical_align'          => 'bottom',
                    'news_title_bar_scroll_arrow'            => 'none',
                    'news_title_bar_color_style'             => 'light',
                    'news_title_bar_overlay_color'           => 'rgba(0,0,0,0.3)'
                )
            ),
            'full_bg_dark_4' => array(
                'label'   => __( 'Tile overlaps the title area section and is aligned center', 'auxin-news' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-8.svg',
                'presets' => array(
                    'news_title_bar_content_width_type'      => 'boxed',
                    'news_title_bar_content_section_height'  => 'auto',
                    'news_title_bar_heading_bordered'        => 0,
                    'news_title_bar_heading_boxed'           => 1,
                    'news_title_bar_bread_enabled'           => 1,
                    'news_title_bar_bread_bordered'          => 1,
                    'news_title_bar_bread_sep_style'         => 'gt',
                    'news_title_bar_text_align'              => 'center',
                    'news_title_bar_vertical_align'          => 'bottom-overlap',
                    'news_title_bar_scroll_arrow'            => 'none',
                    'news_title_bar_color_style'             => 'light',
                    'news_title_bar_overlay_color'           => 'rgba(0,0,0,0.5)'
                )
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Enable advanced setting', 'auxin-news' ),
        'description'   => __( 'Enable it to customize preset layouts.', 'auxin-news' ),
        'id'            => 'news_title_bar_enable_customize',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Content Width', 'auxin-news' ),
        'description'   => '',
        'id'            => 'news_title_bar_content_width_type',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'post_js'       => '$(".single-news .page-title-section .page-header").alterClass( "aux-*-container", "aux-"+ to +"-container" );',
        'type'          => 'radio-image',
        'default'       => 'boxed',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'boxed' => array(
                'label'     => __( 'Boxed', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-content-boxed',
            ),
            'semi-full' => array(
                'label'     => __( 'Full Width Content with Space on Sides', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-content-full-with-spaces'
            ),
            'full' => array(
                'label'     => __( 'Full Width Content', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-content-full'
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Title Section Height', 'auxin-news' ),
        'description'   => '',
        'id'            => 'news_title_bar_content_section_height',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'select',
        'default'       => 'auto',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'auto'  => __( 'Auto Height', 'auxin-news' ),
            'full'  => __( 'Full Height', 'auxin-news' )
        )
    );

    $options[] = array(
        'title'         => __( 'Vertical Position', 'auxin-news' ),
        'description'   => __( 'Specifies vertical alignment of title and subtitle.', 'auxin-news' ) . "<br/>".
                           __( 'Note: Parallax feature in not available for "Bottom Overlap" vertical mode.', 'auxin-news' ),
        'id'            => 'news_title_bar_vertical_align',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'select',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'            => array(
            'top'            => __( 'Top'    , 'auxin-news' ),
            'middle'         => __( 'Middle' , 'auxin-news' ),
            'bottom'         => __( 'Bottom' , 'auxin-news' ),
            'bottom-overlap' => __( 'Bottom Overlap', 'auxin-news' )
        )
    );

    $options[] = array(
        'title'         => __( 'Scroll Down Arrow', 'auxin-news' ),
        'description'   => __( 'This option only applies if section height is "Full Height".', 'auxin-news' ),
        'id'            => 'news_title_bar_scroll_arrow',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_content_section_height',
                 'value'   => 'full',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_vertical_align',
                 'value'   => array('top', 'middle', 'bottom'),
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'none' => array(
                'label'     => __( 'None', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-none'
            ),
            'round' => array(
                'label'     => __( 'Round', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-scroll-down-arrow-outline'
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Display Titles', 'auxin-news' ),
        'description'   => __( 'Enable it to display title/subtitle in title section.', 'auxin-news' ),
        'id'            => 'news_title_bar_title_show',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '1',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Border for Heading', 'auxin-news' ),
        'description'   => __( 'Enable it to display a border around the title and subtitle area.', 'auxin-news' ),
        'id'            => 'news_title_bar_heading_bordered',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_title_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Boxed Title', 'auxin-news' ),
        'description'   => __( 'Enable it to wrap the title and subtitle in a box with background color.', 'auxin-news' ),
        'id'            => 'news_title_bar_heading_boxed',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_title_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Title Box Custom Color', 'auxin-news' ),
        'description'   => __( 'Specifies a custom background color for the box around the title and subtitle.', 'auxin-news' ),
        'id'            => 'news_title_bar_heading_bg_color',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'color',
        'selectors'     => ' ',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_title_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_heading_boxed',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Display Post Meta', 'auxin-news' ),
        'description'   => __( 'Enable it to display post meta information on title section.', 'auxin-news' ),
        'id'            => 'news_title_bar_meta_enabled',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Display Breadcrumb', 'auxin-news' ),
        'description'   => __( 'Enable it to display breadcrumb on title section.', 'auxin-news' ),
        'id'            => 'news_title_bar_bread_enabled',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '1',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Border for Breadcrumb', 'auxin-news' ),
        'description'   => __( 'Enable it to display border around breadcrumb.', 'auxin-news' ),
        'id'            => 'news_title_bar_bread_bordered',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_bread_enabled',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'       => __( 'Breadcrumb Separator Icon', 'auxin-news' ),
        'description' => '',
        'id'          => 'news_title_bar_bread_sep_style',
        'section'     => 'news-section-single-titlebar',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_bread_enabled',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'default'     => 'auxicon-chevron-right-1',
        'transport'   => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'        => 'icon'
    );

    $options[] = array(
        'title'         => __( 'Text Align', 'auxin-news' ),
        'description'   => '',
        'id'            => 'news_title_bar_text_align',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'left',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'left' => array(
                'label'     => __( 'Left', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-text-align-left',
            ),
            'center' => array(
                'label'     => __( 'Center', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-text-align-center'
            ),
            'right' => array(
                'label'     => __( 'Right', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-text-align-right'
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Overlay Color', 'auxin-news' ),
        'description'   => __( 'The color that overlay on the background. Please note that color should have transparency.','auxin-news' ),
        'id'            => 'news_title_bar_overlay_color',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'color',
        'selectors'     => ' ',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Overlay Pattern', 'auxin-news' ),
        'description'   => '',
        'id'            => 'news_title_bar_overlay_pattern',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'none',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'none' => array(
                'label'     => __( 'None', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-none'
            ),
            'hash' => array(
                'label'     => __( 'Hash', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-pattern',
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Overlay Pattern Opacity', 'auxin-news' ),
        'description'   => '',
        'id'            => 'news_title_bar_overlay_pattern_opacity',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'type'          => 'text',
        'default'       => '0.5',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_overlay_pattern',
                 'value'   => array('hash'),
                 'operator'=> '=='
            )
        ),
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'news_title_bar_overlay_pattern_opacity' ) );
            }
            if( ! is_numeric( $value ) || (float) $value > 1 ){
                $value = 1;
            }
            return $value ? ".single-news .aux-overlay-bg-hash::before { opacity:$value; }" : '';
        }
    );

    $options[] = array(
        'title'         => __( 'Color Mode', 'auxin-news' ),
        'description'   => '',
        'id'            => 'news_title_bar_color_style',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'select',
        'default'       => 'dark',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'dark'  => __( 'Dark', 'auxin-news' ),
            'light' => __( 'Light', 'auxin-news' )
        )
    );

    ////////////////////////////////////////////////////////////////////////////////////////

    $options[] = array(
        'title'         => __( 'Enable Title Background', 'auxin-news' ),
        'description'   => __( 'Enable it to display custom background for title section.', 'auxin-news' ),
        'id'            => 'news_title_bar_bg_show',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Enable Parallax Effect', 'auxin-news' ),
        'description'   => __( 'Enable it to have parallax background effect on this section.', 'auxin-news' )."<br />".
                           __( 'Note: Parallax feature in not available for "Bottom Overlap" mode for "Vertical Position" option.', 'auxin-news' ),
        'id'            => 'news_title_bar_bg_parallax',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Background Color', 'auxin-news' ),
        'description'   => __( 'Specifies a background color for title bar.', 'auxin-news' ),
        'id'            => 'news_title_bar_bg_color',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'color',
        'selectors'     => ' ',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Size', 'auxin-news' ),
        'description'   => __( 'Specifies the background size.', 'auxin-news' ),
        'id'            => 'news_title_bar_bg_size',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices' => array(
            'auto' => array(
                'label'       => __( 'Auto', 'auxin-news' ),
                'css_class'   => 'axiAdminIcon-bg-size-1',
            ),
            'contain' => array(
                'label'       => __( 'Contain', 'auxin-news' ),
                'css_class'   => 'axiAdminIcon-bg-size-2',
            ),
            'cover' => array(
                'label'       => __( 'Cover', 'auxin-news' ),
                'css_class'   => 'axiAdminIcon-bg-size-3',
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Image', 'auxin-news' ),
        'description'   => __( 'Specifies a background image for title bar.', 'auxin-news' ),
        'id'            => 'news_title_bar_bg_image',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'image',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Video MP4', 'auxin-news' ),
        'description'   => __( 'You can upload custom video for title background</br>Note: if you set custom image, default image backgrounds will be ignored.', 'auxin-news' ),
        'id'            => 'news_title_bar_bg_video_mp4',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'video',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )

    );

    $options[] = array(
        'title'         => __( 'Background Video Ogg', 'auxin-news' ),
        'description'   => __( 'You can upload custom video for title background</br>Note: if you set custom image, default image backgrounds will be ignored.', 'auxin-news' ),
        'id'            => 'news_title_bar_bg_video_ogg',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'video',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Video WebM', 'auxin-news' ),
        'description'   => __( 'You can upload custom video for title background</br>Note: if you set custom image, default image backgrounds will be ignored.', 'auxin-news' ),
        'id'            => 'news_title_bar_bg_video_webm',
        'section'       => 'news-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-news .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'video',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'news_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'news_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] =    array(
        'title'       => __( 'Display Post Title', 'auxin-news' ),
        'description' => __( 'Enable it to show the main title above post content.', 'auxin-news' ),
        'id'          => 'news_single_title_show_over_content',
        'section'     => 'news-section-single-titlebar',
        'dependency'  => array(
            array(
                'id'      => 'news_title_bar_show',
                'value'   => array('0'),
                'operator'=> '=='
            ),
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-news main .entry-main > .entry-header .entry-title").toggleClass( "aux-visually-hide", 0 == to );',
        'type'        => 'switch',
        'default'     => '1'
    );

    // Sub section - News Index Page -------------------------------

    $sections[] = array(
        'id'          => 'news-section-index',
        'parent'      => 'news-section', // section parent's id
        'title'       => __( 'News Archive', 'auxin-news' ),
        'description'  => __( 'Preview News Page', 'auxin-news'),
        'preview_link' => auxin_get_post_type_archive_shortlink('news')
    );

    $options[] =    array(
        'title'       => __('Custom Page For Archive', 'auxin-news'),
        'description' => __('Enable this option to select custom page for archive page', 'auxin-news'),
        'id'          => 'news_show_custom_archive_link',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'type'        => 'switch',
        'default'     => '0'
    );

    $options[] = array(
        'title'       => __('Select Page', 'auxin-news'),
        'id'          => 'news_custom_archive_link',
        'section'     => 'news-section-index',
        'dependency'  => array(
            array(
                'id'      => 'news_show_custom_archive_link',
                'value'   => '1',
                'operator'=> '=='
            )
        ),
        'type'        => 'select',
        'choices'     => auxin_list_pages(),
        'transport'   => 'postMessage'
    );

    $options[] = array(
        'title'       => __( 'News Index Page Template', 'auxin-news' ),
        'description' => 'Choose your news index template.',
        'id'          => 'news_index_template_type',
        'section'     => 'news-section-index',
        'dependency'  => array(),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'choices'     => array(
            // default template
            'news-default' => array(
                'label'  => __( 'Default', 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-6.svg'
            ),
            // aux-template-type-1
            'news-1' => array(
                'label'  => __( 'Template 1', 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-1.svg'
            ),

        ),
        'type'          => 'radio-image',
        'default'       => 'default'
    );

    $options[] = array(
        'title'       => __( 'News Sidebar Position', 'auxin-news' ),
        'description' => 'Specifies the position of sidebar on news index page.',
        'id'          => 'news_index_sidebar_position',
        'section'     => 'news-section-index',
        'dependency'  => array(),
        'post_js'     => '$(".archive.post-type-archive-news .aux-archive").alterClass( "*-sidebar", to );',
        'choices'     => array(
            'no-sidebar' => array(
                'label'  => __( 'No Sidebar', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'  => __( 'Right Sidebar', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar' => array(
                'label'  => __( 'Left Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'  => __( 'Left Left Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'  => __( 'Right Right Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'  => __( 'Left Right Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'  => __( 'Right Left Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'right-sidebar'
    );

    $options[] =    array(
        'title'       => __( 'News Sidebar Style', 'auxin-news' ),
        'description' => 'Specifies style of sidebar on single news.',
        'id'          => 'news_index_sidebar_decoration',
        'section'     => 'news-section-index',
        'dependency'  => array(
            array(
                 'id'      => 'news_index_sidebar_position',
                 'value'   => 'no-sidebar',
                 'operator'=> '!='
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".archive.post-type-archive-news .aux-archive").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple'  => array(
                'label'  => __( 'Simple' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    $options[] = array(
        'title'       => __( 'Show Big Post', 'auxin-news' ),
        'description' => __( 'Show a big post in start of page.', 'auxin-news' ),
        'id'          => 'news_index_big_post_display',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'        => 'switch',
        'default'     => '1',
    );

    $options[] = array(
        'title'       => __( 'Show Big Post Image', 'auxin-news' ),
        'description' => __( 'Show image for first post', 'auxin-news' ),
        'id'          => 'news_index_big_post_image_display',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'        => 'switch',
        'default'     => '1',
        'dependency'  => array(
            array(
                'id'       => 'news_index_big_post_display',
                'value'    => array('1'),
                'operator' => ''
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Exclude news without featured image.', 'auxin-news' ),
        'description' => __( 'Exclude news without featured image.', 'auxin-news' ),
        'id'          => 'news_index_post_exclude_no_media',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'        => 'switch',
        'default'     => '1',
    );

    $options[] = array(
        'title'       => __( 'Show Image', 'auxin-news' ),
        'description' => __( 'Show Image for posts', 'auxin-news' ),
        'id'          => 'news_index_post_image_display',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'        => 'switch',
        'default'     => '1',
    );

    $options[] = array(
        'title'       => __( 'Show Title', 'auxin-news' ),
        'description' => __( 'Show title for posts', 'auxin-news' ),
        'id'          => 'news_index_post_title_display',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'        => 'switch',
        'default'     => '1',
    );

    $options[] = array(
        'title'       => __( 'Show Info', 'auxin-news' ),
        'description' => __( 'Show info for posts', 'auxin-news' ),
        'id'          => 'news_index_post_info_display',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'        => 'switch',
        'default'     => '1',
    );

    $options[] = array(
        'title'       => __( 'Post Info Position', 'auxin-news' ),
        'description' => __( 'Show post info before or after post title.', 'auxin-news' ),
        'id'          => 'news_index_post_info_position',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'default'     => 'after_title',
        'type'        => 'select',
        'dependency'  => array(
            array(
                'id'       => 'news_index_post_info_display',
                'value'    => array('1'),
                'operator' => ''
            )
        ),
        'choices'       => array(
            'before_title'      => __( 'Before Title', 'auxin-news' ),
            'after_title'  => __( 'After Title', 'auxin-news' )
        ),
    );

    $options[] = array(
        'title'       => __( 'Show Date', 'auxin-news' ),
        'description' => __( 'Show date for posts', 'auxin-news' ),
        'id'          => 'news_index_post_date_display',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'        => 'switch',
        'default'     => '1',
        'dependency'  => array(
            array(
                'id'       => 'news_index_post_info_display',
                'value'    => array('1'),
                'operator' => ''
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Show Author', 'auxin-news' ),
        'description' => __( 'Show author of posts', 'auxin-news' ),
        'id'          => 'news_index_post_author_display',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'        => 'switch',
        'default'     => '1',
        'dependency'  => array(
            array(
                'id'       => 'news_index_post_info_display',
                'value'    => array('1'),
                'operator' => ''
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Show Categories', 'auxin-news' ),
        'description' => __( 'Show categories of posts', 'auxin-news' ),
        'id'          => 'news_index_post_category_display',
        'section'     => 'news-section-index',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'        => 'switch',
        'default'     => '1',
        'dependency'  => array(
            array(
                'id'       => 'news_index_post_info_display',
                'value'    => array('1'),
                'operator' => ''
            )
        )
    );

    $options[] = array(
        'title'         => __('Display author or read more', 'auxin-news'),
        'description'   =>  __('Specifies whether to show author or read more on each post.', 'auxin-news'),
        'id'            => 'news_index_post_author_or_readmore',
        'section'       => 'news-section-index',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.post-type-archive-news .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxnew_get_template_part( 'theme-parts/loop', 'news' );
            }
        ),
        'type'          => 'select',
        'default'       => 'none',
        'choices'       => array(
            'readmore' => __('Read More', 'auxin-news'),
            'author'   => __('Author Name', 'auxin-news'),
            'none'     => __('None', 'auxin-news')
        )
    );

    // Sub section - News Taxonomy Page -------------------------------

    $sections[] = array(
        'id'          => 'news-section-taxonomy',
        'parent'      => 'news-section', // section parent's id
        'title'       => __( 'News Category & tag', 'auxin-news' ),
        'description' => __( 'News Category & tag page Setting', 'auxin-news' )
    );

    $options[] = array(
        'title'       => __( 'Taxonomy Page Sidebar Position', 'auxin-news' ),
        'description' => 'Specifies the position of sidebar on category & tag page.',
        'id'          => 'news_taxonomy_archive_sidebar_position',
        'section'     => 'news-section-taxonomy',
        'dependency'  => array(),
        'post_js'     => '$(".archive.tag main, .archive.tax-news-category main").alterClass( "*-sidebar", to );',
        'choices'     => array(
            'no-sidebar' => array(
                'label'  => __( 'No Sidebar', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'  => __( 'Right Sidebar', 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar' => array(
                'label'  => __( 'Left Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'  => __( 'Left Left Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'  => __( 'Right Right Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'  => __( 'Left Right Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'  => __( 'Right Left Sidebar' , 'auxin-news' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'right-sidebar'
    );

    $options[] = array(
        'title'       => __( 'Sidebar Style', 'auxin-news' ),
        'description' => __( 'Specifies the style of sidebar on category & tag page.', 'auxin-news' ),
        'id'          => 'news_taxonomy_archive_sidebar_decoration',
        'section'     => 'news-section-taxonomy',
        'dependency'  => array(
            array(
                 'id'      => 'news_taxonomy_archive_sidebar_position',
                 'value'   => 'no-sidebar',
                 'operator'=> '!='
            )
        ),
        'dependency' => array(),
        'post_js'    => '$(".archive.tag main, .archive.tax-news-category main").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple' => array(
                'label'  => __( 'Simple' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'auxin-news' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    // Sub section - Single News Typography -------------------------------

    $sections[] = array(
        'id'          => 'news-section-single-typography',
        'parent'      => 'news-section', // section parent's id
        'title'       => __( 'Single News Typography', 'auxin-news' ),
        'description' => __( 'Single News Typography', 'auxin-news' ),
    );

    $options[] = array(
        'title'          => __( 'Post Title', 'auxin-news' ),
        'id'             => 'single_news_title_typography',
        'description'    => '',
        'section'        => 'news-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-news .aux-primary .hentry .entry-title',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post Content', 'auxin-news' ),
        'id'             => 'single_news_content_typography',
        'description'    => '',
        'section'        => 'news-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-news .hentry .entry-content',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post info', 'auxin-news' ),
        'id'             => 'single_news_info_typography',
        'description'    => '',
        'section'        => 'news-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-news .hentry .entry-info',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post info terms', 'auxin-news' ),
        'id'             => 'single_news_info_terms_typography',
        'description'    => '',
        'section'        => 'news-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-news .hentry .entry-info a',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post Meta', 'auxin-news' ),
        'id'             => 'single_news_meta_typography',
        'description'    => '',
        'section'        => 'news-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-news .hentry footer.entry-meta .entry-tax',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post Meta Terms', 'auxin-news' ),
        'id'             => 'single_news_meta_terms_typography',
        'description'    => '',
        'section'        => 'news-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-news .hentry footer.entry-meta .entry-tax a',
        'transport'      => 'postMessage',
    );

    // Sub section - Archive News Typography -------------------------------

    $sections[] = array(
        'id'          => 'news-section-archive-typography',
        'parent'      => 'news-section', // section parent's id
        'title'       => __( 'Archive News Typography', 'auxin-news' ),
        'description' => __( 'Archive News Typography', 'auxin-news' ),
    );

    $options[] = array(
        'title'          => __( 'Post Title', 'auxin-news' ),
        'id'             => 'archive_news_title_typography',
        'description'    => '',
        'section'        => 'news-section-archive-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.archive .aux-primary  .auxin-news-element .hentry .entry-title',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post Content', 'auxin-news' ),
        'id'             => 'archive_news_content_typography',
        'description'    => '',
        'section'        => 'news-section-archive-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.archive .aux-primary .auxin-news-element .hentry .entry-content',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post info', 'auxin-news' ),
        'id'             => 'archive_news_info_typography',
        'description'    => '',
        'section'        => 'news-section-archive-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.archive .aux-primary  .auxin-news-element .hentry .entry-info',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post info terms', 'auxin-news' ),
        'id'             => 'archive_news_info_terms_typography',
        'description'    => '',
        'section'        => 'news-section-archive-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.archive .aux-primary  .auxin-news-element .hentry .entry-info a',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Big Post Title', 'auxin-news' ),
        'id'             => 'archive_news_big_title_typography',
        'description'    => '',
        'section'        => 'news-section-archive-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.archive .aux-primary  .auxin-news-element .hentry .auxnew-big-post .entry-title .aux-h4',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'       => 'news_index_big_post_display',
                'value'    => array('1'),
                'operator' => ''
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Big Post Content', 'auxin-news' ),
        'id'             => 'archive_news_big_content_typography',
        'description'    => '',
        'section'        => 'news-section-archive-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.archive .aux-primary .auxin-news-element .hentry .auxnew-big-post .entry-content',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'       => 'news_index_big_post_display',
                'value'    => array('1'),
                'operator' => ''
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Big Post info', 'auxin-news' ),
        'id'             => 'archive_news_big_info_typography',
        'description'    => '',
        'section'        => 'news-section-archive-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.archive .aux-primary .auxin-news-element .hentry .auxnew-big-post .entry-info',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'       => 'news_index_big_post_display',
                'value'    => array('1'),
                'operator' => ''
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Big Post info terms', 'auxin-news' ),
        'id'             => 'archive_news_big_info_terms_typography',
        'description'    => '',
        'section'        => 'news-section-archive-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.archive .aux-primary .auxin-news-element .hentry .auxnew-big-post .entry-info a',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'       => 'news_index_big_post_display',
                'value'    => array('1'),
                'operator' => ''
            )
        )
    );

    return array( 'fields' => $options, 'sections' => $sections );
}

add_filter( 'auxin_defined_option_fields_sections', 'auxin_define_news_theme_options', 14, 1 );


/**
 * Add new active post types
 *
 * @param  array $active_post_types  The list of allowed post types
 * @return array
 */
function auxnew_allow_new_active_post_types( $active_post_types ){
    $active_post_types['news'] = true;

    return $active_post_types;
}
add_filter( 'auxin_active_post_types', 'auxnew_allow_new_active_post_types' );


/**
 * Init news post type and corresponding metaboxes
 *
 * @return void
 */
function aunnew_add_post_type_metafields(){

    $post_type = 'news';

    if( 1 || auxin_is_post_type_allowed( $post_type ) ){
        // Initiate the post type
        $post_type_instance = new Auxin_Post_Type_News();
        $post_type_instance->register();

        $metabox_args['hub_id']        = 'axi_meta_hub_news';
        $metabox_args['hub_title']     = __( 'News Options', 'auxin-news' );
        $metabox_args['to_post_types'] = array( $post_type );

        // Load metabox fields on admin
        if( is_admin() ){
            auxin_maybe_render_metabox_hub_for_post_type( $metabox_args );
        }
    }

}

add_action( 'init', 'aunnew_add_post_type_metafields' );



// Enqueue Requirements for Wordpress Color Picker API

function auxnew_wp_color_picker(){

    //Enqueue Style
    wp_enqueue_style( 'wp-color-picker' );

    //Enqueue Script
    wp_enqueue_script( 'wp-color-picker' );

}

add_action('admin_enqueue_scripts', 'auxnew_wp_color_picker');



// This Function Will Add The Custom Meta Field ( Color Picker ) in Taxonomy Page

function auxnew_taxonomy_add_new_color_field() {
?>

    <script>
        (function( $ ) {
            $(function() {
            $('.color-field').wpColorPicker();
            });
        })( jQuery );
    </script>
    <div class="custom_meta_box">
        <p>
            <label><?php _e( 'Select Category Color:', 'auxin-news' ); ?></label>
            <input class="color-field" type="text" name="cat_color"/>
        </p>
    </div>

<?php
}


add_action( 'news-category_add_form_fields', 'auxnew_taxonomy_add_new_color_field', 10, 2 );


// This Function Will Add The Custom Meta Field ( Color Picker ) in Taxonomy Edit Page
function auxnew_taxonomy_edit_new_color_field( $term ) {

    $t_id = $term->term_id;
 ?>

    <script>
        (function( $ ) {
            $(function() {
            $('.color-field').wpColorPicker();
            });
        })( jQuery );
    </script>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label><?php _e( 'Select Category Color', 'auxin-news' ); ?></label>
        </th>
        <td>
            <input class="color-field" type="text" name="cat_color" value="<?php echo get_term_meta( $t_id , 'auxnew_cat_color' , true) ;?>" />
        </td>
    </tr>

<?php
}

add_action( 'news-category_edit_form_fields', 'auxnew_taxonomy_edit_new_color_field', 10, 2 );


// This Function Will Save The  Value of Custom Meta Field
function auxnew_save_groups_custom_meta( $term_id ){

    if ( isset( $_POST['cat_color'] ) ){

        update_term_meta( $term_id, 'auxnew_cat_color', $_POST['cat_color'] );

    }
}

add_action( 'edited_news-category', 'auxnew_save_groups_custom_meta', 10, 1 );
add_action( 'create_news-category', 'auxnew_save_groups_custom_meta', 10, 1 );



// This Function Will Add The Custom Column in Taxonomy Page
function auxnew_custom_column_header( $columns ){

    $columns['cat_color'] = 'Color';
    return $columns;

}


add_filter( 'manage_edit-news-category_columns', 'auxnew_custom_column_header', 10 );


// This Function Will Add The Value Of Custom Meta field in Our  Custom Column
function auxnew_custom_column_content( $value, $column_name, $tax_id ){

    $value = get_term_meta( $tax_id , 'auxnew_cat_color' , true);
?>

    <div class="cat-color-box-preview" style="height: 15px;width: 15px;background-color: <?php echo $value;?> "></div>

<?php
}

add_action( "manage_news-category_custom_column", 'auxnew_custom_column_content', 10, 3);

/**
 * Generate the page builder content markup for news template
 *
 * @param  string $the_content_markup    The page builder content with corresponding containers
 * @param  string $content               The page content
 * @param  string $page_content_location The location that page builder content should appear
 * @return string                        The page markup
 */
function auxin_get_the_news_page_template_content_markup( $the_content_markup, $content, $page_content_location ){

    if( ! empty( $content ) && ! is_paged() ){
        $layout_classes = in_array( $page_content_location, array( 'above-boxed', 'below-boxed' ) ) ? 'aux-fold aux-center-margin clearfix' : '';

        ob_start();
        ?>
        <article <?php post_class( $layout_classes ); ?> >
            <div class="entry-main">
                <div class="entry-content">
                <?php
                    echo $content;
                    // clear the floated elements at the end of content
                    echo '<div class="clear"></div>';
                ?>
                </div>
            </div>
        </article>
        <?php
        $the_content_markup = ob_get_clean();
    }

    return $the_content_markup;
}
add_filter( 'auxin_news_page_template_content_markup', 'auxin_get_the_news_page_template_content_markup', 10, 3 );

/**
 * Disable gutenberg editor
 *
 * @param string $current_status
 * @param string $post_type
 * @return boolean
 */
function auxnew_disable_block_editor( $current_status, $post_type ){
    return !($post_type === 'news');
}
add_filter('use_block_editor_for_post_type', 'auxnew_disable_block_editor', 10, 2 );

/**
 *
 * hooked to wp_ulike_add_templates_args in single-news template
 *
 */
function auxnew_change_like_icon ( $args ) {
    $like_class = (  'icon' === $like_type = auxin_get_option( 'news_post_like_button_type', 'icon' ) ) ? ' aux-icon ' . auxin_get_option( 'news_post_like_icon', 'auxicon-heart-2' ) : 'aux-has-text';

    $args['button_class'] .= ' ' . $like_class;
    if ( $like_type === 'text' ) {
        $args['button_type'] = 'text';
        $args['button_text'] = __( 'Like', 'auxin-news' );
    }

    return $args;
}
<?php
include_once(DZSAP_BASE_PATH . 'inc/php/view-functions/view-embed-functions.php');
include_once(DZSAP_BASE_PATH . 'inc/php/shortcodes/shortcode-player.php');

class DzsapView {

  public $viewVar = 0;
  /** @var DZSAudioPlayer */
  public $dzsap;


  public $footer_style = '';
  /** @var string used if init_javascript_method is script */
  public $footerScript = '';
  public $footer_style_configs = array();

  public $extraFunctionalities = array();



  /** @var array used for playlist audio player configs */
  private $audioPlayerConfigs = array();

  /**
   * DzsapView constructor.
   * @param DZSAudioPlayer $dzsap
   */
  function __construct($dzsap) {

    $this->dzsap = $dzsap;


    add_action('init', array($this, 'handle_init_begin'), 3);
    add_action('init', array($this, 'handle_init'), 55);
    add_action('init', array($this, 'handle_init_end'), 900);
    add_action('wp_head', array($this, 'handle_wp_head'));
    add_action('wp_head', array($this, 'handle_wp_head_end'), 900);
    add_action('wp_enqueue_scripts', array($this, 'handle_wp_enqueue_scripts'), 900);


    add_action('wp_footer', array($this, 'handle_wp_footer_start'), 5);
    add_action('wp_footer', array($this, 'handle_wp_footer_end'), 500);


    add_shortcode(DZSAP_ZOOMSOUNDS_ACRONYM, array($this, 'shortcode_playlist_main'));
    add_shortcode('dzs_' . DZSAP_ZOOMSOUNDS_ACRONYM, array($this, 'shortcode_playlist_main'));
    add_action('widgets_init', array($this, 'handle_widgets_init'));


  }

  function handle_init_begin() {

    if (function_exists('vc_add_shortcode_param')) {
      vc_add_shortcode_param('dzs_add_media_att', 'vc_dzs_add_media_att');
    }
  }

  function printHeadScripts() {

    $dzsap = $this->dzsap;

    $usrId = get_current_user_id();
    $usrData = null;

    if ($usrId) {
      $usrData = get_user_by('id', $usrId);
    }
    global $post;


    $mainDzsapSettings = array(
      'dzsap_site_url' => site_url() . '/',
      'pluginurl' => DZSAP_URL_AUDIOPLAYER,
      'dzsap_curr_user' => $usrId,
      'version' => DZSAP_VERSION,
      'view_replace_audio_shortcode' => $dzsap->mainoptions['replace_audio_shortcode'],
      'ajax_url' => admin_url('admin-ajax.php') . '',
    );


    $lab = 'dzsaap_default_portal_upload_type';
    if ($dzsap->mainoptions[$lab] && $dzsap->mainoptions[$lab] != 'audio') {
      $mainDzsapSettings[$lab] = $dzsap->mainoptions[$lab];
    }
    if ($post && $post->post_type == DZSAP_REGISTER_POST_TYPE_NAME) {
      $mainDzsapSettings['playerid'] = $post->ID;
    }
    if (($usrData)) {
      $mainDzsapSettings['comments_username'] = $usrData->data->display_name;
      $mainDzsapSettings['comments_avatar'] = DZSZoomSoundsHelper::get_avatar_url(get_avatar($usrId, 40));
    }
    if ($dzsap->mainoptions['try_to_cache_total_time'] == 'on') {
      $jsName = 'action_received_time_total';
      $value = 'send_total_time';
      $mainDzsapSettings[$jsName] = $value;
    }
    if ($dzsap->mainoptions['construct_player_list_for_sync'] == 'on') {

      $mainDzsapSettings['syncPlayers_buildList'] = 'on';
      $mainDzsapSettings['syncPlayers_autoplayEnabled'] = true;
    }


    echo json_encode($mainDzsapSettings);

  }

  function handle_wp_enqueue_scripts() {
    $dzsap = $this->dzsap;



  }


  function handle_init() {
    $dzsap = $this->dzsap;


    if (!is_admin()) {
      if ($this->dzsap->mainoptions['replace_playlist_shortcode'] == 'on') {
        add_shortcode('playlist', array($this, 'shortcode_wpPlaylist'));
      }

      include_once DZSAP_BASE_PATH . 'inc/extensions/view/view-global-vol-icon.php';
      add_shortcode('zoomsounds_global_vol_icon', 'shortcode_zoomsounds_global_vol_icon');
    }


    add_shortcode('dzsap_show_curr_plays', array($this, 'show_curr_plays'));
    add_shortcode('zoomsounds_player_comment_field', array($this, 'shortcode_player_comment_field'));

    add_shortcode('zoomsounds_player', array($this, 'shortcode_player'));

    dzsap_view_embed_init_listeners();
  }

  function handle_init_end() {

    $dzsap = $this->dzsap;
    if ($dzsap->mainoptions['replace_audio_shortcode'] && $dzsap->mainoptions['replace_audio_shortcode'] !== 'off') {
      add_shortcode('audio', array($this, 'shortcode_audio'));

      wp_enqueue_script('replace-gutenberg-player', DZSAP_BASE_URL . 'libs/dzsap/replace-gutenberg-player/replace-gutenberg-player.js', array(), DZSAP_VERSION);




      $replaceAudioConfigVpConfig = $dzsap->mainoptions['replace_audio_shortcode'];
      $vpsettings = DZSZoomSoundsHelper::getVpConfigFromConfigsDatabase($replaceAudioConfigVpConfig);
      unset($vpsettings['settings']['id']);



      $this->audioPlayerConfigsAdd($replaceAudioConfigVpConfig, $vpsettings['settings']);
      $this->footer_style .= DZSZoomSoundsHelper::generateCssPlayerCustomColors(array(
        'configId' => $replaceAudioConfigVpConfig,
        'config' => $vpsettings['settings'],
      ));

    }


    if ($dzsap->mainoptions['extra_css']) {
      wp_register_style('dzsap-hook-head-styles', false);
      wp_enqueue_style('dzsap-hook-head-styles');
      wp_add_inline_style('dzsap-hook-head-styles', stripslashes($dzsap->mainoptions['extra_css']));
    }

    if (!is_admin()) {

      // -- extra
      include_once(DZSAP_BASE_PATH . 'inc/php/view-functions/extra-functionality/syncPlayers-autoplay-toggler.php');
      add_shortcode('dzsap_syncplayers_autoplay_toggler', 'dzsap_shortcode_syncplayers_autoplay_toggler');
    }

  }

  function handle_wp_head() {
    $dzsap = $this->dzsap;


    if (is_tax(DZSAP_TAXONOMY_NAME_SLIDERS) || ($dzsap->mainoptions['single_index_seo_disable'] == 'on' && is_singular('dzsap_items'))) {
      echo '<meta name="robots" content="noindex, follow">';
    }


    if ($dzsap->mainoptions['replace_powerpress_plugin'] == 'on') {
      global $post;
      if ($post) {
        if ($post->ID != '4812' && $post->ID != '23950') {
          $dzsap->mainoptions['replace_powerpress_plugin'] = 'off';
        }
      }
    }

    if (isset($_GET['dzsap_generate_pcm']) && $_GET['dzsap_generate_pcm']) {
      include DZSAP_BASE_PATH . 'class_parts/part-regenerate-waves-player.php';
    }


    if ($dzsap->mainoptions['replace_powerpress_plugin'] == 'on') {
      add_filter('the_content', array($this, 'filter_the_content'));
    }


    if (!is_single() && (is_post_type_archive(DZSAP_REGISTER_POST_TYPE_NAME) || is_tax(DZSAP_REGISTER_POST_TYPE_CATEGORY))) {
      if ($dzsap->mainoptions['excerpt_hide_zoomsounds_data'] == 'on' || $dzsap->mainoptions['exceprt_zoomsounds_posts']) {
        add_filter('get_the_excerpt', array($this, 'filter_the_content_end'), 9999);
      }
    }

    echo '<script id="dzsap-main-settings" class="dzsap-main-settings" type="application/json">';
    $this->printHeadScripts();
    echo '</script>';

    wp_register_style('dzsap-init-styles', false);
    wp_enqueue_style('dzsap-init-styles');

    wp_add_inline_style('dzsap-init-styles', '.audioplayer,.audioplayer-tobe,.audiogallery{opacity:0;}');

    DZSZoomSoundsHelper::echoJavascriptKeyboardControls($dzsap);

  }


  function handle_wp_footer_start() {

    if ($this->dzsap->mainoptions['init_javascript_method'] == 'script') {

      $this->footerScript .= 'jQuery(document).ready(function($){';
      $this->footerScript .= '$(\'.audioplayer-tobe:not(.dzsap-inited)\').addClass(\'auto-init\'); ';
      $this->footerScript .= 'if(window.dzsap_init_allPlayers) { window.dzsap_init_allPlayers($); }';
      $this->footerScript .= '});';


      wp_register_script(DZSAP_ID . '-inline-footer', false);
      wp_enqueue_script(DZSAP_ID . '-inline-footer');
      wp_add_inline_script(DZSAP_ID . '-inline-footer', $this->footerScript, 'before');
    }


    if ($this->dzsap->mainoptions['failsafe_ajax_reinit_players'] == 'on') {
      wp_enqueue_script('dzsap-init-all-players-on-interval', DZSAP_BASE_URL . 'inc/js/shortcodes/init-all-players-on-interval.js', array(), DZSAP_VERSION);
    }

    $this->generateArgsForFooterStickyPlayerFromMeta();

    if (isset($_GET['action'])) {
      if ($_GET['action'] == 'embed_zoomsounds') {
        dzsap_view_embed_generateHtml();
      }
    }
    $this->handle_footer_extraHtml();
  }

  function handle_wp_footer_end() {

  }

  function filter_the_content($fout) {
    $dzsap = $this->dzsap;

    if ($dzsap->mainoptions['replace_powerpress_plugin'] == 'on') {
      return dzsap_powerpress_filter_content($fout);
    }


    return $fout;
  }

  function filter_the_content_end($fout) {
    global $post;
    $dzsap = $this->dzsap;

    $postTitle = '';

    if ($post && $post->post_title) {
      $postTitle = $post->post_title;
    }


    if ($dzsap->mainoptions['exceprt_zoomsounds_posts']) {

      $shortcodePatternStr = DZSZoomSoundsHelper::sanitize_from_shortcode_pattern($dzsap->mainoptions['exceprt_zoomsounds_posts'], $post);
      $fout = do_shortcode($shortcodePatternStr);
    } else {
      if ($dzsap->mainoptions['excerpt_hide_zoomsounds_data'] == 'on') {

        $fout = str_replace($postTitle . $postTitle . $postTitle, '', $fout);
        $fout = str_replace($postTitle . $postTitle, '', $fout);
        $fout = str_replace('Stats Edit Delete', '', $fout);
        $fout = str_replace('Add to cart', '', $fout);

        $fout = preg_replace('/\[zoomsounds.*?]/', ' ', $fout);;;
        $fout = preg_replace('/&lt;iframe.*?&lt;\/iframe&gt;/', ' ', $fout);;
      }

    }


    return $fout;
  }

  /**
   * gets properties only needed for frontend
   * eliminates default props
   * @param $config_name
   * @return array|string[][]
   */
  public function get_zoomsounds_player_config_settings($config_name) {

    $dzsap = $this->dzsap;

    $vpsettingsdefault = array(
      'id' => 'default',
      'skin_ap' => 'skin-wave',
      'skinwave_dynamicwaves' => 'off',
      'skinwave_enablespectrum' => 'off',
      'skinwave_enablereflect' => 'on',
      'skinwave_comments_enable' => 'off',
      'disable_volume' => 'default',
      'playfrom' => 'default',
      'enable_embed_button' => 'off',
      'loop' => 'off',
      'soundcloud_track_id' => '',
      'soundcloud_secret_token' => '',
    );


    $vpconfig_k = -1;

    $vpsettings = array();
    $vpconfig_id = $config_name;


    if (is_array($config_name)) {


      $vpsettings['settings'] = $config_name;


    } else {

      for ($i = 0; $i < count($dzsap->mainitems_configs); $i++) {
        if ((isset($vpconfig_id)) && ($vpconfig_id == $dzsap->mainitems_configs[$i]['settings']['id'])) {
          $vpconfig_k = $i;
        }
      }


      if ($vpconfig_k > -1) {
        $vpsettings = $dzsap->mainitems_configs[$vpconfig_k];
      } else {
        $vpsettings['settings'] = $vpsettingsdefault;
      }

      if (is_array($vpsettings) == false || is_array($vpsettings['settings']) == false) {
        $vpsettings = array('settings' => $vpsettingsdefault);
      }
    }

    return $vpsettings;
  }


  function handle_footer_extraHtml() {

    $dzsap = $this->dzsap;

    if ($this->footer_style) {
      wp_register_style('dzsap-footer-style', false);
      wp_enqueue_style('dzsap-footer-style');
      wp_add_inline_style('dzsap-footer-style', $this->footer_style);
    }


    if ($dzsap->og_data && count($dzsap->og_data)) {
      $ogThumbnailSrc = '';

      if (isset($dzsap->og_data['image'])) {
        $ogThumbnailSrc = $dzsap->og_data['image'];
      }
      echo '<meta property="og:title" content="' . $dzsap->og_data['title'] . '" />';
      echo '<meta property="og:description" content="' . strip_tags($dzsap->og_data['description']) . '" />';

      if ($ogThumbnailSrc) {
        echo '<meta property="og:image" content="' . $ogThumbnailSrc . '" />';
      }
    }


    if ($dzsap->isEnableMultisharer) {
      dzsap_generateHtmlMultisharer();
    }


    if (count($this->audioPlayerConfigs) > 0) {
      ?>
      <div hidden class="dzsap-feed--dzsap-configs"><?php echo json_encode($this->audioPlayerConfigs); ?></div><?php
    }

    if (($dzsap->mainoptions['wc_loop_product_player'] && $dzsap->mainoptions['wc_loop_product_player'] != 'off') || ($dzsap->mainoptions['wc_single_product_player'] && $dzsap->mainoptions['wc_single_product_player'] != 'off')) {


      if ($dzsap->mainoptions['wc_loop_player_position'] == 'overlay') {
        dzsap_generateHtmlWoocommerceOverlayPlayer();
      }
    }


    if (isset($dzsap->mainoptions['replace_powerpress_plugin']) && $dzsap->mainoptions['replace_powerpress_plugin'] == 'on') {
      dzsap_powerpress_generateHtmlEnclosureData();
    }


  }

  /**
   *  generate the footer player args from the meta info
   */
  function generateArgsForFooterStickyPlayerFromMeta() {
    global $wp_query;

    $dzsap = $this->dzsap;

    $isFooterPlayerEnabled = false;
    $footer_player_source = 'fake';
    $footer_player_config = 'fake';
    $footer_player_type = 'fake';
    $footer_player_songName = '';


    if ($dzsap->mainoptions['enable_global_footer_player'] != 'off') {

      $isFooterPlayerEnabled = true;
      $footer_player_source = 'fake';
      $footer_player_type = 'fake';
      $footer_player_config = $dzsap->mainoptions['enable_global_footer_player'];
    }

    if ($wp_query && $wp_query->post) {
      if ((get_post_meta($wp_query->post->ID, DZSAP_META_NAME_FOOTER_FEATURED_MEDIA, true)
        || get_post_meta($wp_query->post->ID, DZSAP_META_NAME_FOOTER_ENABLE, true) == 'on')
      ) {

        $isFooterPlayerEnabled = true;


        $footer_player_config = get_post_meta($wp_query->post->ID, DZSAP_META_NAME_FOOTER_VPCONFIG, true);
        if (get_post_meta($wp_query->post->ID, DZSAP_META_NAME_FOOTER_FEED_TYPE, true) == 'custom') {
          $footer_player_source = get_post_meta($wp_query->post->ID, DZSAP_META_NAME_FOOTER_FEATURED_MEDIA, true);
          $footer_player_type = get_post_meta($wp_query->post->ID, DZSAP_META_NAME_FOOTER_TYPE, true);

        }
        if (get_post_meta($wp_query->post->ID, DZSAP_META_NAME_FOOTER_SONG_NAME, true)) {
          $footer_player_songName = get_post_meta($wp_query->post->ID, DZSAP_META_NAME_FOOTER_SONG_NAME, true);

        }
      }
    }


    if ($isFooterPlayerEnabled) {
      if ($footer_player_source) {
        $this->view_generateFooterPlayer($footer_player_type, $footer_player_source, $footer_player_config, $footer_player_songName);
      }
    }
  }

  /**
   * generate the output
   * @param $footer_player_type
   * @param $footer_player_source
   * @param $footer_player_config
   * @param $footer_player_songName
   */
  function view_generateFooterPlayer($footer_player_type, $footer_player_source, $footer_player_config, $footer_player_songName) {

    $dzsap = $this->dzsap;


    $dzsap->front_scripts();

    $cueMedia = 'on';
    if ($footer_player_type === 'fake') {
      $cueMedia = 'off';
    }

    $playerArgs = array(
      'player_id' => DZSAP_VIEW_STICKY_PLAYER_ID,

      'source' => $footer_player_source,
      'cueMedia' => $cueMedia,
      'config' => $footer_player_config,
      'autoplay' => 'off',
      'songname' => $footer_player_songName,
      'type' => $footer_player_type,
    );


    $vpsettings = DZSZoomSoundsHelper::getVpConfigFromConfigsDatabase($footer_player_config);


    echo '<div class="dzsap-sticktobottom-placeholder dzsap-sticktobottom-placeholder-for-' . $vpsettings['settings']['skin_ap'] . '"></div>
<section class="dzsap-sticktobottom ';


    if ((isset($vpsettings['settings']['skin_ap']) == false ||
        $vpsettings['settings']['skin_ap'] == 'skin-wave') &&
      (isset($vpsettings['settings']['skinwave_mode']) && $vpsettings['settings']['skinwave_mode'] == 'small'
      )
    ) {
      echo ' dzsap-sticktobottom-for-skin-wave';
    }


    if (isset($vpsettings['settings']['skin_ap']) == false || ($vpsettings['settings']['skin_ap'] == 'skin-silver')) {
      echo ' dzsap-sticktobottom-for-skin-silver';
    }


    echo '">';

    echo '<div class="dzs-container">';


    if (isset($vpsettings['settings']['enable_footer_close_button']) == false || ($vpsettings['settings']['enable_footer_close_button'] == 'on')) {
      echo '<div class="sticktobottom-close-con">' . $dzsap->general_assets['svg_stick_to_bottom_close_hide'] . $dzsap->general_assets['svg_stick_to_bottom_close_show'] . ' </div>';

      wp_enqueue_script('footer-player-close-btn', DZSAP_URL_AUDIOPLAYER . 'parts/footer-player/footer-player-icon-hide.js');
    }


    $aux = array('called_from' => 'footer_player');

    $playerArgs = array_merge($playerArgs, $aux);


    echo $dzsap->classView->shortcode_player($playerArgs);


    echo '</div>';
    echo '</section>';


  }

  function handle_widgets_init() {


    include_once DZSAP_BASE_PATH . "widget.php";
    $dzsap_widget = new DZSAP_Tags_Widget();
    $dzsap_widget::register_this_widget();

    add_action('widgets_init', array($dzsap_widget, 'register_this_widget'));
  }

  /**
   * @param $singleItemInstance
   * @param array $pargs
   * @return string pcm data as string
   */
  function generate_pcm($singleItemInstance, $pargs = array()) {

    $dzsap = $this->dzsap;

    $margs = array(
      'generate_only_pcm' => false, // -- generate only the pcm not the markup
      'identifierSource' => '',
      'identifierId' => '',
    );

    if (is_array($pargs) == false) {
      $pargs = array();
    }

    $margs = array_merge($margs, $pargs);

    $fout = '';


    $pcmIdentifierId = $margs['identifierId'];
    $pcmIdentifierSource = $margs['identifierSource'];


    // -- if it's a post... stdObject
    if (isset($singleItemInstance->post_title)) {
      $args = array();
      $pcmIdentifierSource = $dzsap->get_track_source($singleItemInstance->ID, $singleItemInstance->ID, $args);
      $singleItemInstance = (array)$singleItemInstance;

      $singleItemInstance['playerid'] = $singleItemInstance['id'];
    }


    if (isset($singleItemInstance['source']) && $singleItemInstance['source']) {
      $pcmIdentifierSource = $singleItemInstance['source'];
    }
    if (isset($singleItemInstance['playerid']) && $singleItemInstance['playerid']) {
      $pcmIdentifierId = $singleItemInstance['playerid'];
    }
    if (isset($singleItemInstance['wpPlayerPostId']) && $singleItemInstance['wpPlayerPostId']) {
      $pcmIdentifierId = $singleItemInstance['wpPlayerPostId'];
    }

    if ($pcmIdentifierSource == 'fake') {
      return '';
    }


    $lab_option_pcm = '';

    if ($pcmIdentifierId) {
      $lab_option_pcm = 'dzsap_pcm_data_' . DZSZoomSoundsHelper::sanitize_toKey($pcmIdentifierId);
    }
    $stringPcm = get_option($lab_option_pcm);


    if ($this->isPcmInvalid($stringPcm)) {
      $lab_option_pcm = 'dzsap_pcm_data_' . DZSZoomSoundsHelper::sanitize_toKey($pcmIdentifierSource);

      if (DZSZoomSoundsHelper::sanitize_toKey($pcmIdentifierSource)) {
        $stringPcm = get_option($lab_option_pcm);
      }

    }


    if ($this->isPcmInvalid($stringPcm)) {
      if (isset($singleItemInstance['linktomediafile'])) {
        if ($singleItemInstance['linktomediafile']) {
          $lab_option_pcm = 'dzsap_pcm_data_' . $singleItemInstance['linktomediafile'];
          $stringPcm = get_option($lab_option_pcm);
        }
      }
    }


    if (!$this->isPcmInvalid($stringPcm)) {
      $fout .= ' data-pcm=\'' . stripslashes($stringPcm) . '\'';
    }

    if ($margs['generate_only_pcm'] && !$this->isPcmInvalid($stringPcm)) {
      $fout = stripslashes($stringPcm);
    }


    return $fout;
  }

  function isPcmInvalid($pcm) {
    return ($pcm == '' || $pcm == '[]' || strpos($pcm, ',') === false || strpos($pcm, 'null') !== false);
  }


  function handle_wp_head_end() {

    $dzsap = $this->dzsap;

    if ($dzsap->mainoptions['script_use_async'] === 'on' || $dzsap->mainoptions['script_use_defer'] === 'on') {

      add_filter('script_loader_tag', array($this, 'script_use_async'), 10, 3);
    }

  }

  function script_use_async($tag, $handle) {

    $dzsap = $this->dzsap;

    if ($dzsap->mainoptions['script_use_async'] === 'on' && $dzsap->mainoptions['init_javascript_method'] != 'script') {
      if (strpos($handle, DZSAP_ID) !== false) {
        $tag = str_replace('<script', '<script async', $tag);
      }
    }

    if ($dzsap->mainoptions['script_use_defer'] === 'on' && $dzsap->mainoptions['init_javascript_method'] != 'script') {
      if (strpos($handle, DZSAP_ID) !== false) {
        $tag = str_replace('<script', '<script defer', $tag);
      }
    }

    return $tag;
  }

  /**
   * @param $its
   * @param array $argSinglePlayerOptions - playerShortcode and Settings
   * @param array $argPlaylistOptions
   * @return string
   */
  function parse_items($its, $argSinglePlayerOptions = array(), $argPlaylistOptions = array()) {
    return dzsap_view_parseItems($its, $argSinglePlayerOptions, $argPlaylistOptions, $this);
  }


  /**
   * [zoomsounds_player source="pathto.mp3" artistname="" songname=""]
   * @param array $argsShortcodePlayer
   * @param string $content
   * @return string
   */
  function shortcode_player($argsShortcodePlayer = array(), $content = '') {

    return dzsap_view_shortcode_player($argsShortcodePlayer, $content, $this->dzsap);
  }

  /**
   * called in parse_items()
   * @param $playerAttributes
   * @param $argPlaylistOptions
   * @param $argPlayerOptions
   * @param $argPlayerConfig
   * @param $playerid
   * @param $che_post
   * @return string[]
   */
  public function parseItems_determineExtraHtml($playerAttributes, $argPlaylistOptions, $argPlayerOptions, $argPlayerConfig, $playerid, $che_post) {

    $extraHtmlAreas = array(
      'bottom' => '',
      'bottom_left' => '',
      'afterArtist' => '',
      'controlsLeft' => '',
      'controlsRight' => '',
      'afterPlayPause' => '',
      'afterConControls' => '',
    );
    $i_fout = '';


    $playlistOptions = array(
      'enable_downloads_counter' => 'off'
    );
    $playerOptions = array(
      'is_single' => 'off',
      'embedded' => 'off',
    );
    /** @var $playlistAndPlayerOptions array  common attributes */
    $playlistAndPlayerOptions = array(
      'enable_rates' => 'off',
      'enable_views' => 'off',
      'enable_likes' => 'off',
      'enable_download_button' => 'off',
      'menu_right_enable_info_btn' => 'off',
      'js_settings_extrahtml_in_float_right_from_config' => '',
      'js_settings_extrahtml_in_bottom_controls_from_config' => '',
    );
    $playerConfig = array(
      'enable_config_button' => 'off',
      'enable_embed_button' => 'off',
    );

    if (count($playerConfig)) {
      $playerConfig = array_merge($playerConfig, $argPlayerConfig);
    }
    if (count($playerOptions)) {
      $playerOptions = array_merge($playerOptions, $argPlayerOptions);
    }

    if (count($argPlaylistOptions)) {
      $playlistOptions = array_merge($playlistOptions, $argPlaylistOptions);
    }
    $playlistAndPlayerOptions = array_merge($playlistAndPlayerOptions, $playlistOptions);
    $playlistAndPlayerOptions = array_merge($playlistAndPlayerOptions, $playerConfig);
    $playlistAndPlayerOptions = array_merge($playlistAndPlayerOptions, $playerOptions);


    $dzsap = $this->dzsap;


    include_once DZSAP_BASE_PATH . 'inc/php/view-functions/view-determine-html-areas.php';

    $extraHtmlAreas['bottom'] = dzsap_view_determineHtmlAreas_bottom($dzsap, $playerAttributes, $playlistAndPlayerOptions, $playerid);

    $extraHtmlAreas['bottom_left'] = dzsap_view_determineHtmlAreas_bottomLeft($dzsap, $playerAttributes, $playerOptions, $playlistAndPlayerOptions, $playerConfig, $playerid);

    $extraHtmlAreas['controlsLeft'] = dzsap_view_determineHtmlAreas_controlsLeft($playerAttributes);
    $extraHtmlAreas['controlsRight'] = dzsap_view_determineHtmlAreas_controlsRight($dzsap, $playerAttributes, $playerConfig, $che_post, $playlistAndPlayerOptions);
    $extraHtmlAreas['afterPlayPause'] = dzsap_view_determineHtmlAreas_controlsAfterPlayPause($playerConfig);
    $extraHtmlAreas['afterConControls'] = dzsap_view_determineHtmlAreas_controlsAfterConControls($playerConfig, $playerOptions);


    return $extraHtmlAreas;
  }

  /**
   * called in parse_items()
   * @param $singleItemInstance
   * @param $argPlaylistOptions
   * @param $argPlayerOptions
   * @param $argPlayerConfig
   * @param $playerid
   * @param $che_post
   * @return string
   */
  public function generatePlayerExtraHtml($extraHtmlAreas, $singleItemInstance) {

    $i_fout = '';

    foreach ($extraHtmlAreas as $key => $extraHtmlArea) {

      $extraHtmlAreas[$key] = DZSZoomSoundsHelper::sanitize_for_extraHtml($extraHtmlAreas[$key], $singleItemInstance);;
    }
    if ($extraHtmlAreas['controlsLeft']) {
      $i_fout .= $extraHtmlAreas['controlsLeft'];
    }
    if (isset($extraHtmlAreas['controlsRight']) && $extraHtmlAreas['controlsRight']) {
      $i_fout .= $extraHtmlAreas['controlsRight'];
    }
    if (isset($extraHtmlAreas['afterPlayPause']) && $extraHtmlAreas['afterPlayPause']) {
      $i_fout .= $extraHtmlAreas['afterPlayPause'];
    }
    if (isset($extraHtmlAreas['afterConControls']) && $extraHtmlAreas['afterConControls']) {
      $i_fout .= $extraHtmlAreas['afterConControls'];
    }
    if ($extraHtmlAreas['bottom_left']) {

      $i_fout .= '<div hidden class="feed-dzsap feed-dzsap--extra-html ">';
      $i_fout .= $extraHtmlAreas['bottom_left'];
      $i_fout .= '</div><!-- end .extra-html--left-->';
    }
    if ($extraHtmlAreas['bottom']) {

      $i_fout .= '<div hidden class="feed-dzsap feed-dzsap--extra-html" data-playerid="' . $singleItemInstance['playerid'] . '" style="opacity:0;">' . ($extraHtmlAreas['bottom']) . '</div>';
    }

    return $i_fout;
  }

  /**
   * @return array|mixed
   */
  function get_wishlist() {


    $arr_wishlist = array();

    if (get_user_meta(get_current_user_id(), 'dzsap_wishlist', true) && get_user_meta(get_current_user_id(), 'dzsap_wishlist', true) != 'null') {
      try {

        $arr_wishlist = json_decode(get_user_meta(get_current_user_id(), 'dzsap_wishlist', true), true);
      } catch (Exception $e) {

      }
    }

    return $arr_wishlist;
  }


  function shortcode_player_comment_field() {

    $fout = '';

    global $current_user;


    if ($current_user->ID) {
      $fout .= '<div class="zoomsounds-comment-wrapper">
                <div class="zoomsounds-comment-wrapper--avatar divimage" style="background-image: url(https://www.gravatar.com/avatar/?d=identicon);"></div>
                <div class="zoomsounds-comment-wrapper--input-wrap">
                    <input type="text" class="comment_text" placeholder="' . esc_html__("Write a comment") . '"/>
                    <input type="text" class="comment_email" placeholder="' . esc_html__("Your email") . '"/>
                    <!--<input type="text" class="comment_user" placeholder="' . esc_html__("Your display name") . '"/>-->
                </div>

                <div class="zoomsounds-comment-wrapper--buttons">
                    <span class="dzs-button-dzsap comments-btn-cancel">' . esc_html__("Cancel") . '</span>
                    <span class="dzs-button-dzsap comments-btn-submit">' . esc_html__("Submit") . '</span>
                </div>
            </div>';
    } else {
      $fout .= esc_html__("You need to be logged in to comment", DZSAP_ID);
    }


    return $fout;


  }


  function show_curr_plays($pargs = array(), $content = '') {
    global $post;

    $fout = '';


    $str_views = $this->dzsap->mainoptions['str_views'];


    if (isset($pargs['id'])) {
      $post = get_post($pargs['id']);
    }


    if ($post) {
      $str_views = $this->dzsap->ajax_functions->get_metaViews($post->ID);
      $fout = str_replace('{{get_plays}}', $aux, $str_views);
    }
    return $fout;
  }

  /**
   * default wordpress audio [zoomsounds_player source="pathto.mp3"]
   * @param array $atts
   * @param null $content
   * @return string
   */
  function shortcode_audio($atts = array(), $content = null) {


    // --


    $dzsap = $this->dzsap;
    $dzsap->sliders__player_index++;

    $fout = '';


    $dzsap->front_scripts();

    $margs = array(
      'mp3' => '',
      'wav' => '',
      'm4a' => '',
      'config' => 'default',
    );

    if (!is_array($atts)) {
      $atts = array();
    }

    $margs = array_merge($margs, $atts);

    if ($margs['mp3']) {
      $margs['source'] = $margs['mp3'];
    } else {
      if ($margs['wav']) {
        $margs['source'] = $margs['wav'];
      } else {
        if ($margs['m4a']) {
          $margs['source'] = $margs['m4a'];
        }
      }
    }
    $margs['config'] = $dzsap->mainoptions['replace_audio_shortcode'];
    $margs['called_from'] = 'audio_shortcode';


    $audio_attachments = get_posts(array(
      'post_type' => 'attachment',
      'post_mime_type' => 'audio'
    ));


    $pid = 0;
    foreach ($audio_attachments as $lab => $val) {


      if ($val->guid == $margs['source']) {
        $pid = $val->ID;
        break;
      }
    }

    if ($pid) {


      $margs['source'] = $pid;
    }


    if ($dzsap->mainoptions['replace_audio_shortcode_extra_args']) {
      try {
        $arr = json_decode($dzsap->mainoptions['replace_audio_shortcode_extra_args'], true);
        $margs = array_merge($margs, $arr);
      } catch (Exception $e) {
      }
    }

    if ($dzsap->mainoptions['replace_audio_shortcode_play_in_footer'] == 'on') {
      $margs['play_target'] = 'footer';
    }

    $playerid = '';

    $fout .= $dzsap->classView->shortcode_player($margs, $content);


    return $fout;
  }


  /**
   * [playlist ids="2,3,4"]
   * @param $atts
   * @return string
   */
  function shortcode_wpPlaylist($atts) {

    //
    $dzsap = $this->dzsap;

    global $current_user;
    $fout = '';
    $iout = ''; //items parse

    $defaultPlaylistOptions = array(
      'ids' => '1'
    , 'embedded_in_zoombox' => 'off'
    , 'embedded' => 'off'
    , 'db' => 'main'
    );

    if ($atts == '') {
      $atts = array();
    }

    $defaultPlaylistOptions = array_merge($defaultPlaylistOptions, $atts);


    $po_array = explode(",", $defaultPlaylistOptions['ids']);

    $fout .= '[zoomsounds id="playlist_gallery" embedded="' . $defaultPlaylistOptions['embedded'] . '" for_embed_ids="' . $defaultPlaylistOptions['ids'] . '"]';


    // -- setting up the db ( deprecated )
    $currDb = '';
    if (isset($defaultPlaylistOptions['db']) && $defaultPlaylistOptions['db'] != '') {
      $dzsap->currDb = $defaultPlaylistOptions['db'];
      $currDb = $dzsap->currDb;
    }
    $dzsap->dbs = get_option(DZSAP_DBNAME_LEGACY_DBS);

    $dbname_mainitems = DZSAP_DBNAME_MAINITEMS;
    if ($currDb != 'main' && $currDb != '') {
      $dbname_mainitems .= '-' . $currDb;
      $dzsap->mainitems = get_option($dbname_mainitems);
    }
    // -- setting up the db END


    $dzsap->front_scripts();


    $dzsap->sliders_index++;


    $i = 0;
    $k = 0;
    $id = DZSAP_VIEW_SHOWCASE_PLAYLIST_ID;
    if (isset($defaultPlaylistOptions['id'])) {
      $id = $defaultPlaylistOptions['id'];
    }


    $term_meta = array();
    $its = array(
      'settings' => array(),
    );
    $selected_term_id = '';


    $args = array(
      'id' => $id,
      'force_ids' => $defaultPlaylistOptions['ids'],
      'called_from' => 'shortcode_playlist',
    );
    $this->get_its_items($its, $args);

    if ($dzsap->mainoptions['playlists_mode'] == 'normal') {
      $tax = DZSAP_TAXONOMY_NAME_SLIDERS;
      $reference_term = get_term_by('slug', $id, $tax);
      if ($reference_term) {

        $selected_term_id = $reference_term->term_id;
        $term_meta = get_option("taxonomy_$selected_term_id");
      }
    }


    $this->get_its_settings($its, $defaultPlaylistOptions, $term_meta, $selected_term_id);


    $enable_likes = 'off';
    $enable_views = 'off';
    $enable_downloads_counter = 'off';

    if ($its) {
      $lab = 'enable_views';
      if (isset($its['settings'][$lab]) && $its['settings'][$lab]) {
        $enable_views = $its['settings'][$lab];
      }
      $lab = 'enable_likes';
      if (isset($its['settings'][$lab]) && $its['settings'][$lab]) {
        $enable_likes = $its['settings'][$lab];
      }
      $lab = 'enable_downloads_counter';
      if (isset($its['settings'][$lab]) && $its['settings'][$lab]) {
        $enable_downloads_counter = $its['settings'][$lab];
      }
    }


    foreach ($po_array as $po_id) {


      if (is_numeric($po_id)) {

        $po = get_post($po_id);
        $title = $po->post_title;
        $title = str_replace(array('"', '[', ']'), '&quot;', $title);
        $desc = $po->post_content;
        $desc = str_replace(array('"', '[', ']'), '&quot;', $desc);
        $fout .= '[zoomsounds_player source="' . $po->guid . '" config="playlist_player" playerid="' . $po_id . '" thumb="" autoplay="on" cueMedia="on" enable_likes="' . $enable_likes . '" enable_views="' . $enable_views . '"  enable_downloads_counter="' . $enable_downloads_counter . '" songname="' . $title . '" artistname="' . $desc . '" init_player="off"]';
      } else {

        $fout .= '[zoomsounds_player source="' . $po_id . '" config="playlist_player" playerid="' . $po_id . '" thumb="" autoplay="off" cueMedia="on" enable_likes="' . $enable_likes . '" enable_views="' . $enable_views . '"  enable_downloads_counter="' . $enable_downloads_counter . '"  init_player="off"]';
      }

    }
    $fout .= '[/zoomsounds]';


    $fout = do_shortcode($fout);


    return $fout;
  }

  function playlist_initialSetup(&$its) {


    // -- embed

    if (isset($its['settings']['gallery_embed_type'])) {
      if ($its['settings']['gallery_embed_type'] === 'on-no-embed') {

      }
      if ($its['settings']['gallery_embed_type'] === 'on-with-embed') {


        $its['playerConfigSettings']['enable_embed_button'] = 'in_lightbox';
      }
    }

  }


  /** [zoomsounds id="theid"]
   * @param array $atts
   * @param null $content
   * @return string|void
   */
  public function shortcode_playlist_main($atts = array(), $content = null) {

    global $current_user;
    $fout = '';
    $iout = ''; //items parse

    $shortcodeOptions = array(
      'playlist_id' => 'default'
    , 'db' => ''
    , 'category' => ''
    , 'extra_classes' => ''
    , 'fullscreen' => 'off'
    , 'settings_separation_mode' => 'normal'  // === normal ( no pagination ) or pages or scroll or button
    , 'settings_separation_pages_number' => '5'//=== the number of items per 'page'
    , 'settings_separation_paged' => '0'//=== the page number
    , 'return_onlyitems' => 'off' // ==return only the items ( used by pagination )
    , 'embedded' => 'off'
    , 'divinsteadofscript' => 'off'
    , 'width' => '-1'
    , 'height' => '-1'
    , 'embedded_in_zoombox' => 'off'
    , 'for_embed_ids' => ''
    , 'is_single' => 'off'
    , 'overwrite_only_its' => ''
    , 'called_from' => 'default'
    , 'play_target' => 'default'
    );

    if ($atts == '') {
      $atts = array();
    }

    $shortcodeOptions = array_merge($shortcodeOptions, $atts);

    if ((!$shortcodeOptions['playlist_id'] || $shortcodeOptions['playlist_id'] == 'default') && isset($shortcodeOptions['id']) && $shortcodeOptions['id']) {
      $shortcodeOptions['playlist_id'] = $shortcodeOptions['id'];
    }

    // -- the id will get replaced so we can store the original id / slug
    $shortcodeOptions['original_id'] = $shortcodeOptions['playlist_id'];


    $dzsap = $this->dzsap;
    // -- setting up the db
    $currDb = '';
    if (isset($shortcodeOptions['db']) && $shortcodeOptions['db'] != '') {
      $dzsap->currDb = $shortcodeOptions['db'];
      $currDb = $dzsap->currDb;
    }

    $dzsap->dbs = get_option(DZSAP_DBNAME_LEGACY_DBS);
    $dzsap->db_read_mainitems();


    // -- setting up the db END


    $dzsap->front_scripts();


    $dzsap->sliders_index++;


    $its = array(
      'settings' => array(),
    );
    $selected_term_id = '';

    $term_meta = array();


    if ($shortcodeOptions['for_embed_ids']) {
      $shortcodeOptions['force_ids'] = $shortcodeOptions['for_embed_ids'];
    }
    $this->get_its_items($its, $shortcodeOptions);

    if ($dzsap->mainoptions['playlists_mode'] == 'normal') {
      $tax = DZSAP_TAXONOMY_NAME_SLIDERS;


      $reference_term = get_term_by('slug', $shortcodeOptions['playlist_id'], $tax);

      if ($reference_term) {

      } else {
        // -- reference term does not exist..

        $directores = get_terms(DZSAP_TAXONOMY_NAME_SLIDERS);

        $playerOptionsArgs = $shortcodeOptions;
        $playerOptionsArgs['playlist_id'] = $directores[0]->slug;
        if ($shortcodeOptions['called_from'] != 'redo') {
          $playerOptionsArgs['called_from'] = 'redo';
          return $this->shortcode_playlist_main($playerOptionsArgs);
        }
        return '';
      }


      $selected_term_id = $reference_term->term_id;

      $term_meta = get_option("taxonomy_$selected_term_id");
    }


    if ($shortcodeOptions['overwrite_only_its'] && is_array($shortcodeOptions['overwrite_only_its'])) {


      $new_its = array_merge(array(), $its);
      foreach ($its as $lab => $val) {
        if ($lab !== 'settings') {
          unset($new_its[$lab]);
        }
      }
      $new_its = array_merge($new_its, $shortcodeOptions['overwrite_only_its']);

      $its = $new_its;
    }


    $this->get_its_settings($its, $shortcodeOptions, $term_meta, $selected_term_id);
    // -- after settings


    $i = 0;

    $vpsettings = DZSZoomSoundsHelper::getVpSettings($its['settings']['vpconfig']);
    $sanitizedApConfigId = DZSZoomSoundsHelper::sanitizeToValidObjectLabel($vpsettings['settings']['id']);


    unset($vpsettings['settings']['id']);
    $its['settings'] = array_merge($its['settings'], $vpsettings['settings']);
    $its['playerConfigSettings'] = ($vpsettings['settings']);
    $its['playerConfigSettings']['id'] = $sanitizedApConfigId;


    $this->playlist_initialSetup($its);


    // -- some sanitizing
    $tw = $its['settings']['width'];
    $th = $its['settings']['height'];

    if ($shortcodeOptions['width'] != '-1') {
      $tw = $shortcodeOptions['width'];
    }
    if ($shortcodeOptions['height'] != '-1') {
      $th = $shortcodeOptions['height'];
    }
    $str_tw = '';
    $str_th = '';


    if ($tw != '') {
      $str_tw .= 'width: ';
      $str_tw .= DZSZoomSoundsHelper::sanitizeToPx($tw);
      $str_tw .= ';';
    }


    if ($th != '') {
      $str_th .= 'height: ';
      $str_tw .= DZSZoomSoundsHelper::sanitizeToPx($th);
      $str_th .= ';';
    }


    $skinGallery = 'skin-wave';

    if (isset($its['settings']['galleryskin'])) {
      $skinGallery = $its['settings']['galleryskin'];
    }


    $sanitizedApConfigId = DZSZoomSoundsHelper::sanitizeToValidObjectLabel($its['playerConfigSettings']['id']);

    $newSettings = array();
    if (isset($its['settings']['autoplaynext'])) {
      $newSettings['autoplay_next'] = $its['settings']['autoplaynext'];
    }
    $newSettings['embedded'] = $shortcodeOptions['embedded'];
    $newSettings['settings_ap'] = $sanitizedApConfigId;


    $videoPlaylistSettingsMerged = array_merge($its['settings'], $newSettings);


    if (isset($videoPlaylistSettingsMerged['settings_mode_showall_show_number'])) {
      if ($videoPlaylistSettingsMerged['settings_mode_showall_show_number'] && $videoPlaylistSettingsMerged['settings_mode_showall_show_number'] == 'on') {
        wp_enqueue_script('isotope', DZSAP_BASE_URL . 'libs/isotope/isotope.js');
      }
    }


    if (isset($its['settings']['settings_enable_linking'])) {
      if (isset($videoPlaylistSettingsMerged) === false || $videoPlaylistSettingsMerged === '') {
        $videoPlaylistSettingsMerged['enable_linking'] = $its['settings']['settings_enable_linking'];
      }
    }

    if (isset($_GET['fromsharer']) && $_GET['fromsharer'] == 'on') {
      if (isset($_GET['audiogallery_startitem_ag1']) && $_GET['audiogallery_startitem_ag1'] !== '') {
        $videoPlaylistSettingsMerged['design_menu_state'] = 'closed';
      }
    }


    // -- playlist
    if (isset($its['playerConfigSettings']['colorhighlight']) && $its['playerConfigSettings']['colorhighlight']) {

      $audioGalleryCustomColorsCss = DZSZoomSoundsHelper::generateCssPlayerCustomColors(array(
        'skin_ap' => $its['playerConfigSettings']['skin_ap'],
        'selector' => '.audiogallery#ag' . $dzsap->sliders_index . ' .audioplayer',
        'colorhighlight' => $its['playerConfigSettings']['colorhighlight'],
      ));
      wp_register_style('dzsap-hook-gallery-custom-styles', false);
      wp_enqueue_style('dzsap-hook-gallery-custom-styles');
      wp_add_inline_style('dzsap-hook-gallery-custom-styles', $audioGalleryCustomColorsCss);
    }


    if (isset($its['settings']['enable_bg_wrapper']) && $its['settings']['enable_bg_wrapper'] == 'on') {
      $fout .= '<div class="ap-wrapper">
<div class="the-bg"></div>';
    }

    // -- main gallery div
    $fout .= '<div   id="ag' . $dzsap->sliders_index . '" class="audiogallery ag_slug_' . $shortcodeOptions['original_id'] . ' auto-init ' . $skinGallery . ' id_' . $its['settings']['id'] . ' ';


    if ($shortcodeOptions['extra_classes']) {
      $fout .= ' ' . $shortcodeOptions['extra_classes'];
    }


    $fout .= '" style="background-color:' . $its['settings']['bgcolor'] . ';' . $str_tw . '' . $str_th . '" data-options=\'' . json_encode(dzsap_generate_javascript_setting_for_playlist($videoPlaylistSettingsMerged)['foutArr']) . '\'>';


    if ($content) {
      $iout .= do_shortcode($content);
    } else {

      $playerOptionsArgs = array(
        'called_from' => 'gallery',
        'gallery_skin' => $skinGallery,
      );
      $playerOptionsArgs = array_merge($vpsettings['settings'], $playerOptionsArgs);
      $playerOptionsArgs = array_merge($playerOptionsArgs, $shortcodeOptions);


      $playerOptionsArgs['called_from'] = 'gallery';


      if ($its['playerConfigSettings']['enable_embed_button'] === 'in_lightbox' || $its['playerConfigSettings']['enable_embed_button'] === 'in_extra_html') {


        $embed_code = DZSZoomSoundsHelper::generate_embed_code(array(
          'call_from' => 'shortcode_player',
          'playlistId' => $shortcodeOptions['playlist_id'],
        ), false);
        $playerOptionsArgs['feed_embed_code'] = $embed_code;
      }

      $videoPlaylistOptionsForParseItems = array_merge($videoPlaylistSettingsMerged, $shortcodeOptions);

      $iout .= dzsap_view_parseItems($its, $playerOptionsArgs, $videoPlaylistOptionsForParseItems, $this);

    }

    $fout .= '<div class="items">';
    $fout .= $iout;


    $fout .= '</div>';
    $fout .= '</div>'; // -- end .audiogallery


    if (isset($its['settings']['enable_bg_wrapper']) && $its['settings']['enable_bg_wrapper'] == 'on') {
      $fout .= '</div>';
    }


    $playerSettingsFromGallery = array();


    if (isset($its['playerConfigSettings']['enable_embed_button']) && ($its['playerConfigSettings']['enable_embed_button'] != 'off')) {

      $deprecatedStringDb = '';
      if ($dzsap->currDb != '') {
        $deprecatedStringDb = '&db=' . $dzsap->currDb . '';
      }
      if ($shortcodeOptions['playlist_id'] == DZSAP_VIEW_SHOWCASE_PLAYLIST_ID) {
        $str = '<iframe src="' . site_url() . '?action=zoomsounds-embedtype=playlist&ids=' . $shortcodeOptions['for_embed_ids'] . '' . $deprecatedStringDb . '" width="100%" height="' . $its['settings']['height'] . '" style="overflow:hidden; transition: height 0.5s ease-out;" scrolling="no" frameborder="0"></iframe>';
      } else {
        $str = '<iframe src="' . site_url() . '?action=zoomsounds-embed&type=gallery&id=' . $its['settings']['id'] . '' . $deprecatedStringDb . '" width="100%" height="' . $its['settings']['height'] . '" style="overflow:hidden; transition: height 0.5s ease-out;" scrolling="no" frameborder="0"></iframe>';
      }


      $str = str_replace('"', "'", $str);
      $playerSettingsFromGallery['embed_code'] = htmlentities($str, ENT_QUOTES);
    }


    if (isset($its['settings']['enable_embed_button']) && ($its['settings']['enable_embed_button'] == 'on' || $vpsettings['settings']['enable_embed_button'] == 'in_player_controls')) {
      $playerSettingsFromGallery['enable_embed_button'] = 'on';
    }


    $dzsap->mainoptions['color_waveformbg'] = str_replace('#', '', $dzsap->mainoptions['color_waveformbg']);
    if ($dzsap->mainoptions['skinwave_wave_mode'] == 'canvas') {

      $playerSettingsFromGallery['pcm_data_try_to_generate'] = $dzsap->mainoptions['pcm_data_try_to_generate'];
      $playerSettingsFromGallery['pcm_notice'] = $dzsap->mainoptions['pcm_notice'];
      $playerSettingsFromGallery['notice_no_media'] = $dzsap->mainoptions['notice_no_media'];

    }


    $audioplayerSettingsMerged = array_merge($its['playerConfigSettings'], $playerSettingsFromGallery);

    $this->audioPlayerConfigsAdd($sanitizedApConfigId, dzsap_generate_javascript_setting_for_player($audioplayerSettingsMerged)['foutArr']);

    $url = DZSAP_URL_FONTAWESOME_EXTERNAL;
    if ($dzsap->mainoptions['fontawesome_load_local'] == 'on') {
      $url = DZSAP_BASE_URL . 'libs/fontawesome/font-awesome.min.css';
    }


    wp_enqueue_style('fontawesome', $url);


    // -- this fixes some & being converted to &#038;
    remove_filter('the_content', 'wptexturize');

    if ($shortcodeOptions['return_onlyitems'] != 'on') {
      return $fout;
    } else {
      return $iout;
    }


  }

  /**
   * @param string $apConfig
   * @param array $apConfigSettings
   */
  function audioPlayerConfigsAdd($apConfig, $apConfigSettings){

    $sanitizedApConfigId = DZSZoomSoundsHelper::sanitizeToValidObjectLabel($apConfig);
    $this->audioPlayerConfigs[$sanitizedApConfigId] = $apConfigSettings;

  }


  function get_its_items(&$its, $shortcodeOptions) {
    global $dzsap;
    // -- from @margs we need id

    if ($dzsap->mainoptions['playlists_mode'] == 'normal') {

      // -- try to get from reference term
      $tax = DZSAP_TAXONOMY_NAME_SLIDERS;


      $reference_term = get_term_by('slug', $shortcodeOptions['playlist_id'], $tax);


      if ($reference_term) {


      } else {
        // -- reference term does not exist..

        $directores = get_terms(DZSAP_TAXONOMY_NAME_SLIDERS);

        $args = $shortcodeOptions;
        $args['id'] = $directores[0]->slug;
        if ($shortcodeOptions['called_from'] != 'redo') {
          $args['called_from'] = 'redo';
          return $this->shortcode_playlist_main($args);
        }
        return '';
      }

      $selected_term_id = $reference_term->term_id;

      $term_meta = get_option("taxonomy_$selected_term_id");


      // -- main order
      if ($selected_term_id) {

        $args = array(
          'post_type' => 'dzsap_items',
          'numberposts' => -1,
          'posts_per_page' => -1,

          'orderby' => 'meta_value_num',
          'order' => 'ASC',

          'tax_query' => array(
            array(
              'taxonomy' => $tax,
              'field' => 'id',
              'terms' => $selected_term_id // Where term_id of Term 1 is "1".
            )
          ),
        );


        if (isset($term_meta['orderby'])) {
          if ($term_meta['orderby'] == 'rand') {
            $args['orderby'] = $term_meta['orderby'];
          }
          if ($term_meta['orderby'] == 'custom') {
            $args['meta_query'] = array(
              'relation' => 'OR',
              array(
                'key' => 'dzsap_meta_order_' . $selected_term_id,
                'compare' => 'EXISTS',
              ),
              array(
                'key' => 'dzsap_meta_order_' . $selected_term_id,
                'compare' => 'NOT EXISTS'
              )
            );
          }
          if ($term_meta['orderby'] == 'ratings_score') {
            $args['orderby'] = 'meta_value_num';

            $key = '_dzsap_rate_index';
            $args['meta_query'] = array(
              'relation' => 'OR',
              array(
                'key' => $key,
                'compare' => 'EXISTS',
              ),
              array(
                'key' => $key,
                'compare' => 'NOT EXISTS'
              )
            );
            $args['meta_type'] = 'NUMERIC';
            $args['order'] = 'DESC';

          }
          if ($term_meta['orderby'] == 'ratings_number') {
            $args['orderby'] = 'meta_value_num';

            $key = '_dzsap_rate_nr';
            $args['meta_query'] = array(
              'relation' => 'OR',
              array(
                'key' => $key,
                'compare' => 'EXISTS',
              ),
              array(
                'key' => $key,
                'compare' => 'NOT EXISTS'
              )
            );
            $args['meta_type'] = 'NUMERIC';
            $args['order'] = 'DESC';
          }
          if ($term_meta['orderby'] == 'alphabetical_ASC') {
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
          }
          if ($term_meta['orderby'] == 'alphabetical_DESC') {
            $args['orderby'] = 'title';
            $args['order'] = 'DESC';
          }
        }

        if (isset($shortcodeOptions['force_ids']) && $shortcodeOptions['force_ids']) {

          $args['post_type'] = 'any';
          $args['post_status'] = 'any';
          $args['post__in'] = explode(',', $shortcodeOptions['force_ids']);
          unset($args['tax_query']);
          unset($args['meta_query']);
        }
        $my_query = new WP_Query($args);


        foreach ($my_query->posts as $po) {


          $por = DZSZoomSoundsHelper::sanitize_to_gallery_item($po);

          array_push($its, $por);

        }
      }
    } else {
      // -- legacy mode

      if (isset($shortcodeOptions['playlist_id'])) {
        $id = $shortcodeOptions['playlist_id'];
      }

      for ($i = 0; $i < count($dzsap->mainitems); $i++) {

        if (isset($dzsap->mainitems[$i]) && isset($dzsap->mainitems[$i]['settings'])) {

          if ((isset($id)) && ($id == $dzsap->mainitems[$i]['settings']['id'])) {
            $k = $i;
          }
        }
      }
      $its = $dzsap->mainitems[$k];
    }


  }


  function get_its_settings(&$its, $margs, $term_meta, $selected_term_id) {
    global $dzsap;

    $its_settings_default = array(
      'galleryskin' => 'skin-wave',
      'vpconfig' => 'default',
      'bgcolor' => 'transparent',
      'width' => '',
      'height' => '',
      'autoplay' => '',
      'autoplaynext' => 'on',
      'autoplay_next' => '',
      'menuposition' => 'bottom',
    );
    if ($dzsap->mainoptions['playlists_mode'] == 'normal') {
      $its_settings_default['id'] = $selected_term_id;
    }

    if (isset($its['settings']) == false) {
      $its['settings'] = array();
    }

    $its['settings'] = array_merge($its_settings_default, $its['settings']);


    if ($dzsap->mainoptions['playlists_mode'] == 'normal') {
      if (is_array($term_meta)) {

        foreach ($term_meta as $lab => $val) {
          if ($lab == 'autoplay_next') {

            $lab = 'autoplaynext';
          }
          $its['settings'][$lab] = $val;

        }
      }
    }
  }

}
<?php


/**
 * [zoomsounds_player source="pathto.mp3" artistname="" songname=""]
 * @param array $argsShortcodePlayer
 * @param string $content
 * @param DZSAudioPlayer $dzsap
 * @return string
 */
function dzsap_view_shortcode_player($argsShortcodePlayer = array(), $content = '', $dzsap = null) {

  global $post;


  $fout = '';

  $dzsap->sliders__player_index++;
  $player_idx = $dzsap->sliders__player_index;

  $dzsap->front_scripts();

  $shortcodePlayerAtts = array_merge(DZSAP_VIEW_DEFAULT_SHORTCODE_PLAYER_ATTS, array(
    'player_index' => $player_idx,
  ));

  $default_margs = array_merge(array(), $shortcodePlayerAtts);

  if (isset($argsShortcodePlayer) && is_array($argsShortcodePlayer)) {
    $shortcodePlayerAtts = array_merge($shortcodePlayerAtts, $argsShortcodePlayer);
  }


  if ($content) {
    $shortcodePlayerAtts['content_inner'] = $content;
  }


  $shortcodePlayerAtts['source'] = DZSZoomSoundsHelper::player_parseItems_getSource($shortcodePlayerAtts['source'], $shortcodePlayerAtts);

  if (isset($shortcodePlayerAtts['the_post_title']) && $shortcodePlayerAtts['the_post_title'] && (!($shortcodePlayerAtts['songname']))) {
    $shortcodePlayerAtts['songname'] = $shortcodePlayerAtts['the_post_title'];
  }


  $original_player_margs = array_merge($shortcodePlayerAtts, array());

  $original_source = $shortcodePlayerAtts['source'];


  $embed_margs = array();


  // -- embed margs
  foreach ($shortcodePlayerAtts as $lab => $arg) {
    if (isset($shortcodePlayerAtts[$lab])) {
      if (isset($default_margs[$lab]) == false || $shortcodePlayerAtts[$lab] !== $default_margs[$lab]) {
        $embed_margs[$lab] = $shortcodePlayerAtts[$lab];
      }
    }
  }
  if (isset($embed_margs['cat_feed_data'])) {
    unset($embed_margs['cat_feed_data']);
  }


  $playerid = '';


  $player_post = null;


  if ($shortcodePlayerAtts['play_target'] == 'footer') {
    if (isset($shortcodePlayerAtts['faketarget']) && $shortcodePlayerAtts['faketarget']) {

    } else {
      $shortcodePlayerAtts['faketarget'] = '.' . DZSAP_VIEW_STICKY_PLAYER_ID;
    }
  }


  $po = null;


  if (is_int(intval($shortcodePlayerAtts['source']))) {
    $po = get_post($shortcodePlayerAtts['source']);

    if ($po) {
      if ($po->post_type == DZSAP_REGISTER_POST_TYPE_NAME) {
        $shortcodePlayerAtts['post_content'] = $po->post_content;

      }
    }

  }


  if ($shortcodePlayerAtts['source']) {
    if ($dzsap->get_track_source($shortcodePlayerAtts['source'], $playerid, $shortcodePlayerAtts) != $shortcodePlayerAtts['source']) {

      if (is_numeric($shortcodePlayerAtts['source'])) {
        if (isset($shortcodePlayerAtts['playerid']) == false || $shortcodePlayerAtts['playerid'] == '') {
          $shortcodePlayerAtts['playerid'] = $shortcodePlayerAtts['source'];
        }
      }
      $shortcodePlayerAtts['source'] = $dzsap->get_track_source($shortcodePlayerAtts['source'], $playerid, $shortcodePlayerAtts);
    }
  }


  $vpsettings = DZSZoomSoundsHelper::getVpSettings($shortcodePlayerAtts['config'], $shortcodePlayerAtts);


  if (isset($shortcodePlayerAtts['embedded']) && $shortcodePlayerAtts['embedded'] == 'on') {

    $vpsettings['enable_embed_button'] = 'off';


    $vpsettings['menu_right_enable_multishare'] = 'off';
  }
  if (isset($shortcodePlayerAtts['playerid']) && $shortcodePlayerAtts['playerid']) {

  } else {


    if (is_numeric($shortcodePlayerAtts['source'])) {
      $shortcodePlayerAtts['playerid'] = $shortcodePlayerAtts['source'];
    } else {


      $shortcodePlayerAtts['playerid'] = DZSZoomSoundsHelper::encode_to_number($shortcodePlayerAtts['source']);
    }


    if ($shortcodePlayerAtts['dzsap_meta_source_attachment_id'] && is_numeric($shortcodePlayerAtts['dzsap_meta_source_attachment_id'])) {


      $shortcodePlayerAtts['playerid'] = DZSZoomsoundsHelper::sanitizeForShortcodeAttr($shortcodePlayerAtts['dzsap_meta_source_attachment_id']);
    }

  }


  if ($vpsettings['settings']['skin_ap'] == 'null') {
    $vpsettings['settings']['skin_ap'] = 'skin-wave';
  }


  $its = array(0 => $shortcodePlayerAtts, 'settings' => array());

  $its['settings'] = array_merge($its['settings'], $vpsettings['settings']);
  $its['playerConfigSettings'] = $vpsettings['settings'];


  if ($shortcodePlayerAtts['enable_views'] == 'on') {
    $its['settings']['enable_views'] = 'on';
  }


  $settingsForParsePlayer = array_merge($vpsettings['settings'], $shortcodePlayerAtts);


  // -- lets overwrite some settings that we forced from shortcode args


  if (isset($argsShortcodePlayer['enable_embed_button']) && $argsShortcodePlayer['enable_embed_button']) {

    $settingsForParsePlayer['enable_embed_button'] = $argsShortcodePlayer['enable_embed_button'];
  }


  if (isset($settingsForParsePlayer['cat_feed_data'])) {

    include_once DZSAP_BASE_PATH."class_parts/powerpress_cat_feed_data.php";
  }


  $settingsForParsePlayer['extra_html'] = DZSZoomsoundsHelper::sanitizeForShortcodeAttr($settingsForParsePlayer['extra_html'], $settingsForParsePlayer);

  $encodedMargs = base64_encode(json_encode($embed_margs));


  $embed_code = DZSZoomSoundsHelper::generate_embed_code(array(
    'call_from' => 'shortcode_player',
    'enc_margs' => $encodedMargs,
  ));


  $settingsForParsePlayer['embed_code'] = $embed_code;


  if ($settingsForParsePlayer['itunes_link']) {

    if (isset($its[0]['extra_html']) == false) {
      $its[0]['extra_html'] = '';
    }

    $its[0]['extra_html'] .= '  <a rel="nofollow" href="' . $settingsForParsePlayer['itunes_link'] . '" target="_blank" class=" btn-zoomsounds btn-itunes "><span class="the-icon"><i class="fa fa-apple"></i></span><span class="the-label ">iTunes</span></a>';
  }


  $settingsForParsePlayer['the_content'] = $content;

  if ($settingsForParsePlayer['songname'] && $settingsForParsePlayer['songname'] != 'default') {

    if (isset($its[0]['menu_songname']) == false || !($its[0]['menu_songname'] && $its[0]['menu_songname'] != 'default')) {

      $its[0]['menu_songname'] = $settingsForParsePlayer['songname'];
    }
  }
  if ($settingsForParsePlayer['artistname'] && $settingsForParsePlayer['artistname'] != 'default') {

    if (isset($its[0]['menu_artistname']) == false || !($its[0]['menu_artistname'] && $its[0]['menu_artistname'] != 'default')) {

      $its[0]['menu_artistname'] = $settingsForParsePlayer['artistname'];
    }
  }


  $lab = 'title_is_permalink';
  if (isset($settingsForParsePlayer[$lab]) && $settingsForParsePlayer[$lab]) {
    $its[0][$lab] = $settingsForParsePlayer[$lab];
  }
  if (isset($settingsForParsePlayer['product_id']) && $settingsForParsePlayer['product_id']) {

    $pid = $settingsForParsePlayer['product_id'];

    if (get_post_meta($pid, 'dzsap_meta_replace_artistname', true)) {

      $its[0]['artistname'] = get_post_meta($pid, 'dzsap_meta_replace_artistname', true);
    }
  }


  $dzsapSettingsArrayString = dzsap_generate_audioplayer_settings(array(
    'call_from' => 'shortcode_player',
    'enc_margs' => $encodedMargs,
    'extra_init_settings' => $settingsForParsePlayer['extra_init_settings'],
  ), $vpsettings, $its, $settingsForParsePlayer);

  if ($settingsForParsePlayer['openinzoombox'] != 'on') {


    if ($settingsForParsePlayer['init_player'] == 'on') {
      if ($dzsap->mainoptions['init_javascript_method'] != 'script') {
        $settingsForParsePlayer['auto_init_player'] = 'on';
      }
      $settingsForParsePlayer['auto_init_player_options'] = $dzsapSettingsArrayString;
    }


    if ($encodedMargs) {

      $embed_code = DZSZoomSoundsHelper::generate_embed_code(array(
        'call_from' => 'shortcode_player',
        'enc_margs' => $encodedMargs,
      ));
      $settingsForParsePlayer['feed_embed_code'] = $embed_code;
    }


    // -- player
    $fout .= dzsap_view_parseItems($its, $settingsForParsePlayer, array(), $dzsap->classView);

  }

  $player_id = $settingsForParsePlayer['playerid'];

  // -- normal mode
  if ($shortcodePlayerAtts['init_player'] == 'on') {
    DZSZoomSoundsHelper::enqueueMainScrips();
  }


  $extra_buttons_html = '';

  if ($dzsap->mainoptions['analytics_enable'] == 'on') {
    if (current_user_can('manage_options')) {
      if ($shortcodePlayerAtts['called_from'] != 'footer_player') {

        // -- the stats

        $extra_buttons_html .= '<span class="btn-zoomsounds stats-btn" data-playerid="' . $shortcodePlayerAtts['playerid'] . '"  data-sanitized_source="' . DZSZoomSoundsHelper::sanitize_toKey($shortcodePlayerAtts['source']) . '" data-url="' . dzs_curr_url() . '" ><span class="the-icon"><i class="fa fa-tachometer" aria-hidden="true"></i></span><span class="btn-label">' . esc_html__('Stats', DZSAP_ID) . '</span></span>';


        // -- some portal delete button : todo: complete


      }


      DZSZoomSoundsHelper::enqueueAudioPlayerShowcase();
      wp_enqueue_style('fontawesome', DZSAP_URL_FONTAWESOME_EXTERNAL);

    }


  }
  if ($shortcodePlayerAtts['called_from'] != 'footer_player') {

    if (DZSZoomSoundsHelper::isTheTrackHasFromCurrentUser($shortcodePlayerAtts['playerid'])) {

      $extra_buttons_html .= DZSZoomSoundsHelper::generateExtraButtonsForPlayerDeleteEdit($shortcodePlayerAtts['playerid']);

    }
  }

  if ($extra_buttons_html && $shortcodePlayerAtts['called_from'] != 'playlist_showcase') {
    if ($dzsap->mainoptions['enable_aux_buttons'] === 'on') {
      $fout .= '<div class="extra-btns-con">';
      $fout .= $extra_buttons_html;
      $fout .= '</div>';
    }
  }


  // -- this fixes some & being converted to &#038;
  remove_filter('the_content', 'wptexturize');

  DZSZoomSoundsHelper::enqueueMainScrips();
  return $fout;
}

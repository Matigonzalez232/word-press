export function player_constructArtistAndSongCon(margs) {

  var selfClass = this;

  if (selfClass.cthis.find('.meta-artist').length === 0) {
    if (selfClass.cthis.find('.feed-artist-name').length || selfClass.cthis.find('.feed-song-name').length) {
      let structHtmlMeta = '<span class="meta-artist player-artistAndSong">';
      if (selfClass.cthis.find('.feed-artist-name').length) {
        structHtmlMeta += '<span class="the-artist">' + selfClass.cthis.find('.feed-artist-name').eq(0).html() + '</span>';
      }
      if (selfClass.cthis.find('.feed-song-name').length) {
        structHtmlMeta += '<span class="the-name player-meta--songname">' + selfClass.cthis.find('.feed-song-name').eq(0).html() + '</span>';
      }
      structHtmlMeta += '</span>';
      selfClass.cthis.append(structHtmlMeta);
    }
  }

  if (selfClass.cthis.attr("data-type") === 'fake') {
    if (selfClass.cthis.find('.meta-artist').length === 0) {
      selfClass.cthis.append('<span class="meta-artist"><span class="the-artist"></span><span class="the-name"></span></span>')
    }
  }

  if (!selfClass._metaArtistCon || margs.call_from === 'reconstruct') {

    if (selfClass.cthis.children('.meta-artist').length > 0) {
      if (selfClass.cthis.hasClass('skin-wave-mode-alternate')) {
        if (selfClass._conControls.children().last().hasClass('clear')) {
          selfClass._conControls.children().last().remove();
        }
        selfClass._conControls.append(selfClass.cthis.children('.meta-artist'));
      } else {
        if (selfClass._audioplayerInner) {
          selfClass._audioplayerInner.append(selfClass.cthis.children('.meta-artist'));
        }
      }
    }


    selfClass._audioplayerInner.find('.meta-artist').eq(0).wrap('<div class="meta-artist-con"></div>');


    selfClass._metaArtistCon = selfClass._audioplayerInner.find('.meta-artist-con').eq(0);


    const o = selfClass.initOptions;


    if (selfClass._apControls.find('.ap-controls-right').length > 0) {
      selfClass._apControlsRight = selfClass.cthis.find('.ap-controls-right').eq(0);
    }
    if (selfClass._apControls.find('.ap-controls-left').length > 0) {
      selfClass._apControlsLeft = selfClass._apControls.find('.ap-controls-left').eq(0);
    }


    if (o.design_skin === 'skin-pro') {
      selfClass._apControlsRight = selfClass.cthis.find('.con-controls--right').eq(0)
    }

    if (o.design_skin === 'skin-wave') {


      if (selfClass.cthis.find('.dzsap-repeat-button').length) {
        selfClass.cthis.find('.dzsap-repeat-button').after(selfClass._metaArtistCon);
      } else {


        if (selfClass.cthis.find('.dzsap-loop-button').length && selfClass.cthis.find('.dzsap-loop-button').eq(0).parent().hasClass('feed-dzsap-for-extra-html-right') === false) {
          selfClass.cthis.find('.dzsap-loop-button').after(selfClass._metaArtistCon);
        } else {

          selfClass._conPlayPauseCon.after(selfClass._metaArtistCon);
        }
      }

      if (selfClass.skinwave_mode === 'alternate') {
        selfClass._apControlsRight.before(selfClass._metaArtistCon);
      }


    }
    if (o.design_skin === 'skin-aria') {
      selfClass._apControlsRight.prepend(selfClass._metaArtistCon);
    }
    if (o.design_skin === 'skin-redlights' || o.design_skin === 'skin-steel') {

      selfClass._apControlsRight.prepend(selfClass._metaArtistCon);


    }
    if (o.design_skin === 'skin-silver') {
      selfClass._apControlsRight.append(selfClass._metaArtistCon);
    }
    if (o.design_skin === 'skin-default') {
      selfClass._apControlsRight.before(selfClass._metaArtistCon);
    }


  }


}

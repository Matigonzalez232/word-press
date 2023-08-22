import {BlockFactory} from './gutenberg-block-factory/block-factory/blockFactory.jsx';
import configAttributes from '../../configs/config-gutenberg-player.json';

const {
  PlainText,
  MediaUpload
} = wp.editor;
const {TextControl} = wp.components;

let __ = (arg) => {
  return arg;
};


if (wp.i18n) {
  __ = wp.i18n.__;
}

const FiltersBlock = new BlockFactory({
  'blockKey': 'dzsap/the-gutenberg-player',
  'blockTitle': 'The ZoomSounds Player',
  'adminPreviewComponent': function (props) {
    console.log(props);


    let configOptionKey = 'item_source';
    let argsInputForm = {
      "label": "Thumbnail",
      "value": "",
      "instanceId": "item_thumb",
      "className": " dzs-dependency-field",
      "onChange": null,
      "allowedTypes": [
        "audio"
      ]
    }

    return (


      <div className={props.className}>
        <div className="dzsap-gutenberg-con--player zoomsounds-containers">
          <h6 className="gutenberg-title"><span
            className="dashicons dashicons-format-audio"/> {__('Zoomsounds Player')}</h6>
          <div className="react-setting-container">
            <div className="react-setting-container--label">{__("Source")}</div>
            <div className="react-setting-container--control">
              <MediaUpload
                {...argsInputForm}
                onSelect={(imageObject) => {
                  props.setAttributes({[configOptionKey]: imageObject.url});
                  console.log('imageObject - ', imageObject);
                  console.info(' props - ', props);
                }}
                render={({open}) => (
                  <div className="render-song-selector field-and-button-container">
                    <PlainText
                      className={"editor-rich-text__tinymce"}
                      format="string"
                      formattingControls={[]}
                      placeholder={('Input song uri')}
                      onChange={(val) => props.setAttributes({[configOptionKey]: val})}
                      value={props.attributes[configOptionKey]}
                    />
                    <button className="button-secondary" onClick={open}>{props.uploadButtonLabel}</button>
                  </div>
                )}
              />

            </div>
          </div>


          <div className="react-setting-container">
            <div className="react-setting-container--label">{__("Song name")}</div>
            <div className="react-setting-container--control">
              <TextControl
                className={" "}
                format="string"
                formattingControls={[]}
                placeholder={('Song name')}
                rows={1}
                onChange={(val) => props.setAttributes({['the_post_title']: val})}
                value={props.attributes['the_post_title']}
              />
            </div>
          </div>

          <div className="react-setting-container">
            <div className="react-setting-container--label">{__("Artist name")}</div>
            <div className="react-setting-container--control">
              <TextControl
                className={" "}
                format="string"
                formattingControls={[]}
                placeholder={('Artist name')}
                rows={1}
                onChange={(val) => props.setAttributes({['artistname']: val})}
                value={props.attributes['artistname']}
              />
            </div>
          </div>
        </div>
      </div>
    )
  },
  'configAttributes': configAttributes
})
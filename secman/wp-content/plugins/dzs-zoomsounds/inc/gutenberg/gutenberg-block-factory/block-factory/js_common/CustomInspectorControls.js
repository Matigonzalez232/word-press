import React from 'react';

const {
  TextControl,
  SelectControl,
} = wp.components;

let __ = (arg) => {
  return arg;
};

if (wp.i18n) {
  __ = wp.i18n.__;
}
const {
  PlainText,
  MediaUpload
} = wp.editor;

const IGNORED_KEYS = ['source','item_source', 'layout'];

export default class CustomInspectorControls extends React.Component {
  constructor(props) {
    super(props);
    this.props = props;
  }

  render() {

    let uploadSongLabel = __('Upload song');


    if(this.props.configAttributes) {
      return Object.keys(this.props.configAttributes).map((optionIndex) => {

        const props = this.props;
        let optionConfig = this.props.configAttributes[optionIndex];



        if (!optionConfig) {
          return '';
        }
        const configOptionKey = optionConfig.configOptionKey ? optionConfig.configOptionKey : optionIndex;

        if (IGNORED_KEYS.indexOf(configOptionKey)>-1) {
          return '';
        }

        if (configOptionKey === 'cat') {
          optionConfig.options = dzswtl_settings.cats;
        }

        var argsInputForm = {
            label: optionConfig.title,
            value: props.attributes[configOptionKey] ? props.attributes[configOptionKey] : '',
            instanceId: configOptionKey,
            className: ' dzs-dependency-field',
            onChange: (value) => {
              props.setAttributes({[configOptionKey]: value});
            }
          }
        ;


        let Sidenote = null;
        if (optionConfig.description && !optionConfig.sidenote) {
          optionConfig.sidenote = optionConfig.description;
        }

        if (optionConfig.sidenote) {
          Sidenote = (
            <div className="sidenote" dangerouslySetInnerHTML={{__html: optionConfig.sidenote}}/>
          )
        }

        const divAtts = {
          className: "dzs-gutenberg--inspector-setting check-instanceid ",
          'instanceid': configOptionKey,
        };
        if (optionConfig.dependency) {
          divAtts['data-dependency'] = JSON.stringify(optionConfig.dependency);
        }

        if (optionConfig.type === 'text') {

          divAtts.className += 'type-' + optionConfig.type;
          return (
            <div {...divAtts}>
              <TextControl
                {...argsInputForm}
              />
              {Sidenote}
            </div>
          )
            ;
        }
        if (optionConfig.type === 'select') {

          if (optionConfig.choices && !(optionConfig.options)) {
            optionConfig.options = optionConfig.choices;
          }


          divAtts.className += 'type-' + optionConfig.type;
          return (
            <div {...divAtts}>
              <SelectControl
                {...argsInputForm}
                options={optionConfig.options}
              />
              {Sidenote}
            </div>

          )
            ;
        }


        if (optionConfig.type === 'attach') {

          divAtts.className += 'type-' + optionConfig.type;
          if (optionConfig.upload_type) {

            argsInputForm.allowedTypes = [optionConfig.upload_type];
          }
          argsInputForm.onChange = null;


          if (props.attributes[configOptionKey]) {
            uploadSongLabel = __('Select another upload');
          }

          console.log('argsInputForm -> ',argsInputForm);
          return (
            <div {...divAtts}>
              <label className="components-base-control__label">{optionConfig.title}</label>
              <MediaUpload
                {...argsInputForm}
                onSelect={(imageObject) => {
                  props.setAttributes({[configOptionKey]: imageObject.url});
                }}
                render={({open}) => (
                  <div className="render-song-selector">
                    {props.attributes[configOptionKey] ? (
                      <PlainText
                        format="string"
                        formattingControls={[]}
                        placeholder={__('Input song name')}
                        onChange={(val) => props.setAttributes({[configOptionKey]: val})}
                        value={props.attributes[configOptionKey]}
                      />
                    ) : ""}
                    <button className="button-secondary" onClick={open}>{this.props.uploadButtonLabel}</button>
                  </div>
                )}
              />
              {Sidenote}
            </div>
          )
            ;
        }


      });
    }

    return null;

  }
}
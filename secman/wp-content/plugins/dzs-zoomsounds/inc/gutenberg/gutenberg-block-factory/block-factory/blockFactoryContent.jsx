import {Component} from 'react';



import CustomInspectorControls from "./js_common/CustomInspectorControls";

let __ = (arg) => {
  return arg;
};


if (wp.i18n) {
  __ = wp.i18n.__;
}

export class BlockFactoryContent extends Component {
  constructor(props) {
    super(props);

    this.state = {
      mainOptions_expanded: false,
    }

  }




  render(){
    let onClickToggleOptions = (key) => () => {
      this.setState({
        [key]: !this.state[key]
      })
      setTimeout(()=>{
      },2);

      if(window.dzs_checkDependency){

        window.dzs_checkDependency();
      }else{
        console.log('[warn] no window.dzs_checkDependency')
      }
    };

    const { adminPreviewComponent } = this.props;

    console.log('this.props.configAttributes -> ',this.props.configAttributes)
    console.log('this.props.attributes -> ',this.props.attributes)
    let PlayerInspectorControl = (
      <CustomInspectorControls
        configAttributes={this.props.configAttributes}
        uploadButtonLabel={this.props.uploadButtonLabel}
        attributes={this.props.attributes}
        setAttributes={this.props.setAttributes}
      />
    );

    return (<div>
      <div className="dzs--gutenberg--extra-options">
        {
          adminPreviewComponent ? adminPreviewComponent(this.props) : (
            <h4>{__('Shop Filter')}: <em>{this.props.attributes.feed_from}</em></h4>
          )
        }

        <h5 onClick={onClickToggleOptions('mainOptions_expanded')}
            className="dzs--gutenberg--extra-options--trigger">{!this.state.mainOptions_expanded ? (
          <span>{__('Options')} &darr;</span>) : (<span>{__('Retract')}  &uarr;</span>)}</h5>
        <div className="dzs--gutenberg--extra-options--content">
          {this.state.mainOptions_expanded ? PlayerInspectorControl : ''}
        </div>
      </div>
    </div>);

  }

}
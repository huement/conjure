import React, {Component} from 'react';

//styled-components
import {HomeLink, Icon, Text} from './styles';
import {iconClassName} from './styles';

class HomeLinkComponent extends Component {
  render() {
    const {icon, style, link, text} = this.props;
    return (
      <HomeLink style={style} href={link} target="_blank">
        <Icon className={iconClassName} name={icon} />
        <Text>{text}</Text>
      </HomeLink>
    );
  }
}

export default HomeLinkComponent;

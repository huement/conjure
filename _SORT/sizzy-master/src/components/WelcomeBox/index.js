// @flow
import typeof store from 'stores/store';
import React, {Component} from 'react';
import {inject, observer} from 'mobx-react';
import themes from 'styles/themes';

//styled-components
import {
  WelcomeBox,
  IntroText,
  ExampleLink,
  UrlBar,
  Content,
  Letter,
  Shapes,
  LetterAndShapes,
  ShapesWrap,
  MadeBy,
  MobileText,
  OnlyAvailable,
  Links
} from './styles';
import {ThemeProvider} from 'styled-components';

//styles
import {UrlInputStyles} from './styles';

//components
import HomeLink from 'components/HomeLink';

//img
import LetterSvg from 'img/S.svg';
import ShapesSvg from 'img/shapes.svg';

type Props = {
  store: any | store
};

@inject('store')
@observer
class WelcomeBoxComponent extends Component {
  props: Props;

  static defaultProps = {
    store: null
  };

  render() {
    const {store} = this.props;
    const {app} = store;
    const {loading, showWelcomeContent} = app;

    return (
      <WelcomeBox>
        <LetterAndShapes loading={loading}>
          <Letter loading={loading} src={LetterSvg} />
          <ShapesWrap loading={loading}>
            <Shapes src={ShapesSvg} />
          </ShapesWrap>
        </LetterAndShapes>

        <Content show={showWelcomeContent}>
          <IntroText> Welcome to Sizzy! Enter an url to start: </IntroText>

          <MobileText>
            A developer tool for testing responsive design on multiple devices
            at once.
          </MobileText>

          <OnlyAvailable>It's only available on large devices 😞</OnlyAvailable>

          <ThemeProvider theme={themes.dark}>
            <UrlBar styles={UrlInputStyles} />
          </ThemeProvider>

          <ExampleLink onClick={app.loadExampleUrl}>
            Click here to load an example!
          </ExampleLink>

          {!window.isElectron && (
            <Links>
              <HomeLink
                link="https://chrome.google.com/webstore/detail/sizzy/nfhlbmjiiogoelaflfclodlkncbdiefo"
                icon="chrome"
                text="Download Chrome Extension"
              />
              <HomeLink
                link="https://reactacademy.io"
                icon="book"
                style={{marginLeft: 15}}
                text="Learn with React Academy"
              />
            </Links>
          )}
        </Content>

        {!loading &&
        !window.isElectron && (
          <MadeBy target="_blank" href="https://kitze.io">
            made by @thekitze
          </MadeBy>
        )}
      </WelcomeBox>
    );
  }
}

export default WelcomeBoxComponent;

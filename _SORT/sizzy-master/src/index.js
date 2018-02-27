import React from 'react';
import ReactDOM from 'react-dom';
import store from 'stores/store';

//components
import App from 'components/App';

//style
import 'styles/index.css';
import 'normalize.css';
import 'font-awesome/css/font-awesome.css';

//mobx
import {Provider} from 'mobx-react';

//router
import {startRouter} from 'mobx-router';
import views from 'config/views';
startRouter(views, store);

ReactDOM.render(
  <Provider store={store}>
    <App />
  </Provider>,
  document.getElementById('root')
);

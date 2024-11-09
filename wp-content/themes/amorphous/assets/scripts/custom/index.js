import React from "react";
import {render} from "react-dom";
import { BrowserRouter as Router, Switch, Route, Redirect } from "react-router-dom";
import { ConnectedRouter } from "react-router-redux";
import App from "./components/App";
import AboutPage from "./components/about/AboutPage";
import configureStore from "./store/configureStore";
import {Provider} from "react-redux";
import createHistory from "history/createBrowserHistory";

import {loadPage, loadPages, loadPageByPath} from "./actions/pageActions";

const history = createHistory();
const rootEl = document.getElementById( 'app' );
const store = configureStore();


store.dispatch( loadPages() );
store.dispatch( loadPageByPath() );
//store.dispatch( loadPageByPath() );
render(
    <Provider store={store}>
        <ConnectedRouter history={history}>
            <Switch>
                <Route exact path="/" component={App}/>
                <Route path="*" component={App}/>
            </Switch>
        </ConnectedRouter>
    </Provider>, rootEl
);








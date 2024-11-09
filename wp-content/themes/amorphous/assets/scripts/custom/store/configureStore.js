import {createStore, applyMiddleware, compose } from "redux";
import {createLogger} from "redux-logger";
import rootReducer from "../reducers";
import createHistory from "history/createBrowserHistory";
import { routerMiddleware, routerReducer } from 'react-router-redux';

import thunk from "redux-thunk";

import DevTools from "../devtools/devtools";

const history = createHistory();
const historyMiddleware = routerMiddleware( history );
const loggerMiddleware = createLogger();
/**
 * This is for redux-devtools-extension in Chrome console.
 * Just a useful dev feature. It has nothing to do with my app.
 * https://github.com/zalmoxisus/redux-devtools-extension
 */
const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const middleware = [ thunk, loggerMiddleware, historyMiddleware ];

export default function configureStore( initialState ) {
    return createStore(
        rootReducer,
        initialState,
        //applyMiddleware(...middleware), // w/o redux devtools
        composeEnhancers( applyMiddleware(...middleware) )
    );
}
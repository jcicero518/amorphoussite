import * as types from "../actions/actionTypes";
import initialState from "./initialState";

function routerReducer( state = initialState.pageId, action ) {
    switch ( action.type ) {
        case types.ROUTER:
            return action.pageId;

        default:
            return state;
    }
}

export default routerReducer;
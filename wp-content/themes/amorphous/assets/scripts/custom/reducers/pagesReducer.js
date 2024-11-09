import * as types from "../actions/actionTypes";
import initialState from "./initialState";

function pagesReducer( state = initialState.pages, action ) {
    switch ( action.type ) {
        case types.LOAD_PAGES_SUCCESS:
            return action.pages;

        default:
            return state;
    }
}

export default pagesReducer;
import * as types from "../actions/actionTypes";
import initialState from "./initialState";

function pageReducer( state = initialState.page, action ) {
    switch ( action.type ) {
        case types.LOAD_PAGE_SUCCESS:
            return action.page;

        default:
            return state;
    }
}

export default pageReducer;
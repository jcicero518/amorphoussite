// https://github.com/jackreichert/a-wp-react-redux-theme/
import React from "react";
import PropTypes from "prop-types";

import Header from "./common/Header";
import HomePage from "./home/HomePage";
import AboutPage from "./about/AboutPage";
import PageRender from "./page/pageRender";

import {connect} from "react-redux";

import * as pageActions from "../actions/pageActions";

import {bindActionCreators} from "redux";
import {BrowserRouter as Router, Redirect, Switch, Route, withRouter} from "react-router-dom";

import Routes from "../routes";

class App extends React.Component {

    constructor(props, context) {
        super(props, context);
    }

    componentWillMount() {
        let path = this.props.location.pathname;
        if ( path == '/') {
            path = '/home';
        }
        this.props.actions.loadPageByPath( path );
    }

    componentWillReceiveProps( nextProps ) {
        let path = this.props.location.pathname;
        if ( path == '/') {
            path = '/home';
        }
        if ( path !== nextProps.location.pathname ) {
            //this.props.actions.loadPageByPath( path );
        }
        // this.props.pageId -> nextProps.match.params for pageId?
    }

    render() {
        console.log(this, 'app render this');
        return (
            <div>
                <Header loading={this.props.loading} />
                {Routes}
            </div>

        );
    }
}


App.propTypes = {
    match: PropTypes.object,
    loading: PropTypes.bool.isRequired,
    pages: PropTypes.array,
    page: PropTypes.object
};

function mapStateToProps( state, ownProps) {
    console.log(ownProps, 'newProp in App');
    let path = ownProps.location.pathname;
    if ( path == '/') {
        path = '/home';
    }
    return {
        loading: state.ajaxCallsInProgress > 0,
        page: state.page,
        pages: state.pages,
        pageId: state.pageId
    };
}

// determines what actions are available in the component
function mapDispatchToProps( dispatch ) {
    return {
        actions: bindActionCreators( pageActions, dispatch ) // becomes this.props.actions
    };
}

//export default App;
export default connect( mapStateToProps, mapDispatchToProps )(withRouter( App ) );
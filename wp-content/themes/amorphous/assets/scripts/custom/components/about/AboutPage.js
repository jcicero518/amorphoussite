import React from "react";
import PropTypes from "prop-types";

import {connect} from "react-redux";
import * as pageActions from "../../actions/pageActions";

import {bindActionCreators} from "redux";
import {withRouter} from "react-router-dom";

import PageRender from "../page/pageRender";

class AboutPage extends React.Component {
    // https://wpengine.com/wp-content/uploads/2017/02/WP-EBK-LT-UltimateGuideToPhp-FINAL.pdf
    // https://github.com/DreySkee/wp-api-react
    //http://jpsierens.com/simple-react-redux-application/
    render() {

        return (
            <div className="section">
                <div className="container">
                    <h1>{this.props.page.title.rendered}</h1>
                    <PageRender page={this.props.page} />
                </div>
            </div>
        )
    }
}

AboutPage.propTypes = {
    page: PropTypes.object,
    history: PropTypes.object,
    location: PropTypes.object,
    match: PropTypes.object
};

function getPageBySlug( pages, slug ) {
    return pages.filter( page => {
        return page.slug === slug;
    });
}

function mapStateToProps( state, ownProps ) {
    console.log(ownProps, 'ownProps');
    const pageSlug = ownProps.match.path.replace( '/', '' );
    let page = getPageBySlug( state.pages, pageSlug );

    return {
        page: page[0],
        pages: state.pages
    };
}

// determines what actions are available in the component
function mapDispatchToProps( dispatch ) {
    return {
        actions: bindActionCreators( pageActions, dispatch ) // becomes this.props.actions
    };
}

export default connect( mapStateToProps, mapDispatchToProps )( withRouter( AboutPage ));
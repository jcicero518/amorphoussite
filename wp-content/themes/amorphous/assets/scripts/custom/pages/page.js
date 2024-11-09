import React from "react";
import PropTypes from "prop-types";
import PageList from "./pageList";

const Page = ({ id }) => {
    console.log(page, 'page');
    console.log(id, 'id');
    return (
        <div>{id}</div>
    );
};


/*Page.propTypes = {
    page: PropTypes.object.isRequired
};*/

export default Page;
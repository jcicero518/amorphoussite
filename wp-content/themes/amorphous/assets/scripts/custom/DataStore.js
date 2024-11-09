/*global themeApi, globalPost, settings */
import axios from "axios";

class DataStore {

    constructor( params ) {

        const appUrl = themeApi.home;

        this.postType = params.postType ? params.postType : 'card';
        this.category = params.category ? params.category : '';
        this.categoryId = params.categoryId ? params.categoryId : 0;
        this.page = params.page ? params.page : 1;

        this.settings = settings;

        this.currentPageId = globalPost.postID;
        this.endPoint = `${appUrl}/wp-json/wp/v2/${this.postType}`;
        this.pageEndpoint = `${appUrl}/wp-json/amorph/v2/querypage/`;
    }

    api( endPoint ) {
        return new Promise( ( resolve, reject ) => {
            axios.get( endPoint ).then( ( response ) => {
                resolve( response.data );
            }).catch( ( error ) => {
                reject( error );
            });
        });
    }

    setPage( pageNum ) {
        this.page = pageNum;
        let sourcePage = this.currentPageId;
        let category = this.category ? this.category : '';
        return this.api( `${this.pageEndpoint}${pageNum}/${sourcePage}?category=${category}`).then( payload => {
            return payload;
        });
    }

    getPage() {
        const {queriedObject} = this.settings;

        let apiCall = `${this.endPoint}?per_page=5&page=${this.page}&orderby=date&order=desc`;

        if ( this.categoryId ) {
            apiCall += `&code_category=${this.categoryId}`;
        }

        return this.api( apiCall ).then( payload => {
            return payload;
        });
    }
}

export default DataStore;
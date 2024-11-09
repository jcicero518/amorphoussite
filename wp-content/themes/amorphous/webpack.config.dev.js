"use strict";

const merge = require('webpack-merge');
const BrowserSyncPlugin = require( 'browser-sync-webpack-plugin' );
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const CleanWebpackPlugin = require( 'clean-webpack-plugin' );

const common = require('./webpack.common.js');
const config = require('./assets/config.json');

module.exports = merge( common, {
    devtool: 'inline-source-map',
    entry: {
        app: './assets/scripts/custom/app.js'
    },
    plugins: [
        new ExtractTextPlugin({
            disable: false,
            //filename: '[name].[contentHash].css',
            filename: 'styles.css',
            allChunks: true
        })
    ]
    //plugins: [
        //new BrowserSyncPlugin({
        //    proxy: config.proxyUrl,
         //   files: [
         //       '**/*.php'
          //  ],
          //  reloadDelay: 0
       // })
    //]
});
/**
 * Core javascript utilities.
 *
 * @namespace cdemo
 * @since 1.0.0
 */
var cdemo = (function (exports, $, localize) {
    "use strict";

    /**
     * Set the rest nonce in the request headers.
     *
     * @param xhr
     *
     * @access private
     * @since 1.0.0
     * @return void
     */
    function set_rest_nonce(xhr) {
        xhr.setRequestHeader('X-WP-Nonce', localize.api.nonce);
    }

    /**
     * Basic Pub/Sub event buss.
     *
     * @constructor
     *
     * @since 1.0.0
     * @return {object}
     */
    const EventBus = function () {

        // Internal hooks
        const callbacks = jQuery.Callbacks();

        // Remap function names
        return {
            publish: callbacks.fire,
            subscribe: callbacks.add,
            unsubscribe: callbacks.remove
        };

    };


    // Export our bus
    exports.EventBus = EventBus;

    /**
     * @summary Service to control api sync.
     *
     * @access public
     * @since 1.0.0
     */
    exports.sync = (function () {

        /**
         * @summary Sync state event bus.
         */
        const syncStatus = EventBus();

        /**
         * @summary Sync public API.
         */
        const api = {

            /**
             * @summary  Sync status values.
             *
             * @enum {string}
             * @since 1.0.0
             * @access public
             */
            status: {

                /**
                 * @summary Sync has started
                 *
                 * @access public
                 * @since 1.0.0
                 */
                STARTED: 'started',

                /**
                 * @summary Sync has been paused
                 *
                 * @access public
                 * @since 1.0.0
                 */
                PAUSED: 'paused',

                /**
                 * @summary Sync has completed and is not running.
                 *
                 * @access public
                 * @since 1.0.0
                 */
                COMPLETE: 'complete',

                /**
                 * @summary Sync is in an idle state.
                 *
                 * @access public
                 * @since 1.0.0
                 */
                IDLE: 'idle',

                /**
                 * @summary Sync is pre fetching records from the cDemo API.
                 *
                 * @access public
                 * @since 1.0.0
                 */

                BUFFERING: 'buffering'

            },

            /**
             * @summary Begin syncing listings from the API.
             *
             * @access public
             * @since 1.0.0
             * @return {*|$.Deferred.promise}
             */
            start: function () {

                // Return a promise
                return $.when(

                    // Make a request to the status endpoint
                    $.ajax(localize.api.endpoints.sync + '/start', {
                        method: 'post',
                        beforeSend: set_rest_nonce,
                        success: state.push
                    })

                );

            },

            /**
             * @summary Pause a currently in progress sync operation.
             *
             * @access public
             * @since 1.0.0
             * @return {*|$.Deferred.promise}
             */
            pause: function () {

                // Return a promise
                return $.when(

                    // Make a request to the status endpoint
                    $.ajax(localize.api.endpoints.sync + '/pause', {
                        method: 'post',
                        beforeSend: set_rest_nonce,
                        success: state.push
                    })

                );

            },

            /**
             * Return the status event bus.
             *
             * @since 1.0.0
             * @return {{publish, subscribe, unsubscribe}}
             */
            state: function () {
                return syncStatus;
            }

        };

        /**
         * @summary Check the status of a sync operation.
         *
         * @access private
         * @since 1.0.0
         * @return {*|$.Deferred.promise}
         */
        function status() {

            // Return a promise
            return $.when(

                $.ajax(localize.api.endpoints.sync + '/status', {
                    beforeSend: set_rest_nonce
                })

            );

        }

        /**
         * @summary Holds the value of the current state
         *
         * @access private
         * @since 1.0.0
         */
        const state = {

            /**
             * @summary Push sync state change.
             *
             * @param {*} state
             *
             * @since 1.0.0
             * @return void
             */
            push: function (state) {
                syncStatus.publish(state);
            },

            /**
             * @summary Check the current sync state and notify of state changes.
             *
             * @since 1.0.0
             * @return void
             */
            check: function () {

                /**
                 * @summary Update the progress if the sync is not complete or paused.
                 */
                status().then(function (res) { state.push(res) }).done(function() {
                    setTimeout(state.check, refresh.rate);
                });

            }

        };

        /**
         * @summary Controls the rate of refresh from the API.
         *
         * @access private
         * @since 1.0.0
         */
        const refresh = {

            /**
             * @summary 1ms refresh time.
             */
            FAST: 1000,

            /**
             * 10s refresh time.
             */
            SLOW: 1000 * 10

        };

        // Set our initial refresh
        refresh.rate = refresh.SLOW;


        /**
         * @summary Speed up the refresh if we are syncing or slow down if we are at idle.
         */
        syncStatus.subscribe(function (state) {

            // Set a normal refresh rate if we're not syncing
            if ($.inArray(state.status, [cdemo.sync.status.IDLE, cdemo.sync.status.PAUSED]) > -1) {
                refresh.rate = refresh.SLOW;

            // Speed up requests to process faster
            } else {
                refresh.rate = refresh.FAST;
            }

        });

        // Check once on init
        state.check();


        // Return our sync object
        return api;

    })();


    // Module exports
    return exports;

})(cdemo || {}, jQuery, cdemo_l10n);
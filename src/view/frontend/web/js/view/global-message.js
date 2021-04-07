/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

define([
    'ko',
    'uiComponent'
], function (ko, Component) {
    'use strict';

    var content = window.checkoutConfig.globalMessage.content,
        isActive = window.checkoutConfig.globalMessage.isActive,
        startDate = window.checkoutConfig.globalMessage.startDate,
        endDate = window.checkoutConfig.globalMessage.endDate;

    return Component.extend({
        content: content,
        isActive: isActive,
        endDate: endDate,
        startDate: startDate,
        isVisible: ko.observable(false),

        /**
         * @inheritdoc
         */
        initialize: function() {
            this._super();
            var self = this;

            // set message visibility based on config data
            self.isVisible = self.showMessage();
        },

        /**
         * Check the dates and determine if the message is expired.
         *
         * @return {boolean}
         */
        isViewable: function() {
            var now   = new Date(),
                start = new Date(this.startDate),
                end   = new Date(this.endDate);

            if (this.endDate == null || (now > start && now < end)) {
                return true;
            }

            return false;
        },

        /**
         * Check the necessary data and determine if a message should be shown. Checks if the message is active
         * and not expired.
         *
         * @return {boolean}
         */
        showMessage: function() {
            if (this.isActive && this.isViewable()) {
                return true;
            }

            return false;
        },

        /**
         * Get message contents.
         *
         * @return {string}
         */
        getContent: function() {
            return this.content;
        }
    });
});

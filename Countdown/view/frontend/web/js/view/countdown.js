define([
    'uiComponent',
    'underscore',
    'ko',
    'moment',
    'moment-timezone-with-data'
], function (Component, _, ko, moment) {
    'use strict';

    return Component.extend({
        intervalId: null,
        defaults: {
            mapping: {},
            countDownHours: ko.observable(null),
            countDownMinutes: ko.observable(null),
            isApplicable: ko.observable(false),
            timezone: null,
            /** Can be overriden in configuration if we will need to add another time update period **/
            timeInterval: 60 * 1000,
            //We have 7 days in a week, so need to lookup for next 7 days
            allowedDaysLookup: 7,
            //Mapping for moment js, in order to allign it with data came from server
            momentWeekDayMapping: {
                1: "monday",
                2: "tuesday",
                3: "wednesday",
                4: "thursday",
                5: "friday",
                6: "saturday",
                7: "sunday"
            }
        },

        /**
         * Starting point for calculating hours and minutes
         */
        initialize: function () {
            this._super();

            if (this.timezone === null) {
                throw new Error("Timezone was not set on a server");
            }

            this.initCountDownTime();
        },

        calculateTime: function(days) {
            let mapping = this.getWeekdayMapping(days),
                countdownHours = mapping ? mapping.split(",")[0] : '',
                countdownMinutes = mapping ?  mapping.split(",")[1] : '',
                timeNow = this._getTimezoneMoment(),
                countDownTime,
                diff;

            //We need to stop count if we are iterating more than 1 week ahead
            //days variable -> is increment with which we are incrementing cut off date to the next day
            //if current does not satisfy us
            if (days === this.allowedDaysLookup) {
                return this.stopCounting();
            }
            //We need always to use timezone moment,
            //bacause otherwise time will be incorrect.
            countDownTime = this._getTimezoneMoment().set({
                hour: countdownHours,
                minute: countdownMinutes
            });
            //If today there will be no dispatch we need to lookup for tomorrow or day after tomorrow with increment - days
            countDownTime.add(days, 'days');
            diff = countDownTime.diff(timeNow);
            //If at least countdown hours were not parsed or the date is in the past, we need to lookup for the
            //next date
            if (countdownHours === '' || diff <= 0) {
                //Recursion if today we don`t have dispatch, we need to lookup for tomorrow...
                //If we will not have dispatch tomorrow we need to lookup for the day after tomorrow
                return this.calculateTime(days + 1);
            }
            //Set observable variables
            this.countDownHours(parseInt(moment.duration(diff).asHours()));
            this.countDownMinutes(parseInt(moment.duration(diff).asMinutes() % 60));
            //Set is applicable to yes in order to show message
            this.isApplicable(true);
        },

        stopCounting: function() {
            clearInterval(this.intervalId);
            this.isApplicable(false);
        },

        /**
         *
         * @returns {Object}
         * @private
         */
        _getTimezoneMoment: function() {
            return moment().tz(this.timezone);
        },

        /**
         * @returns {boolean|object}
         */
        getWeekdayMapping: function(daysOffset) {
            //If we are over the week. On sunday trying to add + 1 day (7 + 1 = 8, but we have pnly 7 days in a week)
            // we need to start from next week
            let weekday = (this._getTimezoneMoment().weekday() + daysOffset) % this.allowedDaysLookup;

            weekday = this.momentWeekDayMapping[weekday];
            if (this.mapping[weekday] === undefined ||
                this.mapping[weekday] === ''
            ) {
                return false;
            }

            return this.mapping[weekday];
        },

        /**
         * initializing countdown hours and minutes
         */
        initCountDownTime: function () {
            //Starting offset is 0, because we are starting from today and we don`t need offset
            this.calculateTime(0);
            this.intervalId = setInterval(this.calculateTime.bind(this, 0), this.timeInterval);
        }
    });
});

export default {
    methods: {
        zonedHour(time) {
            if (this.auth_timezone_difference >= 0) {
                return moment(time, 'HH:mm:ss').add(this.auth_timezone_difference, 'hours')
                                                .format('HH:mm') + ' hrs.';
            }

            return moment(time, 'HH:mm:ss').subtract(this.auth_timezone_difference * -1, 'hours')
                                            .format('HH:mm') + ' hrs.';
        },
    }
};
require('dotenv').config()
const nativefier = require('nativefier').default;

// Documentation can be found here: https://github.com/jiahaog/nativefier/blob/master/docs/api.md

const options = {
    name: 'Bar Bookings', // will be inferred if not specified
    targetUrl: 'https://reserveer.dwhdelft.nl/bar/?token=' + process.env.BAR_AREA_TOKEN, // required
    hideWindowFrame: true,
};

nativefier(options, function(error, appPath) {
    if (error) {
        console.error(error);
        return;
    }
    console.log('App has been nativefied to', appPath);
});

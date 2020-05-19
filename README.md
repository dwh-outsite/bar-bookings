# Bar Bookings

A timeslot booking system to offer a very simple booking functionality to our guests.
This application is developed to comply with government regulations due to COVID-19.

## Booking Flow and Rules

The system is currently built around the following rules for bookings:

* All bookings are done invididually
* A guest cannot make more than one booking for events in the future (fairness)
* After an event has ended guests can make new bookings
* Each event has a maximum capacity which cannot be exceeded
* There is a very simple system to deal with race conditions based on database transactions, which has not been
    thoroughly tested. We expect such a system to only really be relevant at system launch. If there are, despite the
    mechanisms, any issues with race conditions at launch, it is perfectly feasible to sort these out manually.
* A guest can cancel a booking. This immediately makes the spot available to others. The guest also has the ability to 
    immediately make a new booking.
* Bookings and cancelations are confirmed via e-mail. The booking confirmation serves as "proof" of the booking.

## API

At the moment, two endpoints are available.

### GET /api/events

Retrieve the available events.

_(more details will follow soon)_

### POST /api/bookings

Create a new booking.

_(more details will follow soon)_

## Getting Started and Usage

_The application is using a simple Laravel setup with very little customization, follow [Laravel's getting started guide](https://laravel.com/docs/7.x/installation) for more details on how to set the application up._

The application can be set up for local development using the built-in webserver, Laravel Valet, or any other tool of your preference.

All local configuration can be set up in a `.env` file, an example is provided.

All database types that are supported by Laravel can be used.
In production, MySQL is used.

Front-end assets are generated using Laravel Mix (`npm run dev`).

The repository is set up to auto-deploy. The contents of commits to master automatically end up on the production server.

## Testing
The application is equipped with tests. Please include tests in your contributions.

Use the following command to run the tests.
```
$ php artisan test
```

## Security

If you discover any security related issues, please email mail@casperboone.nl instead of using the issue tracker.

## Credits

- [Casper Boone](https://github.com/casperboone)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

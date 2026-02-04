<h1 align="center">Notification Center Homework</h1>

## About

This project implements a small Notification Center API written in PHP (Symfony).
The service exposes a single endpoint that returns a list of notifications
applicable to a specific user.

The API is designed to be consumed by different clients such as:

- Web front-end
- Mobile applications
- Other internal services

Each notification contains:

- title
- description
- call-to-action (CTA) URL

There is a `dump.sql` file provided in the `docker` directory. It should be used as a guideline.

---

## Assignment

Create an API with a single endpoint that:

1. Receives a `user_id`
2. Evaluates notification rules
3. Returns an array of eligible notifications for that user

### First Notification Rule

A notification **must be shown only when all of the following conditions are met**:

- The user **does not have an Android device attached**
- The user **is not on premium mode**
- The user **is from Spain** (country code: `ES`)
- The user **has not been active during the last week**

---

## Documentation

- Access the GET endpoint `/notifications` while providing `user_id` parameter to get an array of available notifications.
- Tests can be run using `bin/phpunit` command.

---

## Installation

TBD

---

## Authors

Created by **Erikas Tranauskas**

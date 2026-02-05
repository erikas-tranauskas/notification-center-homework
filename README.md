<h1 align="center">Notification Center Homework</h1>

## About

This project implements a small Notification Center API written in PHP (Symfony).
The service exposes a single endpoint that returns a list of notifications
applicable to a specific user.

There is a `dump.sql` file provided in the `docker` directory. It should be used as a guideline.

---

## Assignment

In our web application we have a requirement to show various notifications for our users. To achieve this,
we decided to create a separate API (using PHP) with a single endpoint that should receive user id and
respond with an array of viable notifications. Notification should have a title, description, and
a cta url link in its response. This endpoint will be polled from different kinds of
applications (web front-end, mobile applications, etc.), and notifications from
this response will be displayed to users. You are tasked to design and implement this API.

You need to create an API and implement the first notification rule that should be shown to users when:

- User doesn't have an Android device attached;
- User is not on premium mode;
- User is from Spain (country code is "ES");
- This notification should be shown only for those users that were not active during the last week.

---

## Documentation

- Access the GET endpoint `/notifications` while providing `user_id` parameter to get an array of available notifications.
- Requests include a simple header `X-API-TOKEN: interview-secret-token`. In a real system this would be replaced with proper authentication.
- Tests can be run using `bin/phpunit` command from inside the container `docker-compose exec php bin/phpunit`.
- Database can be reached by phpMyAdmin: `http://phpmyadmin.local/` using root credentials.
- Request example:
<pre>
curl -X GET "http://notification-center.local/notifications?user_id=2" -H "X-API-TOKEN: interview-secret-token"
</pre>
- Response example:
<pre>
[
    {
        "title": "Configurar dispositivo Android",
        "description": "Phasellus rhoncus ante dolor, at semper metus aliquam quis. Praesent finibus pharetra libero, ut feugiat mauris dapibus blandit. Donec sit.",
        "ctaUrl": "https://trendos.com/"
    }
]
</pre>

---

## Requirements

- Docker & Docker Compose.

---

## Installation

- Run `docker-compose up -d --build` inside `docker` directory to build and start the containers.
- Run composer install in the container `docker-compose exec php composer install`.
- The provided `dump.sql` is automatically imported into the database when the Docker containers are started.

---

## Production considerations

In real-world applications, I would recommend implementing the following features:

- Security: authentication and rate limiting.
- Performance: caching.
- Monitoring: logging and alerts.
- Versioning: API versioning (for example, URL `/api/v1/notifications`).
- Documentation: OpenAPI, Swagger UI.

---

## Authors

Created by **Erikas Tranauskas**

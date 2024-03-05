# Assessment for Canoe

## Requirements

This application was built using a set of Docker containers for easier encapsulation and installation. 

- Docker
- Docker Compose

## Installation

Initialize the Docker containers:

    docker compose up --build -d

Install the Composer dependencies for the PHP application:

    docker exec canoe_backend composer install

Run initial DB setup (contains dummy seeded data for testing purposes):

    docker exec canoe_backend php vendor/bin/doctrine-migrations migrate

## Usage

The API will be available at http://canoe.local, but can be changed if desired by defining another value for the `NGINX_HOSTNAME` variable in the `.env` file.

Ports 80 (for Nginx) and 3306 (for MySQL) are exposed, but they can also be redefined on the `.env` file. 

### API endpoints:

#### List funds:

    GET /funds

Accepts these query string parameters below:

- name
- startYear
- manager (name)
- managerIds (array of IDs)

---

#### Update a fund and its attributes

    POST /funds/{id}

Expects to receive a JSON as this one below:

```
{
    "id": 1,
    "name": "soluta veniam",
    "startYear": 2024,
    "managerId": 3,
    "aliases": [
        "atque sint",
        "est id",
        "et voluptas",
        "in qui",
        "minima suscipit",
        "natus sit",
        "nihil rerum",
        "pariatur eligendi",
        "placeat iste"
    ]
}
```

---

#### Create a new fund

    POST /funds/

Expects to receive a JSON as this one below:

```
{
    "name": "soluta veniam",
    "startYear": 2024,
    "managerId": 3,
    "aliases": [
        "atque sint",
        "est id",
        "et voluptas",
        "in qui",
        "minima suscipit",
        "natus sit",
        "nihil rerum",
        "pariatur eligendi",
        "placeat iste"
    ]
}
```


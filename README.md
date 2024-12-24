# Short url service

This is a simple short url service that allows you to shorten a long url to a short url.

---

## How to run the service

### Prerequisites
- Docker
  - If you don't have docker installed, you can install it by following the instructions
  [here](https://docs.docker.com/get-docker/)
  - If you want to run the service without docker, you need to install php, composer, and a database server (e.g. mysql). 
  Do not forget to create .env file and update database related variables.
- Postman or any other API testing tool

### First launch

Run the following command to build and run the project

```shell
docker compose up --build -d
```

Run the following commands to install composer dependencies and migrate database

```shell
docker exec atarim-app composer install
docker exex atarim-app php artisan migrate
```

Test the service by visiting [localhost](http://localhost) in your browser. 
Default Laravel welcome page should be displayed.

### Usage

#### Shorten a long url

To shorten a long url, send a POST request to `http://localhost/api/encode` with the following payload

```json
{
  "url": "https://www.example.com?q=test"
}
```

You will receive a response with the shortened url

```json
{
  "short_url": "http://short.est/gsiYJI"
}
```

#### Get the original url

To decode a shortened url, make a POST request to `http://localhost/api/decode` with the following payload

```json
{
  "url": "http://short.est/gsiYJI"
}
```

You will receive a response with the original url

```json
{
  "original_url": "https://www.example.com?q=test"
}
```

**Note:** Laravel uses `Accept: application/json` header to determine if the request is an API request.
You need to include this header in your request to get a proper validation error response.

### Running tests

To run the tests, run the following command

```shell
docker exec atarim-app ./vendor/bin/phpunit
```

# <div style="text-align:center"> TKambio Challenge </div>

Challenge Tkambio for Web Developer

## Requirements

- PHP v8 or higher
- PDO PHP Extension
- Composer

## Installation

First clone this repository, install the dependencies, and setup the .env file.

```bash
  git clone https://github.com/jtorresr1/ProjectTKambio.git
  composer install
  cd ProjectTKambio
  cp .env.example .env
```
Then create the necessary database and run the initial migrations and seeders.

```bash
php artisan migrate --seed
```


## Usage

To run the server

```bash
  php artisan serve
```


## API Reference

To see the api documentation, after of the start server, go to the URL

```http
  GET http://localhost:8000/api/documentation/
```


## Authors

- [@Jaime Torres Rodriguez](https://github.com/jtorresr1)


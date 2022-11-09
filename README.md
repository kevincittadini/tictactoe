# tictactoe
A tic-tac-toe API implementation in PHP

## Installation

 - Run `$ docker-compose up -d` and the whole environment will be up.
 - Run doctrine migrations
 - Run tests, coding standard and static analysis running `$ make qa`
 
## Usage
Once everything's up, use any kind of HTTP client.
The endpoint base is `http://localhost:17000/api`.

Chcek `$ docker-compose exec php-fpm bin/console debug:router` for available routes.

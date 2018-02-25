# ZF3 Tutorial Playground

## Getting started

- Run: `docker-compose up`
- Visit the album tutorial at `http://localhost:15000`
- See that it redirects to ssl version: `https://localhost:15003`
- Find phpMyAdmin at `http://localhost:15001` (user: root, password: root)
- Find maildog at `http://localhost:15002`

## Commands

- run tests: `composer test`
- run php codesniffer: `composer cs-check`
- fix checkstyle errors: `composer cs-fix`

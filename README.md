# DGEco

A simple store writen in PHP 7+.

![dgeco](screenshot.png)

You just need PHP to with `PDO` and `sqlite3` run this project:

```sh
BASE_URL=http://localhost:8080
php -S localhost:8080 home.php
```

You can use `docker` to run the store:

```sh
docker run \
  --rm \
  -ti \
  -v $PWD:/app \
  -w /app \
  -e BASE_URL=http://localhost:8080 \
  -p 8080:8080 \
  php \
    php -S 0.0.0.0:8080 home.php
```

Then, you need to make the setup to create the batabase (sqlite) file:

`http://localhost:8080/setup`

That's it!

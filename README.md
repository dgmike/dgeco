# DG Eco

A simple store writen in PHP 7+.

You just need PHP to run this project:

```sh
php -S 0.0.0.0:8080 -t /app/static home.php
```

You can use `docker` to run the store:

```sh
docker run \
  -ti \
  -v $PWD:/app \
  -w /app \
  -e BASE_URL=http://localhost:8080 \
  -p 8080:8080 \
  php \
    php -S 0.0.0.0:8080 -t /app/static home.php
```

Then, you need to make the setup to create the batabase (sqlite) file:

`http://localhost:8080/setup`

That's it!

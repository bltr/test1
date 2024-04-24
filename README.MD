```shell
docker compose build
docker compose up -docker
```

```postgresql
drop table if exists users;

create table users (
    id serial primary key,
    name varchar,
    outer_id bigint
);

drop table if exists mailing_logs;

create table mailin_logs (
     id serial primary key,
     driver varchar,
     subject varchar,
     message varchar,
     user_id integer
);

alter table mailing_logs
    add constraint mailing_logs_pk
        unique (driver, subject, user_id);
```

```shell
curl -v http://127.0.0.1:8080/api/users/import \
  -H "Content-Type: multipart/form-data" \
  -F "data=@data.csv"
```

```shell
curl -v http://127.0.0.1:8080/api/users/mailing \
  -H "Content-Type: application/json" \
  -d '{"driver": "email", "subject": "news", "message": "something occurred ..."}'
```

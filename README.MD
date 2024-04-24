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
```

```shell
curl -v -X POST http://127.0.0.1:8080/api/users/import \
  -H "Content-Type: multipart/form-data" \
  -F "data=@data.csv"
```

```shell
curl -v -X POST http://127.0.0.1:8080/api/users/mailing \
  -H "Content-Type: application/json" 
```

# blog.ly

Since I don't know how to force docker compose to wait for databases to boot up, I suggest running two commands separately, namely
```
docker-compose up mongodb mysql composer
```

Wait for it to finish and afterwards run

```
docker-compose up phpfpm web
```

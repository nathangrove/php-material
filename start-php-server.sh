#!/bin/bash
CONTAINER_NAME="phpmaterial"
docker stop "$CONTAINER_NAME"
docker rm "$CONTAINER_NAME"
docker run -dit -p 3333:3306 -p 8888:80 --name="$CONTAINER_NAME" -v "$(pwd)"/public:/var/www/html -v "$(pwd)"/secure:/var/www/secure phpmaterial
docker logs -f "$CONTAINER_NAME"

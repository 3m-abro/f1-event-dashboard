#!/bin/bash

docker run -it --rm \
  -v "$(pwd):/app" \
  -w "/app" \
  -p 8081:8081 \
  -e HOST=0.0.0.0 \
  node:latest \
  npm run serve
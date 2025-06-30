ARG NODE_VERSION
FROM node:${NODE_VERSION}

ARG SOURCE_CODE_PATH_CONTAINER

RUN apt-get update && \
    apt-get install -y sudo && \
    rm -rf /var/lib/apt/lists/*

EXPOSE 6001

WORKDIR ${SOURCE_CODE_PATH_CONTAINER}

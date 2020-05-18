
# This file is (c) 2020 by Georg Großberger
#
# It is free software; you can redistribute it and/or
# modify it under the terms of the Apache License 2.0
#
# For the full copyright and license information see
# <https://www.apache.org/licenses/LICENSE-2.0>

FROM ubuntu:bionic

RUN set -e -x \
    && mkdir /app \
    && chown 1000:1000 /app \
    && addgroup --system --gid 1000 app \
    && adduser --system --shell /bin/false --home /app --no-create-home --uid 1000 --gid 1000 --disabled-login app \
    && mkdir -p /app/.ssh

ADD ssh-config /app/.ssh/config

RUN set -e -x \
    && chmod 0700 /app/.ssh \
    && chmod 0600 /app/.ssh/config \
    && chown -hR 1000:1000 /app /app/.ssh

ENV DEBIAN_FRONTEND=noninteractive \
    DEBCONF_NONINTERACTIVE_SEEN=true

ADD apt-cmd.sh /bin/apt-cmd

RUN set -e -u -x \
    && echo "UTC" > /etc/timezone \
    && chmod +x /bin/apt-cmd \
    \
    && apt update -y \
    && apt install -y curl gnupg software-properties-common apt-transport-https ca-certificates \
    \
    && curl -fsSLo docker.key https://download.docker.com/linux/ubuntu/gpg \
    && apt-key add docker.key \
    && rm -f docker.key \
    && add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu bionic stable" -y \
    && add-apt-repository ppa:ondrej/php -y \
    && add-apt-repository ppa:git-core/ppa -y \
    && add-apt-repository ppa:ansible/ansible -y \
    \
    && apt update -y \
    && apt full-upgrade -y \
    && apt install -y gcc g++ make openssl jq wget less docker-ce-cli ansible \
           rsync xz-utils openssh-client git zip unzip mysql-client default-jre-headless patch \
           xvfb gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 \
           libdbus-1-3 libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 \
           libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 \
           libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 \
           libxtst6 ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils \
    \
    && apt-cmd purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \
        software-properties-common apt-transport-https

ENV PHP_VERSION=7.4.6
ENV PHP_BRANCH=7.4

RUN set -e -u -x \
    && apt-cmd install -y \
        php${PHP_BRANCH}-cli php${PHP_BRANCH}-curl php${PHP_BRANCH}-mbstring php${PHP_BRANCH}-zip php${PHP_BRANCH}-xml php${PHP_BRANCH}-soap \
        php${PHP_BRANCH}-json php${PHP_BRANCH}-bz2 php${PHP_BRANCH}-intl php${PHP_BRANCH}-gd php${PHP_BRANCH}-mysql php${PHP_BRANCH}-sqlite3

ENV NODE_VERSION=14.2.0

RUN set -e -u -x \
    && curl -sSLo node.tar.xz https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-x64.tar.xz \
    && tar -x -J -C /usr/local --strip-components=1 -f node.tar.xz \
    && rm -f node.tar.xz

ENV YARN_VERSION=1.22.4

RUN set -e -u -x \
    && curl -sSLo /usr/local/bin/yarn https://github.com/yarnpkg/yarn/releases/download/v${YARN_VERSION}/yarn-${YARN_VERSION}.js \
    && chmod +x /usr/local/bin/yarn

ENV COMPOSER_VERSION=1.10.6

RUN set -e -u -x \
    && curl -sSLo composer-setup.php https://getcomposer.org/installer \
    && php -r "if (hash_file('sha384', 'composer-setup.php') !== 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer corrupt' . PHP_EOL; unlink('composer-setup.php'); exit(1); }" \
    && php composer-setup.php --version=${COMPOSER_VERSION} --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

ENV TYPO3SCAN_VERSION=1.6.4

RUN set -e -u -x \
    && curl -sSLo /usr/local/bin/typo3scan https://github.com/Tuurlijk/typo3scan/releases/download/${TYPO3SCAN_VERSION}/typo3scan.phar \
    && chmod +x /usr/local/bin/typo3scan

USER app

ENV DEPLOYER_VERSION=6.8.0
ENV SURF_VERSION=2.0.2

RUN set -e -u -x \
    && composer global require --no-suggest --no-ansi --no-progress --update-no-dev --ignore-platform-reqs \
        typo3/surf:${SURF_VERSION} \
        deployer/deployer:${DEPLOYER_VERSION} \
    && rm -rf /app/.composer/cache/*

RUN set -e -u -x \
    && yarn global add grunt-cli gulp-cli cross-env \
    && rm -rf /app/.cache/yarn/*

ENV PATH=/app/.config/yarn/global/node_modules/.bin:/app/.composer/vendor/bin:/app/.local/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin

CMD ["/bin/bash"]

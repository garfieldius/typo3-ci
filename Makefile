

# This file is (c) 2020 by Georg Großberger
#
# It is free software; you can redistribute it and/or
# modify it under the terms of the Apache License 2.0
#
# For the full copyright and license information see
# <https://www.apache.org/licenses/LICENSE-2.0>

IMAGE_TAG ?= garfieldius/typo3-ci

.PHONY: default
default: php7.2-node12 php7.2-node10 php7.3-node12 php7.3-node10 php7.4-node14 php8.0-node14

.PHONY: php7.2-node12
php7.2-node12:
	@docker build --pull -t $(IMAGE_TAG):php7.2-node12 ./php7.2-node12/.

.PHONY: php7.2-node10
php7.2-node10:
	@docker build --pull -t $(IMAGE_TAG):php7.2-node10 ./php7.2-node10/.

.PHONY: php7.3-node12
php7.3-node12:
	@docker build --pull -t $(IMAGE_TAG):php7.3-node12 ./php7.3-node12/.

.PHONY: php7.3-node10
php7.3-node10:
	@docker build --pull -t $(IMAGE_TAG):php7.3-node10 ./php7.3-node10/.

.PHONY: php7.4-node14
php7.4-node14:
	@docker build --pull -t $(IMAGE_TAG):php7.4-node14 ./php7.4-node14/.

.PHONY: php8.0-node14
php8.0-node14:
	@docker build --pull -t $(IMAGE_TAG):php8.0-node14 ./php8.0-node14/.

.PHONY: push
push:
	@docker push $(IMAGE_TAG)

.PHONY: clean
clean:
	@docker rmi $(IMAGE_TAG):php7.2-node12
	@docker rmi $(IMAGE_TAG):php7.2-node10
	@docker rmi $(IMAGE_TAG):php7.3-node12
	@docker rmi $(IMAGE_TAG):php7.3-node10
	@docker rmi $(IMAGE_TAG):php7.4-node14
	@docker rmi $(IMAGE_TAG):php8.0-node14
	@docker image prune -f

.PHONY: generate
generate:
	@php generate.php

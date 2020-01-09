

# This file is (c) 2020 by Georg Großberger
#
# It is free software; you can redistribute it and/or
# modify it under the terms of the Apache License 2.0
#
# For the full copyright and license information see
# <https://www.apache.org/licenses/LICENSE-2.0>

IMAGE_TAG ?= garfieldius/typo3-ci

.PHONY: default
default: bionic-php7.2-node12 bionic-php7.2-node11 bionic-php7.2-node10 bionic-php7.3-node12 bionic-php7.3-node11 bionic-php7.3-node10 bionic-php7.4-node12 bionic-php7.4-node11 bionic-php7.4-node10

.PHONY: bionic-php7.2-node12
bionic-php7.2-node12:
	docker build --pull -t $(IMAGE_TAG):php7.2-node12 ./bionic-php7.2-node12/.

.PHONY: bionic-php7.2-node11
bionic-php7.2-node11:
	docker build --pull -t $(IMAGE_TAG):php7.2-node11 ./bionic-php7.2-node11/.

.PHONY: bionic-php7.2-node10
bionic-php7.2-node10:
	docker build --pull -t $(IMAGE_TAG):php7.2-node10 ./bionic-php7.2-node10/.

.PHONY: bionic-php7.3-node12
bionic-php7.3-node12:
	docker build --pull -t $(IMAGE_TAG):php7.3-node12 ./bionic-php7.3-node12/.

.PHONY: bionic-php7.3-node11
bionic-php7.3-node11:
	docker build --pull -t $(IMAGE_TAG):php7.3-node11 ./bionic-php7.3-node11/.

.PHONY: bionic-php7.3-node10
bionic-php7.3-node10:
	docker build --pull -t $(IMAGE_TAG):php7.3-node10 ./bionic-php7.3-node10/.

.PHONY: bionic-php7.4-node12
bionic-php7.4-node12:
	docker build --pull -t $(IMAGE_TAG):php7.4-node12 ./bionic-php7.4-node12/.

.PHONY: bionic-php7.4-node11
bionic-php7.4-node11:
	docker build --pull -t $(IMAGE_TAG):php7.4-node11 ./bionic-php7.4-node11/.

.PHONY: bionic-php7.4-node10
bionic-php7.4-node10:
	docker build --pull -t $(IMAGE_TAG):php7.4-node10 ./bionic-php7.4-node10/.

.PHONY: push
push:
	@docker push $(IMAGE_TAG)

.PHONY: clean
clean:
	docker rmi $(IMAGE_TAG):php7.2-node12
	docker rmi $(IMAGE_TAG):php7.2-node11
	docker rmi $(IMAGE_TAG):php7.2-node10
	docker rmi $(IMAGE_TAG):php7.3-node12
	docker rmi $(IMAGE_TAG):php7.3-node11
	docker rmi $(IMAGE_TAG):php7.3-node10
	docker rmi $(IMAGE_TAG):php7.4-node12
	docker rmi $(IMAGE_TAG):php7.4-node11
	docker rmi $(IMAGE_TAG):php7.4-node10
	docker image prune -f

.PHONY: generate
generate:
	php generate.php

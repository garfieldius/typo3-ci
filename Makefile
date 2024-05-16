

# This file is (c) 2022 by Georg Großberger
#
# It is free software; you can redistribute it and/or
# modify it under the terms of the Apache License 2.0
#
# For the full copyright and license information see
# <https://www.apache.org/licenses/LICENSE-2.0>

IMAGE_TAG ?= garfieldius/typo3-ci

.PHONY: default
default: php7.2-node10 php7.2-node12 php7.2-node14 php7.2-node16 php7.4-node10 php7.4-node14 php7.4-node16 php7.4-node18 php8.0-node10 php8.0-node14 php8.0-node16 php8.0-node18 php8.1-node14 php8.1-node16 php8.1-node18 php8.1-node20 php8.1-node22 php8.2-node14 php8.2-node16 php8.2-node18 php8.2-node20 php8.2-node22 php8.3-node14 php8.3-node16 php8.3-node18 php8.3-node20 php8.3-node22

.PHONY: php7.2-node10
php7.2-node10:
	@docker build --progress plain --tag $(IMAGE_TAG):php7.2-node10 ./php7.2-node10/.

.PHONY: php7.2-node12
php7.2-node12:
	@docker build --progress plain --tag $(IMAGE_TAG):php7.2-node12 ./php7.2-node12/.

.PHONY: php7.2-node14
php7.2-node14:
	@docker build --progress plain --tag $(IMAGE_TAG):php7.2-node14 ./php7.2-node14/.

.PHONY: php7.2-node16
php7.2-node16:
	@docker build --progress plain --tag $(IMAGE_TAG):php7.2-node16 ./php7.2-node16/.

.PHONY: php7.4-node10
php7.4-node10:
	@docker build --progress plain --tag $(IMAGE_TAG):php7.4-node10 ./php7.4-node10/.

.PHONY: php7.4-node14
php7.4-node14:
	@docker build --progress plain --tag $(IMAGE_TAG):php7.4-node14 ./php7.4-node14/.

.PHONY: php7.4-node16
php7.4-node16:
	@docker build --progress plain --tag $(IMAGE_TAG):php7.4-node16 ./php7.4-node16/.

.PHONY: php7.4-node18
php7.4-node18:
	@docker build --progress plain --tag $(IMAGE_TAG):php7.4-node18 ./php7.4-node18/.

.PHONY: php8.0-node10
php8.0-node10:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.0-node10 ./php8.0-node10/.

.PHONY: php8.0-node14
php8.0-node14:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.0-node14 ./php8.0-node14/.

.PHONY: php8.0-node16
php8.0-node16:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.0-node16 ./php8.0-node16/.

.PHONY: php8.0-node18
php8.0-node18:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.0-node18 ./php8.0-node18/.

.PHONY: php8.1-node14
php8.1-node14:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.1-node14 ./php8.1-node14/.

.PHONY: php8.1-node16
php8.1-node16:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.1-node16 ./php8.1-node16/.

.PHONY: php8.1-node18
php8.1-node18:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.1-node18 ./php8.1-node18/.

.PHONY: php8.1-node20
php8.1-node20:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.1-node20 ./php8.1-node20/.

.PHONY: php8.1-node22
php8.1-node22:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.1-node22 ./php8.1-node22/.

.PHONY: php8.2-node14
php8.2-node14:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.2-node14 ./php8.2-node14/.

.PHONY: php8.2-node16
php8.2-node16:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.2-node16 ./php8.2-node16/.

.PHONY: php8.2-node18
php8.2-node18:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.2-node18 ./php8.2-node18/.

.PHONY: php8.2-node20
php8.2-node20:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.2-node20 ./php8.2-node20/.

.PHONY: php8.2-node22
php8.2-node22:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.2-node22 ./php8.2-node22/.

.PHONY: php8.3-node14
php8.3-node14:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.3-node14 ./php8.3-node14/.

.PHONY: php8.3-node16
php8.3-node16:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.3-node16 ./php8.3-node16/.

.PHONY: php8.3-node18
php8.3-node18:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.3-node18 ./php8.3-node18/.

.PHONY: php8.3-node20
php8.3-node20:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.3-node20 ./php8.3-node20/.

.PHONY: php8.3-node22
php8.3-node22:
	@docker build --progress plain --tag $(IMAGE_TAG):php8.3-node22 ./php8.3-node22/.

.PHONY: push
push:
	@docker push $(IMAGE_TAG)

.PHONY: clean
clean:
	@docker rmi $(IMAGE_TAG):php7.2-node10
	@docker rmi $(IMAGE_TAG):php7.2-node12
	@docker rmi $(IMAGE_TAG):php7.2-node14
	@docker rmi $(IMAGE_TAG):php7.2-node16
	@docker rmi $(IMAGE_TAG):php7.4-node10
	@docker rmi $(IMAGE_TAG):php7.4-node14
	@docker rmi $(IMAGE_TAG):php7.4-node16
	@docker rmi $(IMAGE_TAG):php7.4-node18
	@docker rmi $(IMAGE_TAG):php8.0-node10
	@docker rmi $(IMAGE_TAG):php8.0-node14
	@docker rmi $(IMAGE_TAG):php8.0-node16
	@docker rmi $(IMAGE_TAG):php8.0-node18
	@docker rmi $(IMAGE_TAG):php8.1-node14
	@docker rmi $(IMAGE_TAG):php8.1-node16
	@docker rmi $(IMAGE_TAG):php8.1-node18
	@docker rmi $(IMAGE_TAG):php8.1-node20
	@docker rmi $(IMAGE_TAG):php8.1-node22
	@docker rmi $(IMAGE_TAG):php8.2-node14
	@docker rmi $(IMAGE_TAG):php8.2-node16
	@docker rmi $(IMAGE_TAG):php8.2-node18
	@docker rmi $(IMAGE_TAG):php8.2-node20
	@docker rmi $(IMAGE_TAG):php8.2-node22
	@docker rmi $(IMAGE_TAG):php8.3-node14
	@docker rmi $(IMAGE_TAG):php8.3-node16
	@docker rmi $(IMAGE_TAG):php8.3-node18
	@docker rmi $(IMAGE_TAG):php8.3-node20
	@docker rmi $(IMAGE_TAG):php8.3-node22
	@docker image prune -f

.PHONY: generate
generate:
	@php generate.php

#!/usr/bin/env bash

# This file is (c) 2022 by Georg Großberger
#
# It is free software; you can redistribute it and/or
# modify it under the terms of the Apache License 2.0
#
# For the full copyright and license information see
# <https://www.apache.org/licenses/LICENSE-2.0>

set -e -x

apt update
apt $*
rm -rf /var/lib/apt/lists/*
find /var/cache -type f -delete

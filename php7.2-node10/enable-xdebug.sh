#!/usr/bin/env bash

for F in $(ls /etc/php/*/mods-available/xdebug.ini); do
    echo "zend_extension=xdebug.so" > ${F}
done

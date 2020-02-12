#!/usr/bin/env php
<?php

/*
 * This file is (c) 2020 by Georg Großberger
 *
 * It is free software; you can redistribute it and/or
 * modify it under the terms of the Apache License 2.0
 *
 * For the full copyright and license information see
 * <https://www.apache.org/licenses/LICENSE-2.0>
 */

$images = [
    'bionic' => [
        'php' => ['7.2', '7.3', '7.4'],
        'node' => ['12.16.0', '11.15.0', '10.19.0'],
        'yarn' => '1.22.0',
        'composer' => '1.9.3',
        'deployer' => '6.7.3',
        'typo3scan' => '1.6.3',
    ],
];

$tmplBuild = '.PHONY: %1$s
%1$s:
	docker build --pull -t $(IMAGE_TAG):%2$s ./%1$s/.';

$tmplClean = "	docker rmi $(IMAGE_TAG):%s\n";

$tmplFile = '

# This file is (c) 2020 by Georg Großberger
#
# It is free software; you can redistribute it and/or
# modify it under the terms of the Apache License 2.0
#
# For the full copyright and license information see
# <https://www.apache.org/licenses/LICENSE-2.0>

IMAGE_TAG ?= garfieldius/typo3-ci

.PHONY: default
default: %s

%s

.PHONY: push
push:
	@docker push $(IMAGE_TAG)

.PHONY: clean
clean:
%s	docker image prune -f

.PHONY: generate
generate:
	php generate.php
';

$defaults = [];
$cleans = [];
$targets = [];

$baseDir = realpath(__DIR__) . DIRECTORY_SEPARATOR;

foreach ($images as $image => $versions) {
    exec("rm -rf $baseDir$image-php*");

    foreach ($versions['php'] as $php) {
        foreach ($versions['node'] as $node) {
            $nodeVersionParts = explode('.', $node);
            $nodeMajor = array_shift($nodeVersionParts);

            $tag = 'php' . $php . '-node' . $nodeMajor;

            exec("cp -a ${baseDir}template-${image} ${baseDir}${image}-${tag}");
            exec("mv ${baseDir}${image}-${tag}/Dockerfile.tmpl ${baseDir}${image}-${tag}/Dockerfile");

            $dockerfilePath = $baseDir . $image . '-' . $tag . DIRECTORY_SEPARATOR . 'Dockerfile';
            $dockerfileContent = file_get_contents($dockerfilePath);

            $markers = [
                'PHP_VERSION' => $php,
                'NODE_VERSION' => $node,
                'YARN_VERSION' => $versions['yarn'],
                'COMPOSER_VERSION' => $versions['composer'],
                'DEPLOYER_VERSION' => $versions['deployer'],
                'TYPO3SCAN_VERSION' => $versions['typo3scan'],
            ];

            foreach ($markers as $name => $value) {
                $dockerfileContent = str_replace("##$name##", $value, $dockerfileContent);
            }

            file_put_contents($dockerfilePath, $dockerfileContent);

            $name = $image . '-' . $tag;

            $defaults[] = $name;
            $cleans[] = sprintf($tmplClean, $tag);
            $targets[] = sprintf(
                $tmplBuild,
                $name,
                $tag
            );
        }
    }
}

file_put_contents($baseDir . 'Makefile', sprintf($tmplFile, implode(' ', $defaults), implode("\n\n", $targets), implode('', $cleans)));

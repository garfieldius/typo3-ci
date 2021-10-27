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
        'php' => ['7.2.34', '7.3.31'],
        'node' => ['10.24.1', '12.22.7', '14.18.1'],
        'yarn' => '1.22.15',
        'composer' => '2.1.8',
        'deployer' => '6.8.0',
        'typo3scan' => '1.7.2',
        'surf' => '2.3.2',
    ],
    'focal' => [
        'php' => ['7.4.24', '8.0.11'],
        'node' => ['10.24.1', '14.18.1', '16.10.0'],
        'yarn' => '1.22.15',
        'composer' => '2.1.8',
        'deployer' => '6.8.0',
        'typo3scan' => '1.7.2',
        'surf' => '2.3.2',
    ],
];

$tmplBuild = '.PHONY: %1$s
%1$s:
	@docker buildx build --tag $(IMAGE_TAG):%2$s --platform linux/amd64,linux/arm64 --progress plain $(BUILD_ARG) ./%1$s/.';

$tmplClean = "	@docker rmi $(IMAGE_TAG):%s\n";

$tmplFile = '

# This file is (c) 2020 by Georg Großberger
#
# It is free software; you can redistribute it and/or
# modify it under the terms of the Apache License 2.0
#
# For the full copyright and license information see
# <https://www.apache.org/licenses/LICENSE-2.0>

IMAGE_TAG ?= garfieldius/typo3-ci
BUILD_ARG ?= --pull

.PHONY: default
default: %s

.PHONY: setup-builder
setup-builder:
	@docker run --rm --privileged multiarch/qemu-user-static --reset -p yes
	@docker buildx create --name multiarch --driver docker-container --use

%s

.PHONY: push
push:
	@docker push $(IMAGE_TAG)

.PHONY: clean
clean:
%s	@docker image prune -f

.PHONY: generate
generate:
	@php generate.php
';

$defaults = [];
$cleans = [];
$targets = [];

$baseDir = realpath(__DIR__) . DIRECTORY_SEPARATOR;

$oldWorkflow = file_get_contents($baseDir . '.github/workflows/build.yml');
$newWorkflow = substr($oldWorkflow, 0, strpos($oldWorkflow, 'combo:') + 7);

exec("rm -rf ${baseDir}php*");

foreach ($images as $image => $versions) {
    foreach ($versions['php'] as $php) {
        $phpFull = $php;
        $php = substr($php, 0, 3);

        foreach ($versions['node'] as $node) {
            $nodeVersionParts = explode('.', $node);
            $nodeMajor = array_shift($nodeVersionParts);

            $tag = 'php' . $php . '-node' . $nodeMajor;

            $newWorkflow .= "          - '$tag'\n";

            exec("cp -a ${baseDir}template-${image} ${baseDir}${tag}");
            exec("mv ${baseDir}${tag}/Dockerfile.tmpl ${baseDir}${tag}/Dockerfile");

            $dockerfilePath = $baseDir . $tag . DIRECTORY_SEPARATOR . 'Dockerfile';
            $dockerfileContent = file_get_contents($dockerfilePath);

            $markers = [
                'PHP_VERSION' => $phpFull,
                'PHP_BRANCH' => $php,
                'NODE_VERSION' => $node,
                'YARN_VERSION' => $versions['yarn'],
                'COMPOSER_VERSION' => $versions['composer'],
                'DEPLOYER_VERSION' => $versions['deployer'],
                'TYPO3SCAN_VERSION' => $versions['typo3scan'],
                'SURF_VERSION' => $versions['surf'],
            ];

            foreach ($markers as $name => $value) {
                $dockerfileContent = str_replace("##$name##", $value, $dockerfileContent);
            }

            if ((float) $php >= 8.0) {
                $dockerfileContent = str_replace('php${PHP_BRANCH}-json ', '', $dockerfileContent);
            }

            file_put_contents($dockerfilePath, $dockerfileContent);

            $name = $tag;

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

$newWorkflow .= "\n" . substr($oldWorkflow, strpos($oldWorkflow, '    steps:'));
file_put_contents($baseDir . '.github/workflows/build.yml', $newWorkflow);

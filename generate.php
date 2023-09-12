#!/usr/bin/env php
<?php

/*
 * This file is (c) 2022 by Georg Großberger
 *
 * It is free software; you can redistribute it and/or
 * modify it under the terms of the Apache License 2.0
 *
 * For the full copyright and license information see
 * <https://www.apache.org/licenses/LICENSE-2.0>
 */

$php80 = '8.0.30';
$php81 = '8.1.23';
$php82 = '8.2.10';

$node10 = '10.24.1';
$node12 = '12.22.12';
$node14 = '14.21.3';
$node16 = '16.20.2';
$node18 = '18.16.0';
$node20 = '20.6.1';

$composer2 = '2.6.2';
$surf3 = '3.4.3';

$images = [
    'bionic' => [
        'php' => ['7.2.34'],
        'node' => [$node10, $node12, $node14],
        'yarn' => '1.22.19',
        'composer' => $composer2,
        'deployer' => '6.8.0',
        'typo3scan' => '1.7.3',
        'surf' => '2.4.0',
        'surfphar' => $surf3,
    ],
    'focal' => [
        'php' => ['7.4.33', $php80],
        'node' => [$node10, $node14, $node16, $node18],
        'yarn' => '1.22.19',
        'composer' => $composer2,
        'deployer' => '6.8.0',
        'typo3scan' => '1.7.3',
        'surf' => '2.4.0',
        'surfphar' => $surf3,
    ],
    'jammy' => [
        'php' => [$php81, $php82],
        'node' => [$node14, $node16, $node18, $node20],
        'yarn' => '1.22.19',
        'composer' => $composer2,
        'deployer' => '6.8.0',
        'typo3scan' => '1.7.3',
        'surf' => '2.4.0',
        'surfphar' => $surf3,
    ],
];

$tmplBuild = '.PHONY: %1$s
%1$s:
	@docker build --progress plain --tag $(IMAGE_TAG):%2$s ./%1$s/.';

$tmplClean = "	@docker rmi $(IMAGE_TAG):%s\n";

$tmplFile = '

# This file is (c) 2022 by Georg Großberger
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

exec("rm -rf {$baseDir}php*");

foreach ($images as $image => $versions) {
    foreach ($versions['php'] as $php) {
        $phpFull = $php;
        $php = substr($php, 0, 3);

        foreach ($versions['node'] as $node) {
            $nodeVersionParts = explode('.', $node);
            $nodeMajor = array_shift($nodeVersionParts);

            $tag = 'php' . $php . '-node' . $nodeMajor;

            $newWorkflow .= "          - '$tag'\n";

            exec("cp -a {$baseDir}template-{$image} {$baseDir}{$tag}");
            exec("mv {$baseDir}{$tag}/Dockerfile.tmpl {$baseDir}{$tag}/Dockerfile");

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
                'SURFPHAR_VERSION' => $versions['surfphar'],
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

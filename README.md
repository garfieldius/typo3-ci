# TYPO3 docker images for CI / CD

This contains a set of configurations to build docker images that are ready to
use for CI / CD or manual building, testing and deployment of TYPO3 projects.
They are all available freely at <https://hub.docker.com/garfieldius/typo3-ci>

There is no `:latest` tag on purpose; setting an explicit PHP + node.js version
is required when using them.

## Available Tags

* [PHP 7.3 / node 12](https://github.com/garfieldius/typo3-ci/blob/master/bionic-php7.3-node12/Dockerfile)
* [PHP 7.2 / node 12](https://github.com/garfieldius/typo3-ci/blob/master/bionic-php7.2-node12/Dockerfile)

* [PHP 7.3 / node 11](https://github.com/garfieldius/typo3-ci/blob/master/bionic-php7.3-node11/Dockerfile)
* [PHP 7.2 / node 11](https://github.com/garfieldius/typo3-ci/blob/master/bionic-php7.2-node11/Dockerfile)

* [PHP 7.3 / node 10](https://github.com/garfieldius/typo3-ci/blob/master/bionic-php7.3-node10/Dockerfile)
* [PHP 7.2 / node 10](https://github.com/garfieldius/typo3-ci/blob/master/bionic-php7.2-node10/Dockerfile)

## Building

Have docker ready and run `make` to build all images. They are tagged as
`garfieldius/typo3-ci:phpX-nodeY` by default. For local purposes, it may be
easier to remove the username from the tag or change the image name tag.
This can be done using the variable `IMAGE_TAG`.

Example: the following command will build and push the images into a local
registry, with a different user and image name:

```bash
export IMAGE_TAG="local.registry:5000/my-user/php-node"
# Builds and tags the images
make
# Push to local.registry:5000
make push
```

## License

[Apache 2.0](https://www.apache.org/licenses/LICENSE-2.0)

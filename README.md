# TYPO3 docker images for CI / CD

This contains a set of configurations to build docker images that are ready to
use for CI / CD or manual building, testing and deployment of TYPO3 projects.
They are all available freely at <https://hub.docker.com/r/garfieldius/typo3-ci>

There is no `:latest` tag on purpose; setting an explicit PHP + node.js version
is required when using them.

## Available Tags

[php7.2-node10](./php7.2-node10/Dockedrfile)
[php7.2-node12](./php7.2-node12/Dockedrfile)
[php7.2-node14](./php7.2-node14/Dockedrfile)
[php7.2-node16](./php7.2-node16/Dockedrfile)
[php7.4-node10](./php7.4-node10/Dockedrfile)
[php7.4-node14](./php7.4-node14/Dockedrfile)
[php7.4-node16](./php7.4-node16/Dockedrfile)
[php7.4-node18](./php7.4-node18/Dockedrfile)
[php8.0-node10](./php8.0-node10/Dockedrfile)
[php8.0-node14](./php8.0-node14/Dockedrfile)
[php8.0-node16](./php8.0-node16/Dockedrfile)
[php8.0-node18](./php8.0-node18/Dockedrfile)
[php8.1-node14](./php8.1-node14/Dockedrfile)
[php8.1-node16](./php8.1-node16/Dockedrfile)
[php8.1-node18](./php8.1-node18/Dockedrfile)
[php8.1-node20](./php8.1-node20/Dockedrfile)
[php8.1-node22](./php8.1-node22/Dockedrfile)
[php8.2-node14](./php8.2-node14/Dockedrfile)
[php8.2-node16](./php8.2-node16/Dockedrfile)
[php8.2-node18](./php8.2-node18/Dockedrfile)
[php8.2-node20](./php8.2-node20/Dockedrfile)
[php8.2-node22](./php8.2-node22/Dockedrfile)
[php8.3-node14](./php8.3-node14/Dockedrfile)
[php8.3-node16](./php8.3-node16/Dockedrfile)
[php8.3-node18](./php8.3-node18/Dockedrfile)
[php8.3-node20](./php8.3-node20/Dockedrfile)
[php8.3-node22](./php8.3-node22/Dockedrfile)

## Building

Have docker ready and run `make` to build all images. They are tagged as
`garfieldius/typo3-ci:phpX-nodeY` by default. To change repository and username
of the tag, set the environment variable `IMAGE_TAG` to the needed value.

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

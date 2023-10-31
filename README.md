# Installation

## Requirements

- [Docker](https://www.docker.com/)

## Usage

### Build

```bash 
docker build -t <image-name> .
```

### Run

```bash
docker run -it -p 8000:8000 -v ./app/:/app --name <container-name> <image-name>
```

### Stop

```bash
docker stop <container-name>
```

### Testing with PHPUnit

While in the container, run:

```bash
# If not configured yet
# phpunit --generate-configuration

phpunit --colors --testdox --coverage-html ./coverages tests
```
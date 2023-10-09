# Test

## Table of Contents

- [Installation](#installation)
- [Docker](#docker)


## Installation

### Requirements

Make sure you have the following prerequisites installed:

- PHP 8.2
- Make
- Docker

Follow these steps to set up and run the project locally:

1. Clone the repository:
   ```shell
   git clone git@github.com:SherzodAbdullajonov/Test_Laravel.git
2. Navigate to the project folder:
    ```shell
    cd Test_Laravel
3. Run the installation script:
    ```shell
    make install
### Docker
1. Build and start Docker containers:
    ```shell
    make start
2. Setup the project database:
    ```
    make migrate
3. Setup the testing database:
    ```shell
    make test-db

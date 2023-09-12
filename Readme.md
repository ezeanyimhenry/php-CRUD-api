# Person API

A RESTful API for managing "person" resources.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [API Endpoints](#api-endpoints)
  - [Create a New Person](#create-a-new-person)
  - [Retrieve a Person by ID](#retrieve-a-person-by-id)
  - [Update a Person by ID](#update-a-person-by-id)
  - [Delete a Person by ID](#delete-a-person-by-id)
- [Security](#security)
- [Contributing](#contributing)

## Prerequisites

Before you begin, make sure you have the following:

- PHP installed (version 7 or higher)
- MySQL or another database system installed and configured
- A web server (e.g., Apache or Nginx) to host the API

## Installation

1. Clone this repository to your local machine or server:

   ```shell
   git clone https://github.com/ezeanyimhenry/php-CRUD-api.git

2. Configure the database connection by editing config.php:

    ```shell
    $hostname = "your_database_host";
    $username = "your_database_username";
    $password = "your_database_password";
    $database = "your_database_name";
    ```

3. Import the SQL schema into your database to create the persons table.

```shell
    CREATE TABLE persons (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
    );
```

4. Ensure that your web server is correctly configured to serve PHP files.

## API Endpoints
### Create a New Person
#### URL: /api/persons.php

#### Method: POST

#### Request Body:

```shell
{
  "name": "John",
}
```
#### Response:

```shell
{
  "message": "Person created."
}
```
### Retrieve a Person by ID
#### URL: /api/persons.php?id={person_id}

#### Method: GET

#### Response:

```shell
{
  "id": 1,
  "name": "John",
}
```
### Update a Person by ID
#### URL: /api/persons.php?id={person_id}

#### Method: PUT

#### Request Body:

```shell
{
  "name": "Updated",
}
```
#### Responce:

```shell
{
  "message": "Person updated."
}
```
### Delete a Person by ID
#### URL: /api/persons.php?id={person_id}

#### Method: DELETE

#### Response:

```shell
{
  "message": "Person deleted."
}
```
### Security
Ensure that you implement proper authentication and authorization mechanisms based on your application requirements.
Sanitize user inputs and use prepared statements to prevent SQL injection attacks.
Contributing
Contributions are welcome! Feel free to submit issues or pull requests.

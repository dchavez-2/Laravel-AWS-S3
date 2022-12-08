# LARAVEL + AWS S3

## Used technologies

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)

This is a repository used as a model to establish a connection between Laravel and AWS S3 to send image files in the bucket.

## Prerequisites:

* Have an AWS account.
* Have a bucket created with in AWS.
* Define the environment variables in the .env file (AWS, DB).

## Commands to use:

**install dependencies:**

composer install

**Migrate DB:**

php artisan migrate

**Note:** it is important to have the database created and the configuration of the connection to the database.

**Execute:**

php artisan serve


## Endpoints

<details>

<br/>

### Photos Collections

```
GET    http://localhost:8000/api/photos                 // Search all records

POST   http://localhost:8000/api/photo                  // Add record 

POST     http://localhost:8000/api/update-photo         // Update record existing

POST  http://localhost:8000/api/delete-photo            // Delete record existing
```

In order to manage the **photos** we need to send you the following **params**:

### Create Photo
~~~
{
    "name": "" (string - required)
    "description": "" (string - required)
    "photo": "" (string support format images)
}
~~~

### Update Photo
~~~
{
    "id": "" (number-required)
    "name": "" (string - required)
    "description": "" (string - required)
    "photo": "" (string support format images)
}
~~~


### Delete Photo
~~~
{
    "id": "" (number-required)
}
~~~

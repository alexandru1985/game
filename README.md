<p align="center"><h1>System Manager API</h1></p>

## About Project

Tools: Laravel10, MySQL, Docker, Swagger</br>
Added features:
- DDD folder structure;
- repository pattern;
- form validations;
- CRUD endpoints to companies and stations modules;
- endpoint for filtering stations by company, locations and distance;
- unit tests;
- api documentation.

Each main task was split in subtasks. You can follow the working progress by seeing commits on this repository.

## Project Installation 

Copy project from GitHub 

```
git clone --recurse-submodules https://github.com/alexandru1985/system_manager.git
```
In the root folder of project, named system_manager, run command

```
./start.sh
```
Above command is enough regarding project installation. This will install Docker containers and run composer, and also will run migrations and seeders. For Docker containers, note that you must have about 7GB free space on your Docker application.

## API Interface

Run the following link in your browser

```
http://localhost/api/documentation
```

## Unit Testing

In the root folder of project, named system_manager, run commands one by one

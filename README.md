# Laravel Skeleton package

The package is based on the Repository-Service Laravel Pattern Package:

Package link: https://github.com/manowartop97/repository-service-laravel-pattern

## The package contains:

### Code generator feature

#### Allows generating Classes/Interfaces/Traits

`$template = new ClassTemplate();`

`$template->setType('class')->setName('ClassName')->setNamespace('Path\\To\\Class');`

It is possible define properties, methods, constants, extends, implements, doc block comments, create abstract/final
classes, set method body, etc...

#### Eloquent Model Generation Feature

Command `php artisan skeleton:model:generate tableName` - generates the model for the table, define all relations,
properties, define doc block with props annotations.

#### Repository-Service pattern files generation

Command `php artisan skeleton:repository-service:generate {table}` generates EntityRepositoryInterface &
EntityRepository and ServiceInterface & Service for Repository-Service Laravel Pattern Package.

#### Requests generation

Command `skeleton:request:generate {namespace} {modelNamespace?}` will generate a Request instance,

- `{namespace}` will specify the folder of the new request (e.g. `User\\StoreRequest` will create
  a `App\\Http\\Requests\\User\\StoreReqeust`);
- `{modelNamespace?}` - is optional param. e.g. `App\\Models\\ModelName` will generate request with rules for
  model `fillable` attributes;

#### Resource generation

Command `skeleton:resource:generate {table}` generates resource for a particular Model by table name

#### Api Resource Controller generation

Command `skeleton:resource-controller:generate {table}` will generate a resource controller for a particular Model
entity by table name;

The controller actions will be based on the Repository-Service laravel pattern package;

#### CRUD generation

Command `skeleton:crud:generate {table}` will generate the following instances:
 
- Model (if not exists)
- Repository Interface (if not exists)
- Repository (if not exists)
- Service Interface (if not exists)
- Service (if not exists)
- Resource (if not exists)
- StoreRequest and UpdateRequest (if not exists)
- Api Resource Controller (if not exists)

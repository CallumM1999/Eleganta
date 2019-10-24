# Documentation

## Setup

How to initially setup the project

    git clone https://github.com/CallumM1999/Eleganta.git

### Config

The config file can be found in __/Elegentia/app/config/config.php__.

Here, you can change the url root as well as set db config.

### .htaccess

Navigate to __/public/.htaccess__

    <IfModule mod_rewrite.c>
        Options -Multiviews
        RewriteEngine On
        RewriteBase /mvc/Elegenta/
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
    </IfModule>

You must change line 4:

    RewriteBase /mvc/public/

Change it to the relative path of your project. If you are installing it on a server, it should be __/public/__.

## Routes

At the base of the application is routes.php. The routes file allows you to define paths within your application.

Each route is build from the method, the path, and the controller.

### Route Methods

    Route::get('/settings', 'Base@settings');

Route accepts the following methods:

- Get
- Post
- Put
- Patch
- Delete
- Options

Those are specific methods. Another Route function is Match. Match will accept an array of route methods.

    Route::match(['get', 'post'], '/settings', 'Base@settings');

The final method is any, which accepts any method.

    Route::any('/settings', 'Base@settings');

### Route Paths

Asterisks accept any path.

    Route::get('*', 'Base@settings');

Paths can also accept multiple parameters, which will be returned in the __$params__ array.

    Route::get('/users/{id}', 'Base@settings');

### Route controller

The final part of a route is the controller. This can either reference a controller method, or it can be an inline function.

The first part references the controller, whereas the last section references the method.

    class Base extends \Controller {
        public function index() {
            $data = [
                "title" => "Eleganta",
                "copy" => "A simple PHP MVC framework."
            ];

            View::render('index', $data);
        }

Or as an inline function.

    Route::get('/settings', function($request, $response) {

        $data = [
            "title" => "Eleganta",
            "copy" => "A simple PHP MVC framework."
        ];

        View::render('settings');
    })

### Route Middleware

Route middleware is added between the path and the controller. Middleware has access to the __$request__ array, which will be passed down to the controller.

Middleware can eiither be an inline function, or in the Middleware class. There is no real function to the Middleware class, it's just a tidy location.

    Route::get('/settings', function($request) {
        // Do something
        return $request;
    },'Base@settings');

Or in the Middleware class.

    Route::get('/settings', Middleware::auth,'Base@settings');

## Controller

This is the layout for creating a controller.

__$request__ and __$params__ are passed into the method. The request array is used by middleware to pass data. The params array contains data from encoded URLs.

    namespace Controller;

    use \View as View;

    class Base extends \Controller {
        public function index($request, $params) {
            $data = [
                "title" => "Eleganta",
                "copy" => "A simple PHP MVC framework."
            ];

            View::render('index', $data);
        }
    }

## View

When creating a view, you can either use normal PHP, or use the templating engine. To use templating, you must name the file __view.tmp.php__

### Default view

Data can be passed through the controller. You can access it from the __$data__ array.

    <h1> <?= $data['title'] ?> </h1>

### Template View

#### Layout

When using templating, you have the option to use a template. A template is a reusable layout, that will accept child content. In the template, __@yield()__ defines where child content can go.

    <body>

        @include('inc.navbar')

        <div class="container">

            @yield('content')

        </div>
        
    </body>

In the child page, you  must use __@extends__. This defines the parent template, being the file path from __/views/__. So the parent template is found in __/views/inc/base.tmp.php__.

In the child template, you must define the content within __@section(__ tags. These tags correspond to the __@yield__ tags in the parent.

    @extends('inc.base')

    @section('content')

        <p>Hello World!</p>

    @endsection

If you want to include content from another template, you can use __@include__. This behaves like __require__ in PHP.

#### Logic

The templating language includes many methods typically found in PHP, but with a more friendly layout.

##### Echo

To echo data from __$data__, you can use the moustache syntax.

    <h1>{{ $title }}</h1>

##### If

    @if ($score > 6)
        <p>You Win</p>
    @else
        <p>You Lose</p>
    @endif

##### For

    @for($i = 0; $i < 10; $1++)
        <p>Num {{ $i }}</p>
    @endfor

##### Foreach

    @foreach($users as $key => $user) 
        <p>User: {{ $user['name'] }}
    @endforeach

##### Switch

    @switch($name)
        @case('callum')
            <p>Hello Callum</p>
            @break
        @default
            <p>Hello Guest</p>
    @endswitch

## Model

When creating a model, it shoud extend the BaseModel class. Within a model, you can create methods that interact with the database.

    namespace Model;

    class Base extends \BaseModel {

        public function getUsers() {
            $this->db->query('select * from user');

            $results = $this->db->resultSet();
    
            return $results;
        }   
    }

To access the model from a controller, you must add some code to the __construct method.

    public function __construct() {
        $this->baseModel = $this->model('Base');
    }

Now that the Base model is loaded, you can use it's methods.

    public function index() {
        $users = $this->baseModel->etUsers();

        $data = [
            "users" => $users
        ];

        View::render('index', $data);
    }

## Middleware

You can create middleware as an inline function within a Route, however, I recommend that you add the method to the Middleware class.

    abstract class Middleware {
        public static function auth($request) {
            $request['auth'] = true;
            
            return $request;
        }
    }

Middlware accepts only one parameter, __$request__. Request is used to pass data through middleware and to the controller, so you must return the $request array at the end.
# Eleganta

A simple PHP MVC framework.

## Table of contents

- [About](#About)
- [Featues](#Features)
- [Documentation](#Documentation)
- [What I learned](#What-I-learned)

## About

Eleganta is a simple PHP MVC framework. 
Eleganta also comes with a custom templating engine to make building pages easier.

Eleganta was creating as a learning exercise. I first learned PHP from this [Object Oriented PHP](https://www.udemy.com/course/object-oriented-php-mvc/) Course. During the course, I build a PHP framework. I wanted to improve the framework, as well as consolidate what I learned in the course.

Link to project built with framework.

## Features

- Flexible user defined routes
- Route methods that support different request methods, and URL parameters.
- Middleware
- Templating engine
- MVC design pattern

## Documentation

Click here for [Documentation](https://github.com/thecallum/Eleganta/blob/master/DOCUMENTATION.md).

## What I learned

[Kort](https://github.com/thecallum/kort) is a website that I build with Elegenta. Here is what I learned after building the site.

### Error handing

The first issue I had was no error handling. I would do code something incorrectly, but the error message would be generic and unhelpful. It would have been incredibly helpful if error messages could be more specific.

### Features

There were many features that the framework could have benefited from. For example, controllers should automatically allow separate methods for different request methods. I found that I would need a get route and a post route.

However, the point of this project was to learn how a framework works before I learn one. If I had known about these issues, it would have defeated the point of the project.

### Template Engine

I found that I had massively underestimated the complexity needed to build a templating engine. I found an easy way, using __eval()__. Here is the markup used by the templating engine.

    @if()
        <p>hello</p>
    @endif

The templating engine would find the markup, and then replace it with valid PHP.

    <?php if(): ?>
        <p>hello</p>
    <?php endif; ?>

Although this method was easier, it also had many scoping issues. I also discovered that __eval()__ was a security risk, since it is executing code.

The investment needed to build a fully functioning and secure templating engine is greater than what I would get from it. If I was to build another framework, I would use an open-source templating engine such as Blade.

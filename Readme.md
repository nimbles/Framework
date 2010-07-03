Mu Framework
============

A framework design for and written in PHP 5.3, taking advantages of the latest features; [namespaces](http://www.php.net/manual/en/language.namespaces.php), [closures](http://www.php.net/manual/en/functions.anonymous.php), [late static binding](http://www.php.net/manual/en/language.oop5.late-static-bindings.php).

Design Principles
-----------------

### Fast

- light weight
- minimal amount of bootstrapping

### Reusable

- component / package based
- using the [DRY principle](http://en.wikipedia.org/wiki/Don%27t_repeat_yourself) by supporting basic mixins

### Flexible

 - MVC approach to multiple request types; Http, Cli etc.
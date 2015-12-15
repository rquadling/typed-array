[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/rquadling/typed-array.svg?style=plastic)](https://scrutinizer-ci.com/g/rquadling/typed-array/?branch=master)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/rquadling/typed-array.svg?style=plastic)](https://scrutinizer-ci.com/coverage/g/rquadling/typed-array/?branch=master)
[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/rquadling/typed-array.svg?style=plastic)](https://scrutinizer-ci.com/build/g/rquadling/typed-array/?branch=master)

[![Travid Build Status](https://img.shields.io/travis/rquadling/typed-array.svg?style=plastic)](https://travis-ci.org/rquadling/typed-array)

[![Latest Stable Version](https://img.shields.io/packagist/v/rquadling/typed-array.svg?style=plastic)](https://packagist.org/packages/rquadling/typed-array)
[![Packagist](https://img.shields.io/packagist/dt/rquadling/typed-array.svg?style=plastic)](https://packagist.org/packages/rquadling/typed-array)

Richard Quadling's TypedArray
=============================

A `\RQuadling\TypedArray` allows you to have an array of non-scalar types enforced to a single type.

```php
<?php
class ItemCollection extends \RQuadling\TypedArray
{
    const ARRAY_TYPE = 'Item';
}
```

Now you can call `$myItems = new ItemCollection;`. You can supply an array of `Item`, or another collection of `Item`s.

If you want to copy a collection, you will need to `clone` it.

If you want to add functionality to your collections, then create an abstract subclass with that functionality.

```php
<?php
abstract class Collections extends \RQuadling\TypedArray
{
    /**
     * @param callable $callable
     * @return $this
     */
    public function each(callable $callable)
    {
        foreach ($this as $key => $value) {
            $callable($value, $key);
        }

        return $this;
    }
}

class ItemCollection extends Collections
{
    const ARRAY_TYPE = 'Item';
}
```

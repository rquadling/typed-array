[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rquadling/typed-array/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rquadling/typed-array/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/rquadling/typed-array/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/rquadling/typed-array/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/rquadling/typed-array/badges/build.png?b=master)](https://scrutinizer-ci.com/g/rquadling/typed-array/build-status/master)
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

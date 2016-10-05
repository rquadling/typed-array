<?php

namespace RQuadling\TypedArray;

use PHPUnit_Framework_TestCase;

class TypedArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage EmptyArrayType::ARRAY_TYPE must be set to a valid class.
     * @group generatesException
     */
    public function testEmptyArrayTypeThrowsException()
    {
        new EmptyArrayType();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage NullArrayType::ARRAY_TYPE must be set to a valid class.
     * @group generatesException
     */
    public function testNullArrayTypeThrowsException()
    {
        new NullArrayType();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage \NonExistentClass does not exist for RQuadling\TypedArray\NonExistentClassArrayType::ARRAY_TYPE
     * @group generatesException
     */
    public function testNonExistentClassArrayTypeThrowsException()
    {
        new NonExistentClassArrayType();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $input must be an array or an object that implements \Traversable.
     * @group generatesException
     */
    public function testNonArrayStyleInputThrowsException()
    {
        new Collection(M_PI);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Non object of type 'double' supplied. Wanted object of type 'RQuadling\TypedArray\Item'.
     * @group generatesException
     */
    public function testArrayOfNonObjectInputThrowsException()
    {
        new Collection([M_PI]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Object of class 'RQuadling\TypedArray\Collection' supplied. Wanted object of type 'RQuadling\TypedArray\Item'.
     * @group generatesException
     */
    public function testArrayOfMismatchedObjectsForInputThrowsException()
    {
        new Collection([new Collection()]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Non object of type 'double' supplied. Wanted object of type 'RQuadling\TypedArray\Item'.
     * @group generatesException
     */
    public function testAddingInvalidTypeToEmptyArrayThrowsException()
    {
        $collection = new Collection();
        $collection[] = M_PI;
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Object of class 'RQuadling\TypedArray\Collection' supplied. Wanted object of type 'RQuadling\TypedArray\Item'.
     * @group generatesException
     */
    public function testAddingInvalidClassOfObjectToEmptyArrayThrowsException()
    {
        $collection = new Collection();
        $collection[] = new Collection();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Non object of type 'double' supplied. Wanted object of type 'RQuadling\TypedArray\Item'.
     * @group generatesException
     */
    public function testAddingInvalidTypeToNonEmptyArrayThrowsException()
    {
        $collection = new Collection([new Item()]);
        $collection[] = M_PI;
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Object of class 'RQuadling\TypedArray\Collection' supplied. Wanted object of type 'RQuadling\TypedArray\Item'.
     * @group generatesException
     */
    public function testAddingInvalidClassOfObjectToNonEmptyArrayThrowsException()
    {
        $collection = new Collection([new Item()]);
        $collection[] = new Collection();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $input must be an array or an object that implements \Traversable.
     * @group generatesException
     */
    public function testNonTraversableObjectAsInputThrowsException()
    {
        new Collections(new Item());
    }

    /**
     * @group successes
     */
    public function testNoExceptionsAreThrownWithNoInput()
    {
        $exception = null;
        try {
            new Collection();
        } catch (\Exception $exception) {
        }

        $this->assertNull($exception, 'Unexpected exception when creating collection with no input');
    }

    /**
     * @group successes
     */
    public function testNoExceptionsAreThrownWithValidArrayInput()
    {
        $exception = null;
        try {
            new Collection([new Item()]);
        } catch (\Exception $exception) {
        }

        $this->assertNull($exception, 'Unexpected exception when creating collection with valid array input');
    }

    /**
     * @group successes
     */
    public function testNoExceptionsAreThrowWithValidTraversableInput()
    {
        $existingCollection = new Collection([new Item()]);
        $newCollection = null;
        $exception = null;
        try {
            $newCollection = new Collections($existingCollection);
        } catch (\Exception $exception) {
        }

        $this->assertNull($exception, 'Unexpected exception when creating collection with valid traversable input');
        $this->assertSame($existingCollection[0], $newCollection[0], 'Unexpected mismatch between non-cloned items');
    }

    /**
     * @group successes
     */
    public function testNoExceptionsAreThrowWithValidClonedTraversableInput()
    {
        $existingCollection = new Collection([new Item()]);
        $newCollection = null;
        $exception = null;
        try {
            $newCollection = new Collections(clone $existingCollection);
        } catch (\Exception $exception) {
        }

        $this->assertNull($exception, 'Unexpected exception when creating collection with valid traversable input');
        $this->assertNotSame($existingCollection[0], $newCollection[0], 'Unexpected match between cloned items');
    }
}

class EmptyArrayType extends TypedArray
{
    const ARRAY_TYPE = '';
}

class NullArrayType extends TypedArray
{
    const ARRAY_TYPE = null;
}

class NonExistentClassArrayType extends TypedArray
{
    const ARRAY_TYPE = '\NonExistentClass';
}

class Item
{
}

class Collection extends TypedArray
{
    const ARRAY_TYPE = 'RQuadling\TypedArray\Item';
}

class Collections extends TypedArray
{
    const ARRAY_TYPE = 'RQuadling\TypedArray\Item';
}

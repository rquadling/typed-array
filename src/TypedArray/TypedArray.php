<?php

namespace RQuadling\TypedArray;

/**
 * Class TypedArray.
 *
 * @todo Implement a 'clone by default' mechanism
 */
abstract class TypedArray extends \ArrayObject
{
    /**
     * Define the class that will be used for all items in the array.
     * To be defined in each sub-class.
     */
    const ARRAY_TYPE = null;

    /**
     * Define the type of element for the array.
     */
    private $arrayType;

    /**
     * TypedArray constructor.
     *
     * @param array|object $input          The input parameter accepts an array or an Object
     * @param int          $flags          Flags to control the behaviour of the ArrayObject object
     * @param string       $iterator_class Specify the class that will be used for iteration of the ArrayObject object. ArrayIterator is the default class used
     */
    public function __construct($input = [], $flags = 0, $iterator_class = 'ArrayIterator')
    {
        /*
         * Validate that the subclass has correctly defined an ARRAY_TYPE.
         */
        $this->arrayType = static::ARRAY_TYPE;

        if (empty($this->arrayType)) {
            throw new \RuntimeException(
                sprintf(
                    '%s::ARRAY_TYPE must be set to a valid class.',
                    get_called_class()
                )
            );
        }

        if (!class_exists($this->arrayType)) {
            throw new \RuntimeException(
                sprintf(
                    '%s does not exist for %s::ARRAY_TYPE',
                    $this->arrayType,
                    get_called_class()
                )
            );
        }

        /*
         * Validate that the input is an array or an object with an Traversable interface.
         */
        if (!(is_array($input) || (is_object($input) && in_array('Traversable', class_implements($input))))) {
            throw new \InvalidArgumentException('$input must be an array or an object that implements \Traversable.');
        }

        /*
         * Create an empty array.
         */
        parent::__construct([], $flags, $iterator_class);

        /*
         * Append each item so to validate it's type.
         */
        foreach ($input as $key => $value) {
            $this[$key] = $value;
        }
    }

    /**
     * Clone a collection by cloning all items.
     */
    public function __clone()
    {
        foreach ($this as $key => $value) {
            $this[$key] = clone $value;
        }
    }

    /**
     * Check the type and then store the value.
     *
     * @param int|null $offset The offset to store the value at or null to append the value
     * @param mixed    $value  The value to store
     */
    public function offsetSet($offset, $value)
    {
        /*
         * The value must be an object.
         */
        if (!is_object($value)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Non object of type '%s' supplied. Wanted object of type '%s'.",
                    gettype($value),
                    $this->arrayType
                )
            );
        }

        /**
         * The value must be an instance of the $this->arrayType.
         */
        if (!($value instanceof $this->arrayType)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Object of class '%s' supplied. Wanted object of type '%s'.",
                    get_class($value),
                    $this->arrayType
                )
            );
        }

        parent::offsetSet($offset, $value);
    }
}

<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

/**
 * Class Item.
 *
 * A simple item.
 */
class Item
{
    public $position;
}

/**
 * Class ItemCollection.
 *
 * A simple collection of items.
 */
class ItemCollection extends \RQuadling\TypedArray\TypedArray
{
    const ARRAY_TYPE = 'Item';
}

/**
 * Class Collections.
 *
 * An example abstract collections class that implements an each() method.
 */
abstract class Collections extends \RQuadling\TypedArray\TypedArray
{
    /**
     * @param callable $callable
     *
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

/**
 * Class ItemCollectionEx.
 *
 * A extended collection of items.
 */
class ItemCollectionEx extends Collections
{
    const ARRAY_TYPE = 'Item';
}

/**
 * Create a new item collection and add a second item to it.
 */
$items = new ItemCollection([new Item()]);
$items[] = new Item();

/**
 * Create an extended collection and add a second item to it.
 */
$itemsEx = new ItemCollectionEx([new Item()]);
$itemsEx[] = new Item();

/*
 * Use the each() method to set the position property in the item.
 */
$itemsEx->each(function (Item $item, $key) {
    $item->position = $key;
});

/**
 * Clone the extended items collection.
 */
$itemsEx2 = clone $itemsEx;

/*
 * Use the each() method to make further changes to the position property of
 * the cloned collection.
 */
$itemsEx2->each(function (Item $item, $key) {
    $item->position += $key;
});

/**
 * Make a new simple collection using the same items as the cloned collection.
 */
$items2 = new ItemCollection($itemsEx2);

/*
 * Show the results of all of this work.
 *
 * Pay special attention to the object #'s.
 */

/*
 * Firstly the simple collection #2[#3, #4]
 */
var_dump($items);

/*
 * Secondly the extended collection #5[#6, #7]
 */
var_dump($itemsEx);

/*
 * Thirdly, the cloned extended collection #8[#11, #12]
 */
var_dump($itemsEx2);

/*
 * Finally, the copied simple collection #9[#11, #12]
 *
 * NOTE: These items are the same ones as in $itemsEx2.
 */
var_dump($items2);

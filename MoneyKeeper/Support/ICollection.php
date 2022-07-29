<?php
namespace MoneyKeeper\Support;
use Countable, ArrayAccess, IteratorAggregate;

/**
 * Interface for collections
 * it is compatible with Illuminate\Support\Collection
 */
interface ICollection extends ArrayAccess, Countable, IteratorAggregate {

}
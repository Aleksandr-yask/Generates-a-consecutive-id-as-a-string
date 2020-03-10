# Generates-a-consecutive-id-as-a-string
Generates a consecutive id as a string
Generates a consecutive id as a string.
$keys - an array with valid values in order.
***
If the ID length is less than 3, the usual string is returned.
But.
If the ID length is longer than 2, the shortened line is returned as {number of items}_{item}.
***
Examples:
```php
$gen = new AutoGen();
echo $gen->getId(''); // a (first element in an array)
echo $gen->getId('F'); // G (After F in the array goes G)
echo $gen->getId('998'); // 3_9 (After 8 goes 9 as the ID length over 2 IDs is reduced)
echo $gen->getId('3_9'); // 3_9a
```

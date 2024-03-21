# ParseCsv

> :warning: **This is the old unsupported master branch**: You should not be referencing this branch directly, and it only exists for projects still referencing `dev-master`.

Extend PHP's native CSV parsing from the [SplFileObject](https://secure.php.net/manual/en/class.splfileobject.php) class
 but provide features to use the first row's values as keys on the remaining rows.

There are other libraries which accomplish the similar thing, but they are memory inefficient and rely on their own (sometimes buggy) parsing implementation.

```php
<?php
$oCsv = new ParseCsv('users.csv');
$oCsv->firstRowHeader();

foreach($oCsv as $aRow) {
    print_r($aRow);
}
```

Given the example users.csv file:
```
id,firstName
11,Billy
```

The resulting output will be:
```
Array
(
    [id] => 11
    [firstName] => Billy
)
```

## Install

```bash
$ composer require bluefrg/parsecsv:dev-master
```
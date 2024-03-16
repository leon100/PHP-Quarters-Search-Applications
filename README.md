# PHP Quarters Search Applications

These PHP applications are designed to search for all occurrences and the first occurrence with minimum distance between quarters. The applications are developed by Ihor Leontiuk.

## Scripts

- `SearchAllMinDistances.php`: This script searches for all occurrences with minimum distance between quarters.
- `SearchFirstMinDistance.php`: This script searches for the first occurrence with minimum distance between quarters.

## Features

- Search quarters with zero distance between quarters.
- Search quarters from one distance between quarters.
- Add an existence flag to quarters if a new matching property is found.

## Functions

- `execute(array $quarters)`: This function is the main entry point of the application. It takes an array of quarters as input and returns an array of results or an integer depending on the script. If the quarters array is empty, it throws an exception.
- `searchQuarterWithZeroDistance(int $numQuarters, array $properties, array $quarters)`: This function searches quarters with zero distance between quarters. It returns an array of results or an integer depending on the script.
- `searchQuarterFromOneDistance(int $numQuarters, array $properties, array $quarters)`: This function searches quarters from one distance between quarters. It returns an array of results or an integer depending on the script.
- `addExistenceFlag(array $properties, array &$quarters, int $currentQuarter, int $pointer)`: This function adds an existence flag to quarters if a new matching property is found.

## Usage

To use these applications, you need to have PHP installed on your machine. You can run the applications by using the PHP CLI (Command Line Interface) and passing the script file name:

```bash
php SearchAllMinDistances.php
php SearchFirstMinDistance.php

//Input Example
$blocks = [
    [
        "school" => true,
        "gym" => false,
        "store" => false,
    ],
    [
        "school" => false,
        "gym" => true,
        "store" => false,
    ],
    [
        "school" => false,
        "gym" => false,
        "store" => true,
    ],
    [
        "school" => false,
        "gym" => false,
        "store" => false,
    ],
    [
        "school" => false,
        "gym" => true,
        "store" => true,
    ],
];

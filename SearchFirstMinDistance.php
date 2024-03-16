<?php
/**
 * Copyright © Ihor Leontiuk. All rights reserved.
 */
declare(strict_types=1);

const EXISTENCE_FLAG = 1;

/**
 * Search for first occurrence (key) with min distance between quarters.
 *
 * @param array $quarters
 * @return int
 * @throws Exception
 */
function execute(array $quarters): int
{
    $numQuarters = count($quarters);
    if ($numQuarters === 0) {
        throw new Exception('Empty $quarters');
    }
    $properties = array_keys($quarters[0]);

    $result = searchQuarterWithZeroDistance($numQuarters, $properties, $quarters);
    if (is_int($result)) {
        return $result;
    }
    $result = searchQuarterFromOneDistance($numQuarters, $properties, $quarters);
    if (is_int($result)) {
        return $result;
    }
    throw new Exception("Some properties don't exist.");
}

/**
 * Search for first quarter with 0 distance between quarters
 *
 * @param int $numQuarters
 * @param array $properties
 * @param array $quarters
 * @return int|null
 */
function searchQuarterWithZeroDistance(int $numQuarters, array $properties, array $quarters): ?int
{
    for ($currentQuarter = 0; $currentQuarter < $numQuarters; $currentQuarter++) {
        foreach ($properties as $property) {
            if ($quarters[$currentQuarter][$property] === false) {
                continue 2;
            }
        }
        //Found a quarter with all the properties at a 0 distance
        return $currentQuarter;
    }
    return null;
}

/**
 * Search for first quarter starting from 1 distance between quarters
 *
 * @param int $numQuarters
 * @param array $properties
 * @param array $quarters
 * @return int|null
 */
function searchQuarterFromOneDistance(int $numQuarters, array $properties, array $quarters): ?int
{
    for ($distance = 1; $distance < $numQuarters; $distance++) {
        for ($currentQuarter = 0; $currentQuarter < $numQuarters; $currentQuarter++) {
            //Check the block that is $distance to the left of the current one
            $prev = $currentQuarter - $distance;
            if ($prev >= 0) {
                addExistenceFlag($properties, $quarters, $currentQuarter, $prev);
            }

            //Check the block that is $distance to the right of the current one
            $next = $currentQuarter + $distance;
            if ($next < $numQuarters) {
                addExistenceFlag($properties, $quarters, $currentQuarter, $next);
            }

            //Check a quarter with all the properties at a minimum distance
            if (!in_array(false, $quarters[$currentQuarter])) {
                return $currentQuarter;
            }
        }
    }
    return null;
}

/**
 * Add an existence flag to $quarters if a new matching property is found.
 *
 * @param array $properties
 * @param array $quarters
 * @param int $currentQuarter
 * @param int $pointer
 * @return void
 */
function addExistenceFlag(array $properties, array &$quarters, int $currentQuarter, int $pointer): void
{
    foreach ($properties as $property) {
        if ($quarters[$currentQuarter][$property] === false
            && $quarters[$pointer][$property] === true) {
            $quarters[$currentQuarter][$property] = EXISTENCE_FLAG;
        }
    }
}

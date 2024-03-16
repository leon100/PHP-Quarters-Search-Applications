<?php
/**
 * Copyright © Ihor Leontiuk. All rights reserved.
 */
declare(strict_types=1);

const EXISTENCE_FLAG = 1;

/**
 * Search for all occurrences with min distance between quarters.
 *
 * @param array $quarters
 * @return array
 * @throws Exception
 */
function execute(array $quarters): array
{
    $numQuarters = count($quarters);
    if ($numQuarters === 0) {
        throw new Exception('Empty $quarters');
    }
    $properties = array_keys($quarters[0]);

    if ($result = searchQuartersWithZeroDistance($numQuarters, $properties, $quarters)) {
        return $result;
    }
    if ($result = searchQuartersFromOneDistance($numQuarters, $properties, $quarters)) {
        return $result;
    }
    throw new Exception("Some properties does not exist.");
}

/**
 * Search quarters with 0 distance between quarters
 *
 * @param int $numQuarters
 * @param array $properties
 * @param array $quarters
 * @return array
 */
function searchQuartersWithZeroDistance(int $numQuarters, array $properties, array $quarters): array
{
    $result = [];
    for ($currentQuarter = 0; $currentQuarter < $numQuarters; $currentQuarter++) {
        foreach ($properties as $property) {
            if ($quarters[$currentQuarter][$property] === false) {
                continue 2;
            }
        }
        //Found a quarters with all the properties at a 0 distance
        $result[] = $currentQuarter;
    }
    return $result;
}

/**
 * Search quarters from 1 distance between quarters
 *
 * @param int $numQuarters
 * @param array $properties
 * @param array $quarters
 * @return array|null
 */
function searchQuartersFromOneDistance(int $numQuarters, array $properties, array $quarters) : ?array
{
    $result = [];
    for ($distance = 1; $distance < $numQuarters; $distance++) {
        for ($currentQuarter = 0; $currentQuarter < $numQuarters; $currentQuarter++) {
            // Check the block that is $distance to the left of the current one
            $prev = $currentQuarter - $distance;
            if ($prev >= 0) {
                addExistenceFlag($properties, $quarters, $currentQuarter, $prev);
            }

            // Check the block that is $distance to the right of the current one
            $next = $currentQuarter + $distance;
            if ($next < $numQuarters) {
                addExistenceFlag($properties, $quarters, $currentQuarter, $next);
            }

            // Check a quarter with all the properties at a minimum distance
            if (!in_array(false, $quarters[$currentQuarter])) {
                $result[] = $currentQuarter;
            }
        }
        if ($result) {
            return $result;
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

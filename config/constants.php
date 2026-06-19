<?php

return [
    'colors' => [
        'red' => 'red',
        'blue' => 'blue',
        'green' => 'green',
        'black' => 'black',
        'white' => 'white',
        'silver' => 'silver',
        'gray' => 'gray',
        'yellow' => 'yellow',
        'orange' => 'orange',
        'brown' => 'brown',
        'purple' => 'purple',
        'gold' => 'gold',
    ],

    'car_types' => [
        'Bus' => 'Bus',
        'Heavy Equipment' => 'Heavy Equipment',
        'Motorcycle' => 'Motorcycle',
        'Pickup' => 'Pickup',
        'Private' => 'Private',
        'Taxi' => 'Taxi',
        'Truck' => 'Truck',
        'VAN' => 'VAN',
    ],

    'fuel_types' => [
        '91' => '91',
        '95' => '95',
        'Diesel' => 'Diesel',
    ],

    'washing_types' => [
        'Automatic' => 'Automatic',
        'Manual' => 'Manual',
        'Steam' => 'Steam',
        'Touchless' => 'Touchless',
        'Foam' => 'Foam',
        'Waterless' => 'Waterless',
        'Self-Service' => 'Self-Service',
    ],

    'status' => [
        'available' => 'Available',
        'sold' => 'Sold',
        'reserved' => 'Reserved',
    ],

    'mileage_units' => [
        'km' => 'Kilometers',
        'mi' => 'Miles',
    ],

    'transmission_types' => [
        'manual' => 'Manual',
        'automatic' => 'Automatic',
        'semi_automatic' => 'Semi-Automatic',
    ],

    'drive_types' => [
        'fwd' => 'Front-Wheel Drive',
        'rwd' => 'Rear-Wheel Drive',
        'awd' => 'All-Wheel Drive',
        '4wd' => 'Four-Wheel Drive',
    ],

    'vehicle_types' => [
        'sedan' => 'Sedan',
        'suv' => 'SUV',
        'truck' => 'Truck',
        'coupe' => 'Coupe',
        'hatchback' => 'Hatchback',
        'convertible' => 'Convertible',
        'wagon' => 'Wagon',
        'van' => 'Van',
        'pickup' => 'Pickup',
    ],

    'year_range' => [
        '1900' => '1900',
        '2024' => '2024',
        // You can specify the range of years available for filtering
    ],

    'price_range' => [
        'min' => 0,
        'max' => 1000000, // Example: You can change the max limit according to your business needs
    ],

    'car_conditions' => [
        'new' => 'New',
        'used' => 'Used',
        'certified_pre_owned' => 'Certified Pre-Owned',
    ],

    // Optional: Common API response constants or messages
    'response_messages' => [
        'success' => 'Operation completed successfully.',
        'error' => 'There was an error with the operation.',
        'car_not_found' => 'Car not found.',
        'car_created' => 'Car successfully created.',
        'car_updated' => 'Car successfully updated.',
        'car_deleted' => 'Car successfully deleted.',
    ],
];

<?php
// <- Preparation - Make sure you can run this file and you have an endpoint created at

// <- STEP 1 - add libraries using composer in the root of the folder not this file ->

// <- STEP 2 - include the autoloader created by composer ->

// <- STEP 3 - Include libraries required (These should be in the vendor directory and loaded but the autoload.php) ->

// Open a YAML file
$config = Yaml::parseFile('.config.yml');

// Load the csv file into a variable.
$csv = Reader::createFromPath($config['csv_file'])
    ->setHeaderOffset(0);

// Create a new client object.
$client = new Client();

// Loop over the CSV and send the data to an endpoint.
foreach ($csv as $record ) {
    $response = $client->request('POST', $config['endpoint'], [
        'http_errors' => false,
        'body' => json_encode($record)
    ]);

    if( $response->getStatusCode() == 200) {
        print($record['first_name']) . " has been sent!<br />";
    }
    else{
        print 'Error sending ' . $record['first_name']. ' ' . $response->getStatusCode() . '<br />';
    }
}

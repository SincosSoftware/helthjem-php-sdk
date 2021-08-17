Helthjem PHP SDK

A barebones php implementation of some of Helthjems's API's.

Usage example: 

    $client = new Client(
        new GuzzleClient([GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => 2.0])
    );
        
    $configuration = new Configuration();
    $authTokenRequest = new AuthTokenRequest($configuration);
    $token = $client->send($authTokenRequest);

    $address = Address::fromArray([
        "countryCode" => 'NO',
        "postalName" => 'Oslo',
        "zipCode" => '0468',
        "streetAddress" => 'Moldegata 5'
    ]);

    $singleAddressCheckRequest = new SingleAddressCheckRequest($token, $configuration, $address);
    $nearbyServicePointRequest = new NearbyServicepointRequest($token, $configuration, $address);

    $singleAddressCheck = $client->send($singleAddressCheckRequest);
    $nearbyServicePoint = $client->send($nearbyServicePointRequest);
    
Created by 24nettbutikk.no

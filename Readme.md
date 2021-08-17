Helthjem PHP SDK

A barebones php implementation of some of Helthjems's API's.

Usage example: 

    $configuration = new Configuration();
    
    $requestHandler = new RequestHandler(
        new GuzzleClient([GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => 2.0])
    );
    
    $token = $requestHandler->send(
        new AuthTokenRequest($configuration)
    );

    $address = Address::fromArray([
        "countryCode" => 'NO',
        "postalName" => 'Oslo',
        "zipCode" => '0468',
        "streetAddress" => 'Moldegata 5'
    ]);

    $singleAddressCheckRequest = new SingleAddressCheckRequest($token, $configuration, $address);
    $nearbyServicePointRequest = new NearbyServicepointRequest($token, $configuration, $address);

    $singleAddressCheck = $requestHandler->send($singleAddressCheckRequest);
    $nearbyServicePoint = $requestHandler->send($nearbyServicePointRequest);
    
Created by 24nettbutikk.no

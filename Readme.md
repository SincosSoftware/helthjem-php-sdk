Helthjem PHP SDK

A barebones php implementation of some of Helthjems's API's.

Usage example: 

    $client = new Client(
        new GuzzleClient([GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => 1.5])
    );
    
    $countryCode = 'NO';
    $street = 'Moldegata 5';
    $zip = '0468';
    $city = 'Oslo';

    $authTokenRequest = new AuthTokenRequest($configuration);
    $token = $client->send($authTokenRequest);

    $singleAddressCheckAddress = SingleAddressCheckAddress::fromArray([
        "countryCode" => $countryCode,
        "postalName" => $city,
        "zipCode" => $zip,
        "address" => $street
    ]);
    $nearbyServicePointAddress = NearbyServicepointAddress::fromArray([
        "countryCode" => $countryCode,
        "postalName" => $city,
        "zipCode" => $zip,
        "streetAddress" => $street,
    ]);

    $singleAddressCheckRequest = new SingleAddressCheckRequest($token, ConfigurationInterface, $singleAddressCheckAddress);
    $singleAddressCheck = $client->send($singleAddressCheckRequest);

    $nearbyServicePointRequest = new NearbyServicepointRequest($token, ConfigurationInterface, $nearbyServicePointAddress);
    $nearbyServicePoint = $client->send($nearbyServicePointRequest);
    
Created by 24nettbutikk.no

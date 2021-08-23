Helthjem PHP SDK

A simple PHP implementation of some Helthjem API's.

Supported endpoints:
- Authentication V3 (https://jira-di.atlassian.net/wiki/spaces/DIPUB/pages/1501069392/LoginV3)
- SingleAddressCheck (https://jira-di.atlassian.net/wiki/spaces/DIPUB/pages/90639259/Parcel+Single+Address+Check+API)
- NearbyServicePoints (https://jira-di.atlassian.net/wiki/spaces/DIPUB/pages/1413251073/Parcel+Nearby+Servicepoint+API)


Usage example: 

    $client = new HelthjemSDK\Shared\RequestHandler(
        new GuzzleHttp\Client([GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => 1.0])
    );

    // some implementation of HelthjemSDK\Shared\Interfaces\Configuration
    $configuration = new Configuration();

    $address = HelthjemSDK\Shared\Address::fromArray([
        "countryCode" => 'NO',
        "city" => 'Oslo',
        "zipCode" => '0468',
        "streetAddress" => 'Moldegata 5'
    ]);

    $authTokenRequest = new HelthjemSDK\Authentication\AuthTokenRequest($configuration);
    $token = $client->send($authTokenRequest);

    $singleAddressCheckRequest = new HelthjemSDK\SingleAddressCheck\SingleAddressCheckRequest($token, $configuration, $address);
    $singleAddressCheck = $client->send($singleAddressCheckRequest);

    $nearbyServicePointRequest = new HelthjemSDK\NearbyServicepoint\NearbyServicepointRequest($token, $configuration, $address);
    $nearbyServicePoints = $client->send($nearbyServicePointRequest);

Created by 24nettbutikk.no

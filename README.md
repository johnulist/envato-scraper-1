# PHP Library to scrape data from the Envato marketplace websites.

This is a simple PHP library to connect and communicate with the Envato API. This library will allow you to execute all ```POST```, ```PUT```, ```GET``` and ```DELETE``` commands in the API using simple routes.

## Install the library

You can easily install the library trough composer by executing ```composer require smafe/envato-api```

This library has no dependencies and will function all by its own.

## Initiate the library

You can easily initiate the library by including the composer ```autoload.php``` in your code and then do the following.

```
$envato = new \Smafe\Envato( array(
  'api_id' => 'ENVATO APP ID'
, 'api_secret' => 'ENVATO SECRET KEY'
, 'api_redirect' => 'APP REDIRECT URI'
, 'api_token' => 'APP TOKEN'
, 'api_refresh_token' => 'PRE-EXISTING USER REFRESH TOKEN'
) );
```

**api_id**

The application ID you got when you created the application with Envato.

**api_secret**

The secret key you got when you generated the applicated with Envato.

**api_redirect**

The redirect URI where the app will go when you authorize your Envato account. This has to match the URI registered with the application at Envato.

**api_token**

The app token is the same as your "Personal token" with Envato. You can use this to access the API directly without logging in. This is useful when your only accessing your own account and dont require the user to authenticate with their own Envato account.

**api_refresh_token**

When a user login for the first time, you are given a "refresh token", this refresh token can be used to generate a new access token when it expires without having the user login again. By defining this, then the system will generate a new access token based on the request key and invoke the function ```saveAccessToken()```

## Working example
This is a complete working example using the Envato API that should work out of the box :)

```
$envato = new \Smafe\Envato( array(
  'api_id' => 'ENVATO APP ID'
, 'api_secret' => 'ENVATO SECRET KEY'
, 'api_redirect' => 'APP REDIRECT URI'
, 'api_token' => 'APP TOKEN'
) );

$request = $envato->request( 'v3/market/catalog/item?id=13041404' );

print_r( $request );
```


# Documentation

You can read more and find a complete demo at https://envato-api.demo.smafe.com/, this demo is running an exact version of what you will find in this library.

## Credits

This Envato API library is written and maintained by [Smafe Web Solutions](https://www.smafe.com/). If you have any questions, concerns or suggestions, please dont hestiate to [contact us](https://www.smafe.com/#contact).

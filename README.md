# Facebook PHP SDK Laravel package

A wrapper for the Facebook PHP SDK to work nicely with Laravel 4 or 5.

## Installation

Add this package’s name to your Composer manifest:

    "require": {
        "martinbean/facebook-php-sdk-laravel": "0.2.*"
    }

## Usage

Simply use the `FacebookRedirectLoginHelper` class bundled in this package
instead of the one in the Facebook PHP SDK. You can then use it as normal in
your controllers:

```php
<?php

use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphUser;
use MartinBean\Facebook\Laravel\FacebookRedirectLoginHelper;

class FacebookController extends BaseController {

	public function redirect()
	{
		FacebookSession::setDefaultApplication(
			Config::get('services.facebook.client_id'),
			Config::get('services.facebook.client_secret')
		);

		$redirectUrl = Request::url();

		$helper = new FacebookRedirectLoginHelper($redirectUrl);

		if ($session = $helper->getSessionFromRedirect())
		{
			$request = new FacebookRequest($session, 'GET', '/me');

			$user = $request->execute()->getGraphObject(GraphUser::className());

			return Response::make('Hello, '.$user->getName());
		}

		return Redirect::to($helper->getLoginUrl());
	}

}
```

Note the namespace at the top of the file: `MartinBean\Facebook\Laravel\FacebookRedirectLoginHelper`;

## License

Licensed under the [MIT License](LICENSE.md).

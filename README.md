# Facebook PHP SDK Laravel package

A wrapper for the Facebook PHP SDK to work nicely with Laravel.

## Installation

Add this package’s name to your Composer manifest:

```json
"require": {
    "martin-bean/facebook-php-sdk-laravel": "0.1.*"
}
```

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

class TestFacebookController extends BaseController {

	public function index()
	{
		FacebookSession::setDefaultApplication(
			Config::get('services.facebook.app_id'),
			Config::get('services.facebook.secret')
		);

		$redirect_url = Request::url();

		$helper = new FacebookRedirectLoginHelper($redirect_url);

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

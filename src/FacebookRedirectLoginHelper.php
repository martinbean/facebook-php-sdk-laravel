<?php
namespace MartinBean\Facebook\Laravel;

use Facebook\FacebookRedirectLoginHelper as BaseFacebookRedirectLoginHelper;
use Request;
use Session;

class FacebookRedirectLoginHelper extends BaseFacebookRedirectLoginHelper
{
    /**
     * Check if a redirect has a valid state.
     *
     * @return bool
     */
    protected function isValidRedirect()
    {
        $this->loadState();
        return $this->getCode() && Request::get('state', null) == $this->state;
    }

    /**
     * Return the code.
     *
     * @return string|null
     */
    protected function getCode()
    {
        return Request::get('code', null);
    }

    /**
     * Stores a state string in session storage for CSRF protection.
     *
     * @param string $state
     */
    protected function storeState($state)
    {
        Session::put($this->getSessionKey(), $state);
    }

    /**
     * Loads a state from session storage for CSRF validation.
     *
     * @return string|null
     */
    protected function loadState()
    {
        return $this->state = Session::get($this->getSessionKey(), null);
    }

    /**
     * A helper method to get the session key to use.
     *
     * @return string
     */
    protected function getSessionKey()
    {
        return 'facebook.state';
    }
}

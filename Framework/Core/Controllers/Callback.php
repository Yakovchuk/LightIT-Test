<?php

namespace App\Core\Controllers;

use App\Core\Controller;
use App\Core\Core;
use App\Libs\Facebook\FacebookCustom;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/**
 * Class Callback
 * @package App\Core\Controllers
 */
class Callback extends Controller
{

    /**
     * Callback constructor.
     * @param Core $core
     */
    public function __construct(Core $core)
    {
        parent::_construct($core);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function initialize(array $params = array())
    {
        return true;
    }

    /**
     * Callback для OAuth FaceBook
     *
     */
    public function Fblogincallback()
    {
        $fb = new FacebookCustom();

        $helper = $fb->getFB()->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (isset($accessToken)) {
            // Logged in!
            $_SESSION[FACEBOOK_SESSION_NAME_TOKEN] = (string) $accessToken;

            $this->redirect('/comments');

            // Now you can redirect to another page and use the
            // access token from $_SESSION['facebook_access_token']
        }
        else{
            $this->redirect('/');
        }
    }
}
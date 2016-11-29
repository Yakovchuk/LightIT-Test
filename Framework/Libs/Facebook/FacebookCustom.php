<?php

namespace App\Libs\Facebook;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class FacebookCustom
{
    /**
     * @var Facebook
     */
    private $fb;

    /**
     * @var array
     */
    private $permissions;

    /**
     * FacebookCustom constructor.
     */
    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => FACEBOOK_ID,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => 'v2.5',
        ]);

        $this->permissions = ['scope' => 'email']; // optional
    }

    /**
     * Получениие ссылки Facebook для авторизации
     *
     * @return string
     */
    public function AuthUrl()
    {
        $helper = $this->fb->getRedirectLoginHelper();

        return $helper->getLoginUrl(FACEBOOK_LOGIN_CALLBACK, $this->permissions);
    }

    /**
     * @return Facebook
     */
    public function getFB()
    {
        return $this->fb;
    }

    /**
     * @param $access_token
     */
    private function setAccessToken($access_token)
    {
        $this->fb->setDefaultAccessToken($access_token);
    }

    /**
     * @return \Facebook\GraphNodes\GraphUser
     */
    private function getGraphUser()
    {
        try {
            $response = $this->fb->get('/me?fields=name,email');
            $userNode = $response->getGraphUser();
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $userNode;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        $this->setAccessToken($_SESSION[FACEBOOK_SESSION_NAME_TOKEN]);

        return $this->getGraphUser()->getEmail();
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        $this->setAccessToken($_SESSION[FACEBOOK_SESSION_NAME_TOKEN]);

        return $this->getGraphUser()->getName();
    }
}
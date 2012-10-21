<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
require 'config/functions.php';
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_PlusService.php';

session_start();

$client = new Google_Client();
$client->setApplicationName("Commander HQ");
// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
// $client->setClientId('insert_your_oauth2_client_id');
// $client->setClientSecret('insert_your_oauth2_client_secret');
// $client->setRedirectUri('insert_your_oauth2_redirect_uri');
// $client->setDeveloperKey('insert_your_developer_key');
$plus = new Google_PlusService($client);

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}


if ($client->getAccessToken()) {
    $me = $plus->people->get('me');
    $user_info = new UserObject($me);

  // The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();
  
        $google_user = new User();
        $userdata = $google_user->checkUser($user_info, 'google');
        if(!empty($userdata)){
            session_start();
            $_SESSION['oauth_id'] = $uid;
            $_SESSION['oauth_provider'] = $userdata->oauth_provider;
            $Redirect = $userdata->redirect;
            header("Location: index.php?module=".$Redirect."");
        } 
  
  
} else {
  $authUrl = $client->createAuthUrl();
  header("Location: ".$authUrl."");
}

class UserObject{
    var $id;
    var $name;
    var $email;
    var $gender;
    
    function __construct($Array)
    {
        $this->id = $Array['id'];
        $this->name = $Array['displayName'];
        $this->email = $Array['email'];
        $this->gender = $Array['gender'];
    }
}
?>
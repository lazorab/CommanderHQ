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
require_once 'src/apiClient.php';
require_once 'src/contrib/apiOauth2Service.php';
require 'config/functions.php';

session_start();

$client = new apiClient();
$client->setApplicationName("Commander HQ");
// Visit https://code.google.com/apis/console?api=plus to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
// $client->setClientId('insert_your_oauth2_client_id');
// $client->setClientSecret('insert_your_oauth2_client_secret');
// $client->setRedirectUri('insert_your_redirect_uri');
// $client->setDeveloperKey('insert_your_developer_key');
$oauth2 = new apiOauth2Service($client);

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
  $client->revokeToken();
}

if ($client->getAccessToken()) {
  $user_info = new UserObject($oauth2->userinfo->get());
  // The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();
        $google_user = new User();
        $userdata = $google_user->checkUser($user_info, 'google');
        if(!empty($userdata)){
            session_start();
            $_SESSION['oauth_id'] = $uid;
            $_SESSION['oauth_provider'] = $userdata['oauth_provider'];
            $Redirect = $userdata['redirect'];
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
        $this->name = $Array['name'];
        $this->email = $Array['email'];
        $this->gender = $Array['gender'];
    }
}
?>
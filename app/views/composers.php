<?php

View::composer('*', function($view) {
    $projects = array();
    $platforms = array();
    $user = array();
   
    $with_data = array();
    if (Sentry::check()) {
        $user = Sentry::getUser();
        $with_data['user'] = $user;
    }
});

function processPlatforms($platforms) {
    $return_platforms = array('-Select Network-');
    foreach ($platforms as $id => $platform) {
        if ($platform == 'FACEBOOK_PAGE') {
            continue;
        }
        if($platform == 'LINKEDIN_COMPANY'){
             continue;
          }
        $return_platforms[$id] = ucwords(strtolower(str_replace('_', ' ', $platform)));
    }
    return $return_platforms;
}

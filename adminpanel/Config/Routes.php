<?php
//------------------------------------------------------------------------------
/**
 * Routes of Adminpanel
 * 
 * Avaible MultiLanguage url structure
 * 
 * Url Structure 
 * {site_url}/{namespace}/{lang}/{controller}/{method}/{param}
 */
//------------------------------------------------------------------------------

$request  = \Config\Services::request();
$segments = $request->uri->getSegments();

if (($segments[0] ?? '') === 'adminpanel')
{
    $locale = $segments[1] ?? NULL;

    if (empty($locale) || !in_array($locale, $request->config->supportedLocales))
    {
        //If locale is no in supportedList
        header('Location: ' . site_url('adminpanel') . '/' . $request->getLocale());
        die();
    }

    //Set Locale
    $request->setLocale($locale);
    $routes->setDefaultNamespace('Adminpanel');

    //General without Authication Filter
    $routes->get("adminpanel/$locale/general", "General::index", ['namespace' => 'Adminpanel\Controllers']);
    $routes->add("adminpanel/$locale/general/(:segment)", "General::$1", ['namespace' => 'Adminpanel\Controllers']);
    $routes->add("adminpanel/$locale/general/(:segment)/(:any)", "General::$1/$2", ['namespace' => 'Adminpanel\Controllers']);
    $option['namespace'] ='Adminpanel\Controllers';

    $routes->get("adminpanel", "Home::index", $option);
    $routes->get("adminpanel/$locale", "Home::index", $option);

    if (isset($segments[2]))
    {
        //if there is controller name
        $moduleName  = $segments[2];
        $controllerName = ucfirst($segments[2]);
        
        $routes->get("adminpanel/$locale/$moduleName", "$controllerName::index", $option);
        $routes->add("adminpanel/$locale/$moduleName/(:segment)", "$controllerName::$1", $option);
        $routes->add("adminpanel/$locale/$moduleName/(:segment)/(:any)", "$controllerName::$1/$2", $option);
    }
}

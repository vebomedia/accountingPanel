<?php
//------------------------------------------------------------------------------
/**
 * Routes of Financepanel
 * 
 * Avaible MultiLanguage url structure
 * 
 * Url Structure 
 * {site_url}/{namespace}/{lang}/{controller}/{method}/{param}
 */
//------------------------------------------------------------------------------

$request  = \Config\Services::request();
$segments = $request->uri->getSegments();

if (($segments[0] ?? '') === 'financepanel')
{
    $locale = $segments[1] ?? NULL;

    if (empty($locale) || !in_array($locale, $request->config->supportedLocales))
    {
        //If locale is no in supportedList
        header('Location: ' . site_url('financepanel') . '/' . $request->getLocale());
        die();
    }

    //Set Locale
    $request->setLocale($locale);
    $routes->setDefaultNamespace('Financepanel');

    //General without Authication Filter
    $routes->get("financepanel/$locale/general", "General::index", ['namespace' => 'Financepanel\Controllers']);
    $routes->add("financepanel/$locale/general/(:segment)", "General::$1", ['namespace' => 'Financepanel\Controllers']);
    $routes->add("financepanel/$locale/general/(:segment)/(:any)", "General::$1/$2", ['namespace' => 'Financepanel\Controllers']);

    //Authication Links
    $routes->get("financepanel/$locale/auth", "Authentication::index", ['namespace' => 'Financepanel\Controllers']);
    $routes->add("financepanel/$locale/auth/(:segment)", "Authentication::$1", ['namespace' => 'Financepanel\Controllers']);
    $routes->add("financepanel/$locale/auth/(:segment)/(:any)", "Authentication::$1/$2", ['namespace' => 'Financepanel\Controllers']);
        
    //Add Authication Filter
    $option['filter'] = 'financepanelAuthFilter';
    $option['namespace'] ='Financepanel\Controllers';

    $routes->get("financepanel", "Home::index", $option);
    $routes->get("financepanel/$locale", "Home::index", $option);

    if (isset($segments[2]))
    {
        //if there is controller name
        $moduleName  = $segments[2];
        $controllerName = ucfirst($segments[2]);
        
        $routes->get("financepanel/$locale/$moduleName", "$controllerName::index", $option);
        $routes->add("financepanel/$locale/$moduleName/(:segment)", "$controllerName::$1", $option);
        $routes->add("financepanel/$locale/$moduleName/(:segment)/(:any)", "$controllerName::$1/$2", $option);
    }
}

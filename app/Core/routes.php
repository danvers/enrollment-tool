<?php
/**
 * Routes - all standard routes are defined here.
 *
 * @author David Carr - dave@daveismyname.com
 * @version 2.2
 * @date updated Sept 19, 2015
 */

/** Create alias for Router. */
use Core\Router;
use Helpers\Hooks;

/** Define routes. */
Router::any('', 'Controllers\Enrollment@index');
Router::any('(:any)', 'Controllers\Enrollment@course');
Router::any('(:any)/enroll', 'Controllers\Enrollment@enroll');

Router::any('admin', '\Controllers\admin\Admin@index');
Router::any('admin/login', '\Controllers\admin\Auth@login');
Router::any('admin/logout', '\Controllers\admin\Auth@logout');

Router::any('admin/user', '\Controllers\admin\Users@index');
Router::any('admin/user/add', '\Controllers\admin\Users@add');
Router::any('admin/user/edit/(:num)', '\Controllers\admin\Users@edit');
Router::any('admin/user/delete/(:num)', '\Controllers\admin\Users@delete');

Router::any('admin/list', '\Controllers\admin\Admin@index');
Router::any('admin/list/add', '\Controllers\admin\Listing@add');
Router::any('admin/list/edit/(:num)', '\Controllers\admin\Listing@edit');
Router::any('admin/list/delete/(:num)', '\Controllers\admin\Listing@delete');
Router::any('admin/list/export/(:num)', '\Controllers\admin\Listing@export');

Router::any('admin/list/toggle/(:num)', '\Controllers\admin\Listing@toggle');
Router::any('admin/list/entries/(:num)', '\Controllers\admin\Listing@entries');

Router::any('/admin/list/entries/ajax', '\Controllers\admin\Listing@ajax');

Router::any('admin/list/entries/(:num)/delete/(:num)', '\Controllers\admin\Listing@deleteEntry');

/** Module routes. */
$hooks = Hooks::get();
$hooks->run('routes');

/** If no route found. */
Router::error('Core\Error@index');

/** Turn on old style routing. */
Router::$fallback = false;

/** Execute matched routes. */
Router::dispatch();

<?php

use LobsterTest\DB\DBConfig;
use LobsterTest\DB\DB;

require_once 'lib\autoloader.php';

$request = new \LobsterTest\Request();

// Init and set DB with fabric method
DB::get(
    'pdo',
    new DBConfig(
        'mysql:host=localhost;dbname=lobster;charset=utf8;port=3306',
        'root',
        'root'
    )
);

// Router
switch( $request->currentRoute() ){
    
    // AJAX API
    case 'ajax':
        
        // Bad request. Expect AJAX request.
        //if( Server::get('HTTP_X_REQUESTED_WITH') !== 'xmlhttprequest' ){
        //    header('LobsterTest-AvailableRoutes: start_lottery, participate', true, 400);
        //    http_response_code( 400 );
        //    die();
        //}
        
        // Get next route
        $action = $request
            ->shift()
            ->currentRoute();
        
        try{
            switch( $action ){
                case 'start_lottery':
                    require_once 'Models\start_lottery.php';
                    break;
        
                case 'stop_lottery':
                    // Bad request
                    if( empty( $request->parameters['lottery_id'] ) ){
                        header( 'LobsterTest-AvailableRoutes: start_lottery, participate1' );
                        header( 'LobsterTest-RequiredParameter: lottery_id(uuid)' );
                        http_response_code( 400 );
                        die();
                    }
                    require_once 'Models\stop_lottery.php';
                    break;
        
                case 'participate':
            
                    // Bad request
                    if( empty( $request->parameters['lottery_id'] ) ){
                        header( 'LobsterTest-AvailableRoutes: start_lottery, participate1' );
                        header( 'LobsterTest-RequiredParameter: lottery_id(uuid)' );
                        http_response_code( 400 );
                        die();
                    }
            
                    require_once 'Models\roll.php';
            
                    break;
        
                default:
                    header( 'LobsterTest-AvailableRoutes: start_lottery, participate' );
                    http_response_code( 404 );
                    die();
            }
        }catch(\Exception $exception){
            $ajax_response = ['error' => $exception->getMessage() ];
            require_once 'Views\AJAX.php';
        }
        
        break;
        
    case 'admin':
        require_once 'Models\admin.php';
        break;
    
    // Participate
    case 'participate':
        require_once 'Models\roll.php';
        break;
    
    default:
        require_once 'Models\participate.php';
}
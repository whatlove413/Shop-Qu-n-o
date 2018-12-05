<?php

use Core\Jobs\BeginTransactionJob;
use Core\Jobs\CommitJob;
use Core\Jobs\RollbackJob;

use Core\Models\Adapters\DoctrineAdapter;
use Core\Storages\InstanceStorage;

// hàm khởi tạo model adapter
if(!function_exists('makeModelAdapter')){
	
	function makeModelAdapter( $adapter = null ) {
		
		if( !$adapter ) {
				
			$adapter = config('database.connections.mysql.adapter');
		}
		
		$adapter = ucfirst(strtolower( $adapter ));
		$instanceName = "Models.Adapter." . $adapter;
		
		switch ( $adapter ) {
				
			case "Doctrine":
			default:
				$adapterClass = DoctrineAdapter::class;
		}
		
		if( !InstanceStorage::has( $instanceName ) ) {
		
			$adapter = \App::make ( $adapterClass );
			
			InstanceStorage::set( $instanceName, $adapter );
		} else {
				
			$adapter = InstanceStorage::get ( $instanceName );
		}
		
		return $adapter;
	}
}

if(!function_exists('beginTransaction')){
	
	function beginTransaction( $adapter = null ){
		
		$adapter = makeModelAdapter( $adapter );
		
		//if( $adapter == 'Doctrine' ){
			
			//app('em')->beginTransaction();
			dispatch( new BeginTransactionJob( $adapter ) );
		//}	
	}
}
if(!function_exists('commitTransaction')){
	
	function commitTransaction( $adapter = null ){
		
		$adapter = makeModelAdapter( $adapter );
		
		//if($adapter == 'Doctrine'){
			//app('em')->commit();
			dispatch( new CommitJob( $adapter ) );
		//}
	}
}

if(!function_exists('rollbackTransaction')){
	
	function rollbackTransaction( $adapter = null ){
		
		$adapter = makeModelAdapter( $adapter );
		
		//if($adapter == 'Doctrine'){
			//app('em')->rollback();
			dispatch( new RollbackJob( $adapter ) );
		//}
	}
}
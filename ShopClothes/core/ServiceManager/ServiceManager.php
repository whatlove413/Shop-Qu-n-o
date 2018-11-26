<?php
 namespace Core\ServiceManager;
 
 
 class ServiceManager {
 	
 	use Traits\ServiceManager;
 	
 	public function make() {
 		
 		return call_user_func_array( array($this, 'getService'), func_get_args() );
 	}
 }
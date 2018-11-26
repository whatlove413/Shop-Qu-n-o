<?php
 namespace Core\Traits;
 use Core\Traits\Exceptions\MethodNotFoundException;
 
 trait MagicCaller {
 	
 	public function __call($key, $params) {
 		
 		$keys = preg_split('/(?=[A-Z])/', $key, -1, PREG_SPLIT_NO_EMPTY);
 		
 		if( is_array($keys) && count( $keys ) == 2 ) {
 			
	 		$method = $keys[0];
	 		$key = lcfirst( $keys[1] );
	 		
	 		if( $method === "get" ) {
	 			
	 			return $this->{ $key };
	 		}
	 		
	 		if( $method === "set" && is_array( $params ) ) {
	 			
	 			return $this->{ $key } = $params[0];
	 		}
 		}
 		
 		throw new MethodNotFoundException("Method not found");
 	}
 }
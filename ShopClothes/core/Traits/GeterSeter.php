<?php
 namespace Core\Traits;
 
 trait GeterSeter {
 	
 	/**
 	 * Set entity's data from array
 	 *
 	 * @param array $data
 	 */
 	public function fromArray($data = array())
 	{
 		if ( is_array( $data ) ){
 			
 			foreach ( $data as $key => $value ) {
 				
 				$this->__set($key, $value);
 			}
 		}
 		return $this;
 	}
 	
 	/**
 	 * Convert entity''s data to array.
 	 * @return array
 	 */
 	public function toArray()
 	{
 		$result = array();
 		foreach ( get_object_vars( $this ) as $key => $noUse ){
 			
 			$result[ $key ] = $this->__get( $key );
 		}
 	
 		return $result;
 	}
 	
 	/**
 	 * Magic __set()
 	 * @param string $key
 	 * @param mixed $value
 	 *
 	 * @return mixed
 	 */
 	public function __set($key, $value)
 	{
 		$method_name = 'set' . ucfirst( $key );
 		
 		if ( method_exists( $this, $method_name ) ){
 			
 			return $this->{ $method_name }( $value );
 		}else{
 			
 			$this->{ $key } = $value;
 		}
 		return $this;
 	}
 	
 	/**
 	 * Magic __get()
 	 *
 	 * @param string $key
 	 *
 	 * @return mixed
 	 */
 	public function __get($key)
 	{
 		$method_name = 'get' . ucfirst($key);
 		
 		if ( method_exists( $this, $method_name ) ){
 			
 			return $this->{ $method_name }();
 		}else{
 			
 			return $this->{ $key };
 		}
 	}
 }
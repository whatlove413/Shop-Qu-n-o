<?php
 namespace Core\Models\Doctrine;

 use Core\Contracts\Entities;
 use Doctrine\Common\Util\Inflector;
 
 abstract class BaseEntities implements Entities {
 	
 	/**
 	 * Constructor
 	 *
 	 * @param array $options
 	 * @return void
 	 */
 	public function __construct($data = null)
 	{

 		/**
 		 * Call to init method. Useful for initialization.
 		 */
 		//call_user_func_array( array($this, 'init'), func_get_args() );
 		$this->init();
 	
 		/**
 		 * Setting entity's data (if any)
 		 */
 		if (is_array($data) && method_exists( $this, "fromArray" )) {
 			
 			$this->fromArray($data);
 		}
 	}
 	
 	/**
 	 * Initialization.
 	 */
	public function init(){}
		
	/**
 	 * Set entity's data from array
 	 *
 	 * @param array $data
 	 */
	public function fromArray($data = array())
	{
		if ( is_array( $data ) ){
			
			$setPrefix = 'set';
			$wishlist = array();

			if (method_exists( $this, "wishlist" )) {
				
				$wishlist = $this->wishlist();
			}

			foreach ( $data as $field => $value ) {
				
				if( in_array( $field, $wishlist ) ) {

					$setter = $setPrefix . Inflector::classify( $field );
					if( method_exists( $this, $setter ) ) {
						
						$this->{$setter}( $value );
					}
				}
			}
		}
		return $this;
	}

	/**
 	 * get entity's data array
 	 *
 	 * @return array $data
 	 */
	public function toArray() {
		
		$result = array();
		$getPrefix = 'get';

		foreach ( get_object_vars( $this ) as $key => $noUse ){
			
			$getter = $getPrefix . Inflector::classify( $key );
			if( method_exists( $this, $getter ) ) {
				
				$value = $this->{$getter}();
				if( $value instanceof Entities ) {
					
					if( method_exists( $value, "toArray" ) ) {
						
						$value = $value->toArray();
					}
				}
				
				$result[$key] = $value;
			}
		}
	
		return $result;
	}
 }
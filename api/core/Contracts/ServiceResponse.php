<?php
 namespace Core\Contracts;
 
 interface ServiceResponse {
 	
 	public function getData();
 	public function setData( $data );
 	public function fails();
 	public function errors();
 	public function getStatus();
 	public function setStatus( $status );
 	public function getStatusCode();
 	public function setStatusCode( $statusCode );
 	public function mergeMessageErrors( $messages );
 	public function toArray();
 }
<?php
 
 namespace Core\Contracts;
 
 interface ModelAdapter {
 	
 	public function beginTransaction();
 	
 	public function commit();
 	
 	public function rollback();
 }
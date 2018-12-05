<?php
 namespace Core\Models\Adapters;
 
 use Core\Contracts\ModelAdapter;
 
 class DoctrineAdapter implements ModelAdapter{
 	
 	public function beginTransaction() {
 		
 		app('em')->beginTransaction();
 	}
 	
 	public function rollback() {
 		
 		app('em')->rollback();
 	}
 	
 	public function commit() {
 			
 		app('em')->commit();
 	}
 }
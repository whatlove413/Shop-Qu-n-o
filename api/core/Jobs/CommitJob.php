<?php
 namespace Core\Jobs;
 
 class CommitJob {
 	
 	use \Illuminate\Queue\SerializesModels;
 	
 	/**
 	 * 
 	 * @var \Core\Contracts\ModelAdapter
 	 */
 	protected $adapter = null;
 	
 	/**
 	 * Create a new job instance.
 	 *
 	 * @return void
 	 */
 	public function __construct( $adapter )
 	{
	
 		$this->adapter = $adapter;
 	}
 	
 	/**
 	 * Execute the job.
 	 *
 	 * @return void
 	 */
 	public function handle()
 	{
 		//
 		//if(config('database.adapter') == 'Doctrine'){
 			//app('em')->commit();
 		//}
 		$this->adapter->commit();
 	}
 }
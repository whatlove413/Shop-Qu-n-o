<?php
 namespace Core\Responders;
 use Core\Contracts\ServiceResponse as ServiceResponseContract;
 use Illuminate\Support\MessageBag;
 use \Illuminate\Contracts\Support\MessageProvider;
 
 class ServiceResponse implements ServiceResponseContract {
 	
 	protected $messageBag;
 	protected $data;
 	protected $STATUS;
 	protected $status_code;
 	
 	const STATUS_OK = "OK";
 	const STATUS_ERROR = "ERROR";
 	const STATUS_WARNING = "WARNING";
 	const STATUS_NONEAUTHENTICATION = "NONE_AUTHENTICATION";
 	const STATUS_ACCESSDENIED = "ACCESS_DENIED";
 	
 	public function __construct( $data = null, $status = "OK", $statusCode = 200, $errors = array() ){
 		
 		$this->messageBag = new MessageBag( $errors );
 		$this->data = $data;
 		$this->STATUS = $status;
 		$this->status_code = $statusCode;
 	}
 	
 	/**
 	 * @todo Hàm lấy dữ liệu ra
 	 * @return $data
 	 */
 	public function getData() {
 		
 		return $this->data;
 	}
 	
 	/**
 	 * @todo Hàm set dữ liệu
 	 * @param $data
 	 */
 	public function setData( $data = null ) {
		 
 		$this->data = $data;
 		
 		return $this;
 	}

 	/**
 	 * @todo Hàm lấy trạng thái
 	 * @return [enum] $status
 	 */
 	public function getStatus() {
 		
 		return $this->STATUS;
 	}
 	
 	/**
 	 * @todo Hàm set trạng thái
 	 * @param enum $status
 	 */
 	public function setStatus( $status = "OK" ) {
 		
 		$this->STATUS = $status;
 		return $this;
 	}

 	/**
 	 * @todo Hàm lấy mã trạng thái
 	 * @return integer $status_code
 	 */
 	public function getStatusCode() {
		
		return $this->status_code;
	}
	
	/**
	 * @todo Hàm set mã trạng thái
	 * @param integer $statusCode
	 */
	public function setStatusCode( $statusCode = 200 ) {
		
		$this->status_code = $statusCode;
		
		return $this;
	}
 	
 	/**
 	 * @todo Hàm kiểm tra có lỗi ?
 	 * @return boolean true|false
 	 */
 	public function fails() {
 		
 		return $this->messageBag->count() > 0;
 	}
 	
 	/**
 	 * @todo Hàm lấy message lỗi
 	 * @return MessageBag $messageBag
 	 */
 	public function errors() {
 		
 		return $this->messageBag;
 	}

 	/**
 	 * @todo Hàm thêm lỗi vào respone (lỗi validate)
 	 * @param  array|MessageBag $messages
 	 */
 	public function mergeMessageErrors( $messages = [] ) {
 		
 		if( !($messages instanceof MessageProvider) ) {
 			
 			$messages = new MessageBag( $messages );
 		}
 		
 		$this->messageBag->merge( $messages );
 		return $this;
 	}
 	
 	/**
 	 * @todo Hàm thêm lỗi vào respone (lỗi dạng exception)
 	 * @param [string] $message
 	 * @param interger $code
 	 */
 	public function addException( $message, $code = null ) {
 		
 		$code = $code ? $code : 0;
 		
 		$this->mergeMessageErrors( new MessageBag( array(
 			"Exception" => array(
 				$code => $message
 			)
 		) ) );
 	}
 	
 	/**
 	 * @todo Hàm đưa instance service respone về array
 	 * @return [array] $this
 	 */
 	public function toArray() {
 		
 		return array(
 			"STATUS" 			=> $this->STATUS,
 			"status_code"		=> $this->status_code,
 			"data" 				=> $this->data,
 			"message" 			=> $this->messageBag->first(),
 			"messages" 			=> $this->messageBag->all()
 		);
 	}
 }
<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'facebook-php-sdk/src/facebook.php';

class myApiFacebook extends Facebook {

	var $myApiConfig = array(
		'cookie' => true,
		'language_code' => 'en_GB',
		'debug' => false
	);

	function __construct($config = null){
		if(is_null($config)){
			error_log('No Facebook Config file found');
			return;
		}
		$this->myApiConfig = array_merge($this->myApiConfig, $config);
		parent::__construct($this->myApiConfig);
	}

	public function getNamespace(){
		return (array_key_exists('namespace', $this->myApiConfig)) ? $this->myApiConfig['namespace'] : null;
	}

	public function getPageId(){
		return (array_key_exists('pageId', $this->myApiConfig)) ? $this->myApiConfig['pageId'] : null;
	}

	public function getTabAppUrl(){
		$pageId = $this->getPageId();
		if($pageId){
			$appId = $this->getAppId();
			return "http://www.facebook.com/pages/null/{$pageId}?sk=app_{$appId}";
		}
		return null;
	}

	public function getCanvasUrl(){
		return (array_key_exists('namespace', $this->myApiConfig)) ? 'http://apps.facebook.com/'.$this->myApiConfig['namespace'].'/' : null;
	}
	
	public function jsInclude(){
		include 'jsInclude.php';
	}
}

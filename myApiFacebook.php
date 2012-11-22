<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'facebook-php-sdk/src/facebook.php';

class myApiFacebook extends Facebook {

	var $config = array(
		'cookie' => true
	);

	function __construct($config = null){
		if(is_null($config)){
			error_log('No Facebook Config file found');
			return;
		}
		$this->config = array_merge($config, $this->config);
		parent::__construct($this->config);
	}

	public function getNamespace(){
		return (array_key_exists('namespace', $this->config)) ? $this->config['namespace'] : null;
	}

	public function getPageId(){
		return (array_key_exists('pageId', $this->config)) ? $this->config['pageId'] : null;
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
		return (array_key_exists('namespace', $this->config)) ? 'http://apps.facebook.com/'.$this->config['namespace'].'/' : null;
	}
	
}

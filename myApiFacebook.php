<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'facebook-php-sdk/src/facebook.php';

class myApiFacebook extends Facebook {

	private static $ogTags = array();

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

		$openGraph = array(
			'og:type' => 'website',
			'og:url' => base_url(),
			'fb:app_id' => $config['appId']
		);

		if(array_key_exists('graph',$config) && is_array($config['graph'])){
			$openGraph = array_merge($openGraph,$config['graph']);
		}

		$this->setOpenGraphTags($openGraph);

		$this->myApiConfig = array_merge($this->myApiConfig, $config);
		parent::__construct($this->myApiConfig);


		$CI = get_instance();
		//Is there a myapi redirect we need to act on
		$redirect = $CI->session->userdata('myapi_redirect');

		if($redirect){
			$CI->session->unset_userdata('myapi_redirect');
			redirect($redirect, 'refresh');
		}
	}

	public function jsRedirect($location){
		echo '<script type="text/javascript">';
		echo "window.parent.location = '{$location}'";
		echo '</script>';
		die;
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

	public function getCanvasUrl($path = ''){
		return (array_key_exists('namespace', $this->myApiConfig)) ? 'http://apps.facebook.com/'.$this->myApiConfig['namespace'].'/'.$path : null;
	}
	
	public function jsInclude(){
		include 'jsInclude.php';
	}
	
	public function setOpenGraphTags($tags){
		self::$ogTags = array_merge(self::$ogTags,$tags);
	}

	public function openGraphMeta(){
		$html = '';
		foreach(self::$ogTags as $key => $value){
			$html .= '<meta property="'.$key.'" content="'.htmlspecialchars($value).'">'."\n\t";
		}
		return $html;
	}
}

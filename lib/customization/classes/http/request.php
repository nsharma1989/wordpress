<?php
namespace Roots\Sage\Customization\Classes\Http;

class Request {
	
	static $_REQUEST_COPY;
	static $_GET_COPY;
	static $_POST_COPY;
	
	public static function getValue($key, $default = null, $sanitize = true, $sanitization_method = 'text_fields', $strict = false)
	{
		$value = $strict ? static::getValueFromGet($key, $default) : static::getValueFromRequest($key, $default);
	
		if ($sanitize) {
			$value = static::sanitizeValue($value, $sanitization_method);
		}
		
		return $value;
	}
	
	public static function getPostValue($key, $default = null, $sanitize = true, $sanitization_method = 'text_fields')
	{
		$value = static::getValueFromPost($key);
		
		if ($sanitize) {
			$value = static::sanitizeValue($value, $sanitization_method);
		}
		
		return $value;
	}
	
	public static function getFile($name, $filter = []) {
		if (isset($_FILES[$name])) {
			$file = $_FILES[$name];
				
			if (!is_uploaded_file($file['tmp_name'])) {
				return false;
			}
				
			if ($filter) {
				$mime = mime_content_type($file['tmp_name']);
				if (!in_array($mime, $filter)) {
					return false;
				}
			}
				
			return $file;
		}
	
		return false;
	}
	
	public static function sanitizeValue($value, $sanitization_method = 'text_fields')
	{
		return function_exists($function = sprintf('_sanitize_%s', $sanitization_method)) ? $function($value) : _sanitize_text_fields($value);
	}
	
	public static function getIP()
	{
		$ip = '';
		
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} else if(getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} else if(getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		} else if(getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		} else if(getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		} else if(getenv('REMOTE_ADDR')) {
			$ip = getenv('REMOTE_ADDR');
		} else {
			$ip = 'UNKNOWN';
		}
				
		return $ip;
	}
	
	public static function isSecure()
	{
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || $_SERVER['SERVER_PORT'] === 443;
	}
	
	public static function getReferer()
	{
		return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : get_site_url();
	}
	
	public static function getCurrentUrl()
	{
		$url = sprintf('%s://%s%s', isset($_SERVER['HTTPS']) ? 'https' : 'http', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);
		return $url;
	}
	
	public static function getAjaxUrl($path = '', $scheme = 'admin')
	{
		return \admin_url('admin-ajax.php', $path, $scheme);
	}
	
	public static function htmlEntityDecode($string, $quoteMode = ENT_COMPAT, $encoding = 'UTF-8')
	{
		return 	html_entity_decode($string, $quoteMode, $encoding);
	}
	
	public static function getUserAgent()
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}
	
	protected static function getValueFromRequest($key, $default = null)
	{
		if (!isset(static::$_REQUEST_COPY)) {
			static::$_REQUEST_COPY = $_REQUEST;
		}
		
		return isset(static::$_REQUEST_COPY[$key]) ? static::$_REQUEST_COPY[$key] : $default;
	}
	
	protected static function getValueFromGet($key, $default = null)
	{
		if (!isset(static::$_GET_COPY)) {
			static::$_GET_COPY = $_GET;
		}
		
		return isset(static::$_GET_COPY[$key]) ? static::$_GET_COPY[$key] : $default;
	}
	
	protected static function getValueFromPost($key, $default = null)
	{
		if (!isset(static::$_POST_COPY)) {
			static::$_POST_COPY = $_POST;
		}
	
		return isset(static::$_POST_COPY[$key]) ? static::$_POST_COPY[$key] : $default;
	}
}
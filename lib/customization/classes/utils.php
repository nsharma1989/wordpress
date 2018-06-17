<?php

namespace Roots\Sage\Customization\Classes;

use Roots\Sage\Customization\Classes\Http\Request;
use Roots\Sage\Customization\Classes\Exceptions\JsonException;
use Roots\Sage\Customization\Classes\Theme\Template;

class Utils {
	
	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\Template::setQueryVars
	 * 
	 * @param array $attrs
	 * @param string $http_entity_decode
	 */
	public static function set_query_vars($attrs, $http_entity_decode = true) {
		Template::setQueryVars($attrs, null, $http_entity_decode);
	}

	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\Template::restoreQueryVars
	 */
	public static function restore_query_vars() {
		Template::restoreQueryVars();
	}

	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\Template::locateCustomizedTemplate
	 * 
	 * @param string $template
	 * @return string|null
	 */
	public static function locate_customized_template($template) {
		return Template::locateCustomizedTemplate($template);
	}

	public static function get_post_slug($post = null) {
		if (!$post) {
			global $post;
		} else {
			$post = get_post($post);
		}

		return $post ? $post->post_name : '';
	}

	public static function get_root_post($post = null) {
		if (!$post) {
			global $post;
		} else {
			$post = get_post($post);
		}

		if ($post) {
			while ($post->post_parent) {
				$post = get_post($post->post_parent);
			}
		}

		return $post;
	}

	public static function get_root_post_slug($post = null) {
		return self::get_post_slug(self::get_root_post($post));
	}

	public static function get_combined_slug($post = null, $operator = '-') {
		if (!$post) {
			global $post;
		} else {
			$post = get_post($post);
		}

		$slug = [];
		if ($post) {
			array_unshift($slug, $post->post_name);

			while ($post->post_parent) {
				$post = get_post($post->post_parent);
				array_unshift($slug, $post->post_name);
			}
		}

		return implode($operator, $slug);
	}
	
	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\getName() instead
	 * 
	 * @return string
	 */
	public static function get_template_name() {
		return Template::getName();
	}

	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\isTemplateHome() instead
	 * 
	 * @return bool
	 */
	public static function is_template_home() {
		return Template::isTemplateHome();
	}

	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\isBlog() instead
	 * 
	 * @return bool
	 */
	public static function is_blog_home() {
		return Template::isBlog();
	}
	
	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\showHeaderLinkMenu() instead
	 *
	 * @return bool
	 */
	public static function show_header_link_menu() {
		return Template::showHeaderLinkMenu();
	}

	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\isContentOnly() instead
	 *
	 * @return bool
	 */
	public static function is_content_only() {
		return Template::isContentOnly();
	}

	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\show_header() instead
	 *
	 * @return bool
	 */
	public static function show_header() {
		return Template::showHeader();
	}

	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Theme\show_footer() instead
	 *
	 * @return bool
	 */
	public static function show_footer() {
		return Template::showFooter();
	}

	/**
	 * @deprecated use Use Roots\Sage\Customization\Classes\Http\Request::getAjaxUrl instead
	 */
	public static function get_ajax_url() {
		return Request::getAjaxUrl();
	}

	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Http\Request::sanitize instead
	 *
	 * @param mixed $value
	 * @param string $sanitization_method
	 */
	public static function sanitize_value($value, $sanitization_method = 'text_fields') {
		return Request::sanitizeValue($value, $sanitization_method);
	}
	
	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Http\Request::getValue instead
	 * 
	 * @param string $name
	 * @param mixed $default
	 * @param string $sanitize
	 * @param string $sanitization_method
	 */
	public static function get_request_param($name, $default = null, $sanitize = true, $sanitization_method = 'text_fields') {
		return Request::getValue($name, $default = null, $sanitize = true, $sanitization_method = 'text_fields', false);
	}
	
	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Http\Request::getFile instead
	 * 
	 * @param string $name
	 * @param array $filter
	 * @return boolean|unknown
	 */
	public static function get_file_param($name, $filter = []) {
		return Request::getFile($name, $filter);
	}

	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Http\Request::getPostValue instead
	 * 
	 * @param string $name
	 * @param mixed $default
	 * @param string $sanitize
	 * @param string $sanitization_method
	 */
	public static function get_post_param($name, $default = null, $sanitize = true, $sanitization_method = 'text_fields') {
		return Request::getPostValue($name, $default, $sanitize, $sanitization_method);
	}

	public static function build_html_attributes($attrs) {
		$attrs_combined = [];
		foreach ($attrs as $attr => $value) {
			$attrs_combined[] = sprintf('%s="%s"', $attr, \esc_attr($value));
		}

		return trim(implode(' ', $attrs_combined));
	}

	public static function numericArray($array) {
		return array_filter($array, function($value) { return Validator::isNumeric($value);  });
	}
	
	public static function numberArrayMin($array) {
		if (sizeof($array = self::numericArray($array))) {
			return min($array);
		}
		
		return null;
	}

	public static function getPostCategory($post) {
		$id = '';
		
		if (is_a($post, \WP_Post::class)) {
			$id = $post->ID;
		} else {
			if (Validator::isInteger($post)) {
				$id = $post;
			}
		}
		
		if ($id) {
			$category = get_the_category($id);
			return sizeof($category) ? $category[0] : null;
		}
		
		return false;
	}
	
	public static function getCustomPostCategory($post, $category) {
		$id = '';
		
		if (is_a($post, \WP_Post::class)) {
			$id = $post->ID;
		} else {
			if (Validator::isInteger($post)) {
				$id = $post;
			}
		}
		
		if ($id && $category) {
			$category = get_the_terms($id, $category);
			return sizeof($category) ? $category[0] : null;
		}
	}
	
	public static function getMetaData($post, $key, $asArray = false, $split = PHP_EOL) {
		$id = '';
		
		if (is_a($post, \WP_Post::class)) {
			$id = $post->ID;
		} else {
			if (Validator::isInteger($post)) {
				$id = $post;
			}
		}
		
		$meta = '';
		
		if ($id) {
			$meta = \get_post_meta($id, $key, true);
			
			if ($meta && $asArray) {
				$meta = explode($split, $meta);
			}
			
			return $meta;
		}
		
		return false;
	}
	
	public static function getURLByPath($path, $extras = '') {
		if ($post = \get_page_by_path($path)) {
			$url = \get_permalink($post);
			
			return $url . $extras;
		}
		
		return false;
	}
	
	/**
	 * @deprecated Use Roots\Sage\Customization\Classes\Http\Request::getIp instead
	 */
	public static function getIP() {
		return Request::getIP();
	}
	
	public static function jsonDecode($value, $assoc = false, $depth = 512, $options = 0)
	{
		$json = json_decode($value, $assoc, $depth, $options);
		if (NULL === $json) {
			throw new JsonException(json_last_error_msg(), json_last_error());
		}
		
		return $json;
	}
	
	public static function getEllipsis($text, $maxWidth, $postFix='...') {
		return substr($text, 0, $maxWidth) . (strlen($text) > $maxWidth ? $postFix : '');
	}
	
	public static function isSameString($value, $valueTarget, $ignoreCase = false)
	{
		$result = $ignoreCase ? strcasecmp($value, $valueTarget) : strcmp($value, $valueTarget);
		return $result === 0;
	}
	
	public static function stringStartsWith($string, $str) 
	{
		return preg_match(sprintf('/^%s/', preg_quote($str)), $string) === 1;
	}
	
	public static function stringEndsWith($string, $str)
	{
		return preg_match(sprintf('/%s$/', preg_quote($str)), $string) === 1;
	}
	
	protected static function getOneTimeNonceKey($namespace, $action)
	{
		$nonce = wp_create_nonce($action);
		return sprintf('%s-%s', md5($namespace), $nonce);
	}
	
	public static function verifyOneTimeNonce($nonce, $namespace, $action)
	{
		$nonceKey = self::getOneTimeNonceKey($namespace, $action);
		if (isset($_SESSION[$nonceKey])) {
			$oneTimeNonces = array_filter($_SESSION[$nonceKey], function($time) {
				return time() - 86400 < $time;
			});
			
			$defaultNonce = wp_create_nonce($action);
			$result = false;
			
			if (wp_verify_nonce(substr($nonce, 0, strlen($defaultNonce)), $action)) {
				$tik = substr($nonce, strlen($defaultNonce));
				
				if (isset($oneTimeNonces[$tik])) {
					unset($oneTimeNonces[$tik]);
				
					$result = true;
				}
			}
			
			if (empty($oneTimeNonces)) {
				unset($_SESSION[$nonceKey]);
			} else {
				$_SESSION[$nonceKey] = $oneTimeNonces;
			}
			
			return $result;
		
		}
		
		return false;
	}
	
	public static function getOneTimeNonce($namespace, $action)
	{
		$nonceKey = self::getOneTimeNonceKey($namespace, $action);
		$time = time();
		$tik = crc32($time . rand());
		$nonce = wp_create_nonce($action);
		if (!isset($_SESSION[$nonceKey])) {
			$_SESSION[$nonceKey] = [];
		}
		$_SESSION[$nonceKey][$tik] = $time;
		
		return $nonce . $tik;
	}
}
<?php

namespace Roots\Sage\Customization\Classes;

class Formatter {
	
	const UNIT_SMS = 'SMS';
	const UNIT_DATA = 'MB';
	const UNIT_VOICE = 'MIN';
	const UNIT_DAY = 'DAY';
	
	public static function formatUnitPrice($value, $unit) 
	{		
		if (Validator::isNumeric($value)) {
			$value = floatval($value);
			return $value === 0.0 ? __('FREE') : sprintf('%s%s / %s', Currency::getSymbol(), number_format($value, 2), __($unit));
		}
			
		return __('N/A');
	}
	
	public static function formatSMS($value) 
	{
		return self::formatUnitPrice($value, self::UNIT_SMS);
	}
	
	public static function formatData($value)
	{
		return self::formatUnitPrice($value, self::UNIT_DATA);
	}
	
	public static function formatVoice($value)
	{
		return self::formatUnitPrice($value, self::UNIT_VOICE);
	}
	
	public static function formatDataPackage($value) 
	{
		return self::formatUnitPrice($value, self::UNIT_DAY);
	}

	public static function formatFirstName($firstName) {
		return 	ucwords(strtolower($firstName));
	}
	
	public static function formatLastName($lastName) {
		return 	ucwords(strtolower($lastName));
	}
	
	public static function formatName($firstName, $lastName) {
		return sprintf('%s %s', self::formatFirstName($firstName), self::formatLastName($lastName)); 
	}
	
	public static function formatURL($url, $params)
	{
		return add_query_arg($params, $url);
	}
}
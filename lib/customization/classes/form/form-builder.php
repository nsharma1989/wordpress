<?php 

namespace Roots\Sage\Customization\Classes\Form;


use Roots\Sage\Customization\Classes\Form\FormElements\Button;
use Roots\Sage\Customization\Classes\Form\FormElements\Column;
use Roots\Sage\Customization\Classes\Form\FormElements\Container;
use Roots\Sage\Customization\Classes\Form\FormElements\FormGroup;
use Roots\Sage\Customization\Classes\Form\FormElements\HelpBlock;
use Roots\Sage\Customization\Classes\Form\FormElements\Input;
use Roots\Sage\Customization\Classes\Form\FormElements\InputCheckbox;
use Roots\Sage\Customization\Classes\Form\FormElements\InputEmail;
use Roots\Sage\Customization\Classes\Form\FormElements\InputFile;
use Roots\Sage\Customization\Classes\Form\FormElements\InputHidden;
use Roots\Sage\Customization\Classes\Form\FormElements\InputNumber;
use Roots\Sage\Customization\Classes\Form\FormElements\InputPassword;
use Roots\Sage\Customization\Classes\Form\FormElements\Label;
use Roots\Sage\Customization\Classes\Form\FormElements\Option;
use Roots\Sage\Customization\Classes\Form\FormElements\RawHtml;
use Roots\Sage\Customization\Classes\Form\FormElements\Row;
use Roots\Sage\Customization\Classes\Form\FormElements\Select;
use Roots\Sage\Customization\Classes\Form\FormElements\Textarea;
use Roots\Sage\Customization\Classes\Models\KnowRoaming\Country;

class FormBuilder {

	protected $_attributes = [];
	protected $_options = [];
	
	public function __construct($buildOptions = [], $attributes = [])
	{
		$this->_attributes = $attributes;
		$this->_options = $buildOptions;
	}
	
	public function buildForm($buildOptions = null, $attributes = [])
	{
		if (empty($buildOptions)) {
			$buildOptions = $this->_options;
		}
		
		if (empty($attributes)) {
			$attributes = $this->_attributes;
		}
		
		$form = static::getForm($attributes);
		
		foreach ($buildOptions as $option) {
			$form->insertChild(static::getElement($option));
		}
		
		return $form;
	}
	
	public function __toString()
	{
		self::buildForm()->render();
	}
	
	public static function getForm($attributes = null)
	{
		$element = new Form;
		$element->setAttributes($attributes);
		return $element;	
	}
	
	public static function getContainer($attributes = null, $children = null, $tag = '')
	{
		$element = new Container($attributes, $children);
		if ($tag) {
			$element->setTag($tag);
		}
		return $element;
	}
	
	public static function getSpan($attributes = null, $children = null)
	{
		$element = self::getContainer($attributes, $children, 'span');
		return $element;
	}
	
	public static function getRow($attributes = null)
	{
		$element  = new Row($attributes);
		return $element;
	}
	
	public static function getRowNoGutter($attributes = null)
	{
		$element = self::getRow()->noGutters();
		return $element;
	}
	
	public static function getCol($attributes = null)
	{
		$element = new Column($attributes);
		return $element;
	}
	
	public static function getInput($name, $attributes = null)
	{
		$element = new Input($name, $attributes);
		return $element;
	}
	
	public static function getEmail($name, $attributes = null)
	{
		$element = new InputEmail($name, $attributes);
		return $element;
	}
	
	public static function getNumber($name, $attributes = null)
	{
		$element = new InputNumber($name, $attributes);
		return $element;
	}
	
	public static function getHidden($name, $attributes = null)
	{
		$element = new InputHidden($name, $attributes);
		return $element;
	}
	
	public static function getPassword($name, $attributes = null)
	{
		$element = new InputPassword($name, $attributes);
		return $element;
	}

	public static function getCheckbox($name, $attributes = null)
	{
		$element = new InputCheckbox($name, $attributes);
		return $element;
	}
	
	public static function getFile($name, $attributes = null)
	{
		$element = new InputFile($name, $attributes);
		return $element;
	}
	
	public static function getTextarea($name, $attributes = null)
	{
		$element = new Textarea($name, $attributes);
		return $element;
	}
	
	public static function getSelect($name, $attributes = null)
	{
		$element = new Select($name, $attributes);
		return $element;
	}
	
	public static function getCountrySelect($name, $attributes = null, $placeholder = 'Please select a country')
	{
		$countries = Country::getAllCountries();
		$select = self::getSelect($name, $attributes);
		if ($placeholder) {
			$select->addPlaceholder(__($placeholder));
		}
	
		if ($countries) {
			foreach($countries as $id => $country) {
				$option = self::getOption(__($country->getName()), [ 'value' => $country->getId(), 'data-iso2' => $country->getIso2(), 'data-iso3' => $country->getIso3() ]);
				$select->insertChild($option);
			}
		}
	
		return $select;
	}
	
	public static function getOption($content, $attributes = null)
	{
		$element = (new Option($content, $attributes));
		return $element;
	}
	
	public static function getLabel($content, $attributes = null)
	{
		$element = (new Label($attributes))->setContent($content);
		return $element;
	}
	
	public static function getHelpBlock($content, $attributes = null)
	{
		$element = (new HelpBlock($attributes))->setContent($content);
		return $element;
	}
	
	public static function getButton($content, $attributes = null)
	{
		$element  = (new Button($attributes))->setContent($content);
		return $element;
	}
	
	public static function getHtml($content = '')
	{
		$element  = new RawHtml($content);
		return $element;
	}
	
	public static function getFormGroup($attributes = null, Input $input = null, Label $label = null, HelpBlock $helpBlock = null)
	{
		$element = new FormGroup($attributes);
		
		if ($label) {
			$element->insertChild($label);
		}
		
		if ($input) {
			$element->insertChild($input);
		}
		
		if ($helpBlock) {
			$element->insertChild($helpBlock);
		}
		
		return $element;
	}
	
	public static function getTable($attributes = null , $children = null)
	{
		$element = self::getContainer($attributes, $children, 'table');
		return $element;
	}
	
	public static function getTHead($attributes = null , $children = null)
	{
		$element = self::getContainer($attributes, $children, 'thead');
		return $element;
	}
	
	public static function getTBody($attributes = null , $children = null)
	{
		$element = self::getContainer($attributes, $children, 'tbody');
		return $element;
	}
	
	public static function getTR($attributes = null , $children = null)
	{
		$element = self::getContainer($attributes, $children, 'tr');
		return $element;
	}
	
	public static function getTH($content = '', $attributes = null , $children = null)
	{
		$element = self::getContainer($attributes, $children, 'th')->setContent($content);
		return $element;
	}
	
	public static function getTD($content = '', $attributes = null , $children = null)
	{
		$element = self::getContainer($attributes, $children, 'td')->setContent($content);
		return $element;
	}
	
	public static function getElement($options)
	{
		$element = null;
		
		if (is_a($options, FormElement::class)) {
			$element = $options;
		} else if (isset($options['class']) && class_exists($options['class'])) {
			$class = $options['class'];
			if (is_a($class, FormElement::class, true)) {
				$name = isset($options['name']) ? $options['name'] : null;
				$attributes = isset($options['attributes']) ? $options['attributes'] : null;
				$content = isset($options['content']) ? $options['content'] : null;
				$children = isset($options['children']) ? self::getElement($options['children']) : null;
				
				
				if (is_subclass_of($class, Input::class)) {
					$element = new $class($name, $attributes);
				} else if (is_subclass_of($class, Container::class)) {
					$element = new $class($attributes, $children);
					if ($content) {
						$element->setContent($content);
					}
				} else if (is_a($class, RawHtml::class, true)) {
					$element = new $class($content);
				}
			}
		}
		
		return $element;
	}
}
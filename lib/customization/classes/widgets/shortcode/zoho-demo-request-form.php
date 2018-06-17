<?php

namespace Roots\Sage\Customization\Classes\Widgets\Shortcode;

use Roots\Sage\Customization\Classes\Form\FormBuilder;
use Roots\Sage\Customization\Classes\Formatter;
use Roots\Sage\Customization\Classes\Http\Request;
use Roots\Sage\Customization\Classes\Utils;

class ZohoDemoRequestForm extends BaseWidgetForm
{
	const INPUT_FIRSTNAME = 'First Name';
	const INPUT_LASTNAME = 'Last Name';
	const INPUT_COMPANY = 'Company';
	const INPUT_EMAIL = 'Email';
	const INPUT_PHONE = 'Phone';
	const INPUT_DESCRIPTION = 'Description';
	const INPUT_LEADSOURCE = 'Lead Source';
	const INPUT_CAPTCHA = 'enterdigest';
	const INPUT_NONCE = 'submission';
	const CAPTCHA_IMAGE_ID = 'captcha-image';
	
	protected static $formContainerId = 'crmWebToEntityForm';
	protected static $action = 'https://crm.zoho.com/crm/WebToLeadForm';
	protected static $actionType = 'TGVhZHM=';
	protected static $formId = '8f938e12a7bc1736d0fa44bba8b02ec880fb9d5c17bef7f17a58c2be7e9ff550';
	protected static $formGroupId = 'ae03c7368c48f0265b24c34da87e128b464ebf79d3b5a6fe8ee0d95eafa1b06c';
	protected static $name = 'WebToLeads2424406000000204063';
	protected static $widgetClass = 'zoho-demo-request-form';
	protected static $templateFile = 'zoho-demo-request-form';
	protected static $leaderSources = [
		'None' => [ 
			'text' => 'None',
		],
		'Advertisement' => [ 
			'text' => 'Advertisement',
		],
		'Cold Call' => [ 
			'text' => 'Cold Call',
		],
		'Employee Referral' => [ 
			'text' => 'Employee Referral',
		],
		'External Referral' => [ 
			'text' => 'External Referral',
		],
		'Online Store' => [ 
			'text' => 'Online Store',
		],
		'Partner' => [ 
			'text' => 'Partner',
		],
		'Public Relations' => [
			'text' => 'Public Relations',
		],
		'Sales Email Alias' => [
			'text' => 'Sales Email Alias',
		],
		'Seminar Partner' => [
			'text' => 'Seminar Partner',
		],
		'Internal Seminar' => [
			'text' => 'Internal Seminar',
		],
		'Web Download' => [
			'text' => 'Web Download',
		],
		'Web Form' => [
			'text' => 'Web Form',
			'selected' => 'selected',
		],
		'Chat' => [
			'text' => 'Chat',
		],
	];
	
	protected static function getUniqueWidgetId($id = null)
	{
		return self::$formContainerId;
	}
	
	protected static function getName()
	{
		return self::$name;
	}
	
	protected static function buildForm()
	{
		$nonce = self::getNonce();
		$misc = FormBuilder::getContainer()
			->insertChild(FormBuilder::getHidden($name = 'zc_gad'), [ 'id' => $name ])
			->insertChild(FormBuilder::getInput('xnQsjsdp', [ 'style' => 'display:none;' ])->showWrapper(false)->setValue(self::$formGroupId))
			->insertChild(FormBuilder::getInput('xmIwtLD', [ 'style' => 'display:none;' ])->showWrapper(false)->setValue(self::$formId))
			->insertChild(FormBuilder::getInput('actionType', [ 'style' => 'display:none;' ])->showWrapper(false)->setValue(self::$actionType))
			->insertChild(FormBuilder::getInput('returnURL', [ 'style' => 'display:none;' ])->showWrapper(false)->setValue(Formatter::formatURL(Request::getCurrentUrl(), [ self::INPUT_NONCE => $nonce ])));
		
		$label = FormBuilder::getLabel(__('First Name'), [ 'for' => self::INPUT_FIRSTNAME ])->showAsterisk(true);
		$input = FormBuilder::getInput(self::INPUT_FIRSTNAME, [ 'maxlength' => 40 ])->setRequired(true)->setWrapperClass('input-group input-icon-user');
		$helpBlock = FormBuilder::getHelpBlock(__('Please enter your first name.'));
		$formGroupFn = FormBuilder::getFormGroup(null, $input, $label, $helpBlock);
			
		$label = FormBuilder::getLabel(__('Last Name'), [ 'for' => self::INPUT_LASTNAME ])->showAsterisk(true);
		$input = FormBuilder::getInput(self::INPUT_LASTNAME, [ 'maxlength' => 80 ])->setRequired(true)->setWrapperClass('input-group input-icon-user');
		$helpBlock = FormBuilder::getHelpBlock(__('Please enter your last name.'));
		$formGroupLn = FormBuilder::getFormGroup(null, $input, $label, $helpBlock);
			
		$label = FormBuilder::getLabel(__('Company Name'), [ 'for' => self::INPUT_COMPANY ])->showAsterisk(true);
		$input = FormBuilder::getInput(self::INPUT_COMPANY, [ 'maxlength' => 100 ])->setRequired(true)->setWrapperClass('input-group input-icon-building');
		$helpBlock = FormBuilder::getHelpBlock(__('Please enter your company name.'));
		$formGroupCompany = FormBuilder::getFormGroup(null, $input, $label, $helpBlock);
			
		$label = FormBuilder::getLabel(__('Email Address'), [ 'for' => self::INPUT_EMAIL ])->showAsterisk(true);
		$input = FormBuilder::getEmail(self::INPUT_EMAIL, [ 'maxlength' => 100 ])->setRequired(true)->setWrapperClass('input-group input-icon-envelope');
		$helpBlock = FormBuilder::getHelpBlock(__('Please enter your email address.'));
		$formGroupEmail = FormBuilder::getFormGroup(null, $input, $label, $helpBlock);
		
		$label = FormBuilder::getLabel(__('Phone Number'), [ 'for' => self::INPUT_PHONE ])->showAsterisk(false);
		$input = FormBuilder::getInput(self::INPUT_PHONE, [ 'maxlength' => 30 ])->setRequired(false)->setWrapperClass('input-group input-icon-phone');
		$helpBlock = FormBuilder::getHelpBlock(__('Please enter a correct phone number.'));
		$formGroupPhone = FormBuilder::getFormGroup(null, $input, $label, $helpBlock);
		
		$label = FormBuilder::getLabel(__('Notes'), [ 'for' => self::INPUT_DESCRIPTION ])->showAsterisk(false);
		$input = FormBuilder::getTextarea(self::INPUT_DESCRIPTION, [ 'maxlength' => 1000 ])->setRequired(false)->setWrapperClass('input-group input-icon-phone');
		$helpBlock = FormBuilder::getHelpBlock(__('Please enter a correct phone number.'));
		$formGroupNotes = FormBuilder::getFormGroup(null, $input, $label, $helpBlock);
		
		$label = FormBuilder::getLabel(__('Captcha'), [ 'for' => self::INPUT_CAPTCHA ])->showAsterisk(true);
		$input = FormBuilder::getInput(self::INPUT_CAPTCHA, [ 'maxlength' => 80 ])->setRequired(true)->setWrapperClass('input-group');
		$helpBlock = FormBuilder::getHelpBlock('Please enter the characters showing on the captcha image.');
		$formGroupCaptcha = FormBuilder::getFormGroup(null, $input, $label, $helpBlock);
		
		$label = FormBuilder::getLabel(__('Source'), [ 'for' => self::INPUT_LEADSOURCE ])->showAsterisk(false);
		$input = FormBuilder::getSelect(self::INPUT_LEADSOURCE);
		foreach (self::getLeaderSources() as $v => $source) {
			$option = FormBuilder::getOption(__($source['text']));
			if (isset($source['selected'])) {
				$option->setAttribute('selected', $source['selected'])->setAttribute('value', $v);
			}
			$input->insertChild($option);
		}
		$helpBlock = FormBuilder::getHelpBlock('');
		$formGroupLeadSource = FormBuilder::getFormGroup(null, $input, $label, $helpBlock);
		
		$captcha = FormBuilder::getHtml(sprintf('<img id="%s" src="https://crm.zoho.com/crm/CaptchaServlet?formId=%s&grpid=%s"><a class="icon-undo" href="javascript:;" title="%s"></a>',
				 self::CAPTCHA_IMAGE_ID, self::$formId, self::$formGroupId, __('Reload Captcha')));
		
		$submit = FormBuilder::getButton(__('Submit'), ['class' => 'btn btn-secondary', 'type' => 'submit']);
		$reset = FormBuilder::getButton(__('Reset'), ['class' => 'btn btn-shaded', 'type' => 'reset']);

		$colFn = FormBuilder::getCol(['class' => 'col-md-6'])->insertChild($formGroupFn);
		$colLn = FormBuilder::getCol(['class' => 'col-md-6'])->insertChild($formGroupLn);
		$colCompany = FormBuilder::getCol(['class' => 'col-md-6'])->insertChild($formGroupCompany);
		$colEmail = FormBuilder::getCol(['class' => 'col-md-6'])->insertChild($formGroupEmail);
		$colPhone = FormBuilder::getCol(['class' => 'col-md-6'])->insertChild($formGroupPhone);
		$colNotes = FormBuilder::getCol(['class' => 'col-md-6'])->insertChild($formGroupNotes);
		$colCaptcha = FormBuilder::getCol(['class' => 'col-md-6'])->insertChild($formGroupCaptcha);
		$colCaptchaImg = FormBuilder::getCol(['class' => 'col-md-6'])->insertChild($captcha);
		$colLeaderSource = FormBuilder::getCol(['class' => 'col-md-6'])->insertChild($formGroupLeadSource);
		$colSubmit = FormBuilder::getCol(['class' => 'col-md-12 text-center'])->insertChild($submit)->insertChild($reset);

		$row1 = FormBuilder::getRow([ 'class' => 'no-gutter-left no-gutter-right no-gutters-md' ])->insertChild($colFn)->insertChild($colLn);
		$row2 = FormBuilder::getRow([ 'class' => 'no-gutter-left no-gutter-right no-gutters-md' ])->insertChild($colEmail)->insertChild($colCompany);
		$row3 = FormBuilder::getRow([ 'class' => 'no-gutter-left no-gutter-right no-gutters-md' ])->insertChild($colPhone)->insertChild($colNotes);
		$row4 = FormBuilder::getRow([ 'class' => 'no-gutter-left no-gutter-right no-gutters-md' ])->insertChild($colCaptcha)->insertChild($colCaptchaImg);
		$row5 = FormBuilder::getRow([ 'class' => 'no-gutter-left no-gutter-right no-gutters-md hidden' ])->insertChild($colLeaderSource)->insertChild(FormBuilder::getCol());
		$rowSub = FormBuilder::getRow(['class' => 'no-gutter-left no-gutter-right no-gutters-md text-center'])->insertChild($colSubmit);

		$formOptions = [
			$misc,
			$row1,
			$row2,
			$row3,
			$row4,
			$row5,
			$rowSub,
		];
			
		$formBuild = new FormBuilder($formOptions, ['name' => self::getName(), 'data-toggle' => 'validator', 'role' => 'form', 'class' => 'form form-alternate', 'action' => self::$action, 'method' => 'POST', 'onSubmit' => 'javascript:document.charset="UTF-8";', 'accept-charset' => 'UTF-8' ]);
		$form = $formBuild->buildForm();
		
		return $form;
	}
	
	protected static function processAttributes(&$attrs = [], $content = '')
	{
		$attrs['content'] = do_shortcode($content);
		$attrs['isCallback'] = self::verifyNonce();
		parent::processAttributes($attrs, $content);
	}
	
	protected static function postProcessWidget(&$widget)
	{
		\wp_enqueue_script($handle = 'widgets/zoho-demo-request-form.js');
		\wp_localize_script($handle, 'zohoDemoRequestObject', [
			'form' => [
				'name' => self::getName(),
				'elements' => [
					'firstName' => self::INPUT_FIRSTNAME,
					'lastName' => self::INPUT_LASTNAME,
					'company' => self::INPUT_COMPANY,
					'email' => self::INPUT_EMAIL,
					'phone' => self::INPUT_PHONE,
					'notes' => self::INPUT_DESCRIPTION,
					'leadsource' => self::INPUT_LEADSOURCE,
					'captcha' => self::INPUT_CAPTCHA,
					'captchaImage' => '#' . self::CAPTCHA_IMAGE_ID,
					'captchaReload' => '#' . self::CAPTCHA_IMAGE_ID . ' + a',
				]
			],
			'submissionMessage' => sprintf('#%s .submission-message', self::$formContainerId),
		]);
	}
	
	protected static function getNonce()
	{
		return Utils::getOneTimeNonce(self::class, self::getAction());
	}
	
	protected static function verifyNonce()
	{
		$nonce = Request::getValue(static::INPUT_NONCE);
		return Utils::verifyOneTimeNonce($nonce, self::class, self::getAction());
	}
	
	protected static function getLeaderSources()
	{
		return self::$leaderSources;
	}
}
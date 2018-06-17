<?php

namespace Roots\Sage\Customization\Widgets;

use Roots\Sage\Customization\Classes\Widgets\Shortcode\ZohoDemoRequestForm;

define('WIDGET_ZOHO_DEMO_REQUEST_FORM', 'zoho-demo-request-form');

add_shortcode(WIDGET_ZOHO_DEMO_REQUEST_FORM, [ ZohoDemoRequestForm::class, 'widget' ]);
ZohoDemoRequestForm::initAction();
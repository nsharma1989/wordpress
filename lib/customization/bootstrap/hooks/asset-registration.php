<?php

namespace Roots\Sage\Customization\Bootstrap\Hooks;

use Roots\Sage\Assets;

/**
 * Register custom assets
 */
function register_assets() {
	global $wp_scripts, $wp_styles;
	
	if (wp_style_is($handle = 'sage/css', 'enqueued')) {
		if (file_exists($path = Assets\asset_file_path('styles/main.css'))) {
			$wp_styles->registered[$handle]->ver = filemtime($path);
		}
	}
	
	if (wp_script_is($handle = 'sage/js', 'enqueued')) {
		if (file_exists($path = Assets\asset_file_path('scripts/main.js'))) {
			$wp_scripts->registered[$handle]->ver = filemtime($path);
		}
	}

	$scripts = [
		[
			'handle' => 'pages/main/panel-products.js',
			'src' => 'scripts/customization/pages/main/panel-products.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'pages/main/panel-rates.js',
			'src' => 'scripts/customization/pages/main/panel-rates.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'pages/main/panel-app-demo.js',
			'src' => 'scripts/customization/pages/main/panel-app-demo.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'pages/main/panel-media-mentions.js',
			'src' => 'scripts/customization/pages/main/panel-media-mentions.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'pages/press/panel-images.js',
			'src' => 'scripts/customization/pages/press/panel-images.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'pixels/goodway.js',
			'src' => 'scripts/customization/pixels/gwp.js',
			'in_footer' => true
		],
		[
			'handle' => 'pixels/crazyegg.js',
			'src' => 'scripts/customization/pixels/cep.js',
			'in_footer' => true
		],
		[
			'handle' => 'pixels/adroll.js',
			'src' => 'scripts/customization/pixels/ad.js',
			'in_footer' => true
		],
		[
			'handle' => 'pixels/facebook.js',
			'src' => 'scripts/customization/pixels/fb.js',
			'in_footer' => true
		],
		[
			'handle' => 'pixels/google.js',
			'src' => 'scripts/customization/pixels/ga.js',
			'in_footer' => true
		],
		[
			'handle' => 'widgets/whatsapp-banner.js',
			'src' => 'scripts/customization/widgets/wab.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/chat-widget.js',
			'src' => 'scripts/customization/widgets/cw.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/career-application-form.js',
			'src' => 'scripts/customization/widgets/caf.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/password-reset-form.js',
			'src' => 'scripts/customization/widgets/prf.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/password-reset-request-form.js',
			'src' => 'scripts/customization/widgets/prrf.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/business-rate-request-form.js',
			'src' => 'scripts/customization/widgets/brrf.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/newsletter-form.js',
			'src' => 'scripts/customization/widgets/nf.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/business-rates-table.js',
			'src' => 'scripts/customization/widgets/brt.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/rates-table.js',
			'src' => 'scripts/customization/widgets/rt.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/rates-continent.js',
			'src' => 'scripts/customization/widgets/rc.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/email-support-request-form.js',
			'src' => 'scripts/customization/widgets/esrf.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/demo-request-form.js',
			'src' => 'scripts/customization/widgets/drf.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/zoho-demo-request-form.js',
			'src' => 'scripts/customization/widgets/zdrf.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'widgets/product-table.js',
			'src' => 'scripts/customization/widgets/pt.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
		[
			'handle' => 'templates/template-product.js',
			'src' => 'scripts/customization/templates/tp.js',
			'deps' => ['jquery'],
			'in_footer' => true
		],
	];

	foreach ($scripts as $script) {
		if (isset($script['handle']) && !empty($handle = $script['handle']) 
			&& isset($script['src']) && !empty($src = $script['src'])) {
			wp_register_script($handle, 
				Assets\asset_path($src), 
				isset($script['deps']) ? $script['deps'] : [], 
				isset($script['ver']) ? $script['ver'] : (file_exists($path = Assets\asset_file_path($src)) ? filemtime($path) : false), 
				isset($script['in_footer']) ? $script['in_footer'] : false
			);
		}
	}
	
	$styles = [
		[
			'handle' => 'comp-ie.css',
			'src' => 'styles/comp-ie.css',
		]
	];
	
	foreach ($styles as $style) {
		if (isset($style['handle']) && !empty($handle = $style['handle'])
			&& isset($style['src']) && !empty($src = $style['src'])) {
			wp_register_style($handle,
				Assets\asset_path($src),
				isset($style['deps']) ? $style['deps'] : [],
				isset($style['ver']) ? $style['ver'] : (file_exists($path = Assets\asset_file_path($src)) ? filemtime($path) : false),
				isset($style['media']) ? $style['media'] : 'all'
			);
		}
	}
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\register_assets', 101);
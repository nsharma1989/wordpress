(function($) {
	'use strict';

	if (typeof zohoDemoRequestObject === 'undefined') {
		console.error('Unable to load demo request object.');
		return;
	}
	
	var mndFileds=new Array(zohoDemoRequestObject.form.elements.company, zohoDemoRequestObject.form.elements.lastName);
	var fldLangVal=new Array(zohoDemoRequestObject.form.elements.company, zohoDemoRequestObject.form.elements.lastName);
	var name='';
	var email='';
	var captchaImage = $(zohoDemoRequestObject.form.elements.captchaImage);
	var captchaReload = $(zohoDemoRequestObject.form.elements.captchaReload);
	
	var _checkoutMandatory = function() {
		for(i=0;i<mndFileds.length;i++) {
			var fieldObj=document.forms[zohoDemoRequestObject.form.name][mndFileds[i]];
			if(fieldObj) {
				if (((fieldObj.value).replace(/^\s+|\s+$/g, '')).length === 0) {
					if(fieldObj.type === 'file')
						{ alert('Please select a file to upload.'); fieldObj.focus(); return false; }
					alert(fldLangVal[i] +' cannot be empty.'); 
					fieldObj.focus();
					return false;
				} else if(fieldObj.nodeName === 'select') {
					if(fieldObj.options[fieldObj.selectedIndex].value === 'None')
						{ alert(fldLangVal[i] +' cannot be none.'); fieldObj.focus(); return false; }
				} else if(fieldObj.type === 'checkbox'){
					if(fieldObj.checked === false)
						{ alert('Please accept '+fldLangVal[i]); fieldObj.focus(); return false; }

				}
				try {
					if(fieldObj.name === zohoDemoRequestObject.form.elements.lastName)
						{ name = fieldObj.value; }
				} catch (e) {}
			}
		}
	};

	var _reloadImage = function() {
		var captchaImgDom = captchaImage.get(0);
		if(captchaImgDom.src.indexOf('&d') !== -1 ) {
			captchaImgDom.src=captchaImgDom.src.substring(0, captchaImgDom.src.indexOf('&d')) + '&d' + new Date().getTime(); 
		} else { 
			captchaImgDom.src = captchaImgDom.src+'&d'+new Date().getTime();
		}
	};

	var form = $('form[name="' + zohoDemoRequestObject.form.name + '"]');
	form.validator().on('submit', function(e) {
		if (! _checkoutMandatory()) {
			e.preventDefault();
			e.stopPropagation();

			return false;
		}
	});
	captchaReload.click(function() {
		_reloadImage();
	});

	var submissionMessage = $(zohoDemoRequestObject.submissionMessage);
	if (submissionMessage.length) {
		smoothScroll.animateScroll(submissionMessage[0]);
		setTimeout(function() {
			jQuery(zohoDemoRequestObject.submissionMessage).fadeOut();
		}, 3500);
	}
})(jQuery);
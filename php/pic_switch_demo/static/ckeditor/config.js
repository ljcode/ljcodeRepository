/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbar = 'Full';
	config.toolbar_Full =
		[
		    ['Source','-','NewPage','Preview','-','Templates'],
		    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
		    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
		    '/',
		    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		    ['Link','Unlink','Anchor'],
		    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		    '/',
		    ['Styles','Format','Font','FontSize'],
		 ['TextColor','BGColor']
		];
	config.width = 1128;
	config.height = 300;
	config.image_previewText = ' ';
	config.filebrowserBrowseUrl = '/static/ckeditor/ckfinder/ckfinder.html';  
    config.filebrowserImageBrowseUrl = '/static/ckeditor/ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl = '/static/ckeditor/ckfinder/ckfinder.html?Type=Flash'; 
  	config.filebrowserUploadUrl = '/static/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
   	config.filebrowserImageUploadUrl = '/static/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '/static/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
    config.filebrowserWindowWidth = '800';  
	config.filebrowserWindowHeight = '500'; 	
};

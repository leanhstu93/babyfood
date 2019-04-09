/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:

	// config.language = 'vi';
	 config.skin = 'moonocolor';
	 config.allowedContent = true;
	 //config.uiColor = '#fff';
	config.filebrowserBrowseUrl = window.location.protocol + "//" + window.location.host+'/ckfinder/user/html';
	config.filebrowserImageBrowseUrl = window.location.protocol + "//" + window.location.host+'/ckfinder/user/html?type=Images';
	
	config.filebrowserFlashBrowseUrl = window.location.protocol + "//" + window.location.host+'/ckfinder/user/html?type=Flash';
	 
	config.filebrowserUploadUrl = window.location.protocol + "//" + window.location.host+'/ckfinder/user/connector?command=QuickUpload&type=Files';
	 
	config.filebrowserImageUploadUrl = window.location.protocol + "//" + window.location.host+'/ckfinder/user/connector?command=QuickUpload&type=Images';
	 
	config.filebrowserFlashUploadUrl =window.location.protocol + "//" + window.location.host+'/ckfinder/user/connector?command=QuickUpload&type=Flash';
	
};

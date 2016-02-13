CKEDITOR.editorConfig = function( config ) {
	config.skin = 'modx';

//	config.resize_enabled = false;
	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'undo', 'clipboard' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Save,NewPage,Preview,Print,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Underline,JustifyBlock,BidiLtr,BidiRtl,Language,PageBreak,Iframe,Font,FontSize,TextColor,BGColor,About,Cut,Copy,Paste,Styles,PasteText,Find,PasteFromWord,Smiley,CreateDiv,Image,Flash,Table,HorizontalRule,SpecialChar,Anchor,Replace,Templates,Subscript,Superscript,Strike,Blockquote,JustifyLeft,JustifyCenter,JustifyRight,Format,CommentSelectedRange,UncommentSelectedRange';
};
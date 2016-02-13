<?php
/*
Part of Content Editor Tools. Supports CET_assetsTV for file management.
Adds CKEditor as Rich Text Editor. You can add RTE to description and introtext. All settings in plugin's preferences tab.
Author Denis Dyranov (Dyranov.ru)
Thanks to donshakespeare and his TinymceWrapper for some code.
Version: 0.8
*/

$modx->getService('error', 'error.modError', '', '');
$modxEventName = $modx->event->name;

if ($modxEventName == 'OnRichTextEditorRegister') {
	$modx->event->output('CET_CKEditor');
	return;
}

$useEditor = $modx->getOption('use_editor');
$whichEditor = $modx->getOption('which_editor');
$richtext_default = $modx->getOption('richtext_default');

if ($modxEventName == 'OnDocFormPrerender') {
	$loadRTE = 0; //default
	if ($useEditor == 1 && $whichEditor == 'CET_CKEditor') {
		$loadRTE = 1;
	} else {
		return false;
	}
	if (isset($scriptProperties['resource']) && $resource->get('richtext')) { //existing resource with RTE clicked
		$loadRTE = 1;
	} else {
		$loadRTE = 0;
	}
	if ($mode == 'new' && $richtext_default == 1) {
		$loadRTE = 1;
	}
	
	if ($loadRTE == 0) {
		return false;
	} else {
		
		$sticky_toolbar = $modx->getOption('sticky_toolbar', $scriptProperties, '{}');
		$outline_blocks = $modx->getOption('outline_blocks', $scriptProperties, '{}');
		$disable_tooltips = $modx->getOption('disable_tooltips', $scriptProperties, '{}');
		$rte_for_description = $modx->getOption('rte_for_description', $scriptProperties, '{}');
		$rte_for_introtext = $modx->getOption('rte_for_introtext', $scriptProperties, '{}');
		$rte_for_tvs = $modx->getOption('rte_for_tvs', $scriptProperties, '{}');
		$contentCss = $modx->getOption('contentCss', $scriptProperties, '{}');
		$usebootstrap = $modx->getOption('useBootstrap', $scriptProperties, '{}');
		$path = $modx->getOption('assets_url') . 'components/CET_CKEditor/';
		$full_CKEditor_plugins = $modx->getOption('full_CKEditor_plugins', $scriptProperties, '{}');
		$full_CKEditor_options = $modx->getOption('full_CKEditor_options', $scriptProperties, '{}');
		$light_CKEditor_plugins = $modx->getOption('light_CKEditor_plugins', $scriptProperties, '{}');
		$light_CKEditor_options = $modx->getOption('light_CKEditor_options', $scriptProperties, '{}');
		
		switch ($rte_for_description) {
			case "light":
				$light_rte_fields = '#modx-resource-description, ' . $light_rte_fields;
				break;
			case "full":
				$full_rte_fields = '#modx-resource-description, ' . $full_rte_fields;
				break;
		}
		
		switch ($rte_for_introtext) {
			case "light":
				$light_rte_fields = '#modx-resource-introtext, ' . $light_rte_fields;
				break;
			case "full":
				$full_rte_fields = '#modx-resource-introtext, ' . $full_rte_fields;
				break;
		}
		
		switch ($rte_for_tvs) {
			case "light":
				$light_rte_fields = '.modx-richtext, ' . $light_rte_fields;
				break;
			case "full":
				$full_rte_fields = '.modx-richtext, ' . $full_rte_fields;
				break;
		}
		
		$light_rte_fields = trim($light_rte_fields, ', ');
		$full_rte_fields = trim($full_rte_fields, ', ');
		
		
		
		if ($usebootstrap == true) {
			$contentCss = 'contentsCss: ["' . $path . 'bootstrap/bootstrap.min.css","' . $contentCss . '"],';
			$addbootstrapcss = 'on: {
									instanceReady: loadBootstrap,
									mode: loadBootstrap
								},
			';
			$addbootstrapjs = 'function loadBootstrap(event) {
				  var jQueryScriptTag = document.createElement("script");
				  var bootstrapScriptTag = document.createElement("script");
  
				  jQueryScriptTag.src = "' . $path . 'bootstrap/jquery.min.js";
				  bootstrapScriptTag.src = "' . $path . 'bootstrap/bootstrap.min.js";
  
				  var editorHead = event.editor.document.$.head;

				  editorHead.appendChild(jQueryScriptTag);
				  jQueryScriptTag.onload = function() {
					editorHead.appendChild(bootstrapScriptTag);
				  };
        	    }';
		} else {
			$contentCss = 'contentsCss: "' . $contentCss . '",';
			$addbootstrapcss = '';
			$addbootstrapjs = '';
		}
		
		
		if ($outline_blocks == true) {
			$outline_blocks = "startupOutlineBlocks: true,";
		}
		
		$LightCKEdtitorPlugins = $light_CKEditor_plugins.'quicktable,autogrow,codemirror,CETTypograf';
		$FullCKEdtitorPlugins = $full_CKEditor_plugins.'quicktable,autogrow,codemirror,CETTypograf,oembed,widget';
		
		if ($sticky_toolbar == true) {
			$FullCKEdtitorPlugins = $FullCKEdtitorPlugins . ',sharedspace';
			$sticky_toolbar = 'sharedSpaces: {
										top: "cet_stikytoolbar"
									},';
			$sticky_js = 'StickyToolbar()';
		} else {
			$sticky_toolbar = 'autoGrow_maxHeight: window.innerHeight - 230,';
			$sticky_js = "";
		}
		
		$LightCKEditorProps = '
			uiColor: "#f1f1f1",
			allowedContent: true,
			' . $outline_blocks . '
			extraPlugins: "' . $LightCKEdtitorPlugins . '",
			language: "' . $modx->getOption('lang', $scriptProperties, '{}') . '",
			' . $light_CKEditor_options . '
			Typograf: "' . $modx->getOption('typograf', $scriptProperties, '{}') . '",
			TypografPath: "' . $path . '",
		';
		
		$FullCKEditorProps = '
			uiColor: "#f1f1f1",
			allowedContent: true,
			' . $outline_blocks . '
			' . $contentCss . '
			extraPlugins: "' . $FullCKEdtitorPlugins . '",
			language: "' . $modx->getOption('lang', $scriptProperties, '{}') . '",
			//quick table config
			qtRows: 20, // Count of rows
			qtColumns: 20, // Count of columns
			qtBorder: "1", // Border of inserted table
			qtWidth: "100%", // Width of inserted table
			qtStyle: { "border-collapse" : "collapse" },
			qtClass: "table", // Class of table
			qtCellPadding: "0", // Cell padding table
			qtCellSpacing: "0", // Cell spacing table
			qtPreviewBorder: "1px solid #ccc", // preview table border 
			qtPreviewSize: "10px", // Preview table cell size 
			qtPreviewBackground: "#c8def4", // preview table background (hover)
			' . $full_CKEditor_options . '
			Typograf: "' . $modx->getOption('typograf', $scriptProperties, '{}') . '",
			TypografPath: "' . $path . '",
		';
		
		
		$Init = file_get_contents($modx->getOption('assets_path') . 'components/CET_CKEditor/Init.js');
		if (!$Init) {
			$Init = 'RTE not found';
		};

		$props = array(
			"light_rte_fields" => $light_rte_fields,
			"full_rte_fields" => $full_rte_fields,
			"FullCKEditorConfig" => $path.$modx->getOption('full_rte_config', $scriptProperties, '{}'),
			"LightCKEditorConfig" => $path.$modx->getOption('light_rte_config', $scriptProperties, '{}'),
			"FullCKEditorProps" => $FullCKEditorProps,
			"LightCKEditorProps" => $LightCKEditorProps,
			"addbootstrapcss" => $addbootstrapcss,
			"sticky_toolbar" => $sticky_toolbar,
			"default_path" => $modx->getOption('default_browser_path', $scriptProperties, '{}')
		);
		
		foreach ($props as $key => $value) {
			$Init = str_replace('[[' . $key . ']]', $value, $Init);
		}
		
		
		$modx->controller->addHtml('
		  <script src="' . $path . 'bootstrap/jquery.min.js"></script>
		  <script type="text/javascript" src="' . $path . 'ckeditor.js"></script>
		  <link rel="stylesheet" type="text/css" href="' . $path . 'CET_CKEditor.css" />
		  
		  <script>
		  Ext.onReady(function() {
		  ' . $Init . '
		  ' . $sticky_js . '
		  initRTE()
		  });
		  ' . $addbootstrapjs . '
		  </script>
		');
		
		//disable tooltips
		if ($disable_tooltips == 1) {
			$modx->regClientStartupHTMLBlock('
			  <script type="text/javascript">
				Ext.onReady(function() {
					Ext.QuickTips.disable();
				});
			  </script>
			');
		}
	}
}
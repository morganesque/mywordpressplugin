<?php

// Customize the format dropdown items
if( !function_exists('tommorgan_custom_mce_format') )
{
	function tommorgan_custom_mce_format($init) 
	{
		// Add block format elements you want to show in dropdown
		$init['theme_advanced_blockformats'] = 'p,h2,h3,h4,blockquote';
		// Add elements not included in standard tinyMCE dropdown p,h1,h2,h3,h4,h5,h6
		//$init['extended_valid_elements'] = 'code[*]';

		// adding the table plugin in (you may need to download this).
        $init['plugins'] .= ', table';

        // first line of buttons – patented Tom selection.
		$init['theme_advanced_buttons1'] = 'undo,redo,bold,italic,strikethrough,underline,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,link,unlink,spellchecker';

		// second link of buttons.
		$init['theme_advanced_buttons2'] = 'formatselect,pastetext,pasteword,tablecontrols';
		
		return $init;
	}
	add_filter('tiny_mce_before_init', 'tommorgan_custom_mce_format' );
} 
else die("There's already a function called <b>tommorgan_custom_mce_format</b> so this plugin won't work.");

?>
CKEDITOR.replace( 'html-editor', {


/*toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
		'/',																					// Line break - next group will be placed in new line.
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
	],*/

	toolbarGroups: [
		{ name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
 		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.														
 		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
 		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
 		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
 		{ name: 'insert' },
 		{ name: 'links' },
 		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'tools' },
		{ name: 'others' }
	]



	// NOTE: Remember to leave 'toolbar' property with the default value (null).
});
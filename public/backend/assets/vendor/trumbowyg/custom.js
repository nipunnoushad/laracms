function loadTrumbowyg(idOrClassName){
    $(idOrClassName).trumbowyg({
 	   btns: [
 	   		['viewHTML'],
	        ['undo', 'redo'], // Only supported in Blink browsers
	        ['formatting'],
	        ['strong', 'em', 'del'],
	        ['superscript', 'subscript'],
	         ['foreColor', 'backColor'],
	        ['link'],
	        ['insertImage'],
	        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
	        ['unorderedList', 'orderedList'],
	        ['horizontalRule'],
	        ['removeformat'],
	        ['fullscreen'],
	        ['fontsize'],
	    ],
	    autogrow: true,
        plugins: {
            fontsize: {
                sizeList: [
                    '12px',
                    '14px',
                    '18px',
                    '22px',
                    '30px',
                ],
                allowCustomSize: true
            },

             colors: {
	            colorList: [
	                '000', '111', '222', 'ffea00'
	            ]
	        }
        
        }
    });
}
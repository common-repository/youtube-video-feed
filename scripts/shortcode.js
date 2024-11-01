// JavaScript Document
    (function() {  
        tinymce.create('tinymce.plugins.plumwd_youtube_display', {  
            init : function(ed, url) {  
			var newurl = url.substring(0, url.length -8);
                ed.addButton('plumwd_youtube_display', {  
                    title : 'Insert YouTube Feed',  
                    image : newurl+'/images/youtube.png',  
                    onclick : function() {  
                         ed.selection.setContent('[plumwd_youtube_display channel="" videonum="4" display="horizontal" size="small"]');        
                    }  
                }); 
				
            },  
            createControl : function(n, cm) {  
                return null;  
            },  
        });  
        tinymce.PluginManager.add('plumwd_youtube_display', tinymce.plugins.plumwd_youtube_display);  
    })();  
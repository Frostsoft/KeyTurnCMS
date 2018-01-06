$(document).ready(function(){

+function ($) {
    'use strict';
    
    // CURSOR POSITION FUNCTION
    // =======================
    (function ($, undefined) {
        $.fn.getCursorPosition = function () {
            var el = $(this).get(0);
            var pos = 0;
            if ('selectionStart' in el) {
                pos = el.selectionStart;
            } else if ('selection' in document) {
                el.focus();
                var Sel = document.selection.createRange();
                var SelLength = document.selection.createRange().text.length;
                Sel.moveStart('character', -el.value.length);
                pos = Sel.text.length - SelLength;
            }
            return pos;
        }
    })(jQuery);

    // WELCOME MESSAGE
    // ===============

	//$('#welcomeMessage').modal('show'); - currently disabled
    
    // BUG REPORTER
    // ============

    var toggle_bug_reporter = false;
    $("#toggle_bug_reporter").on('click', function(e){ 
        e.stopPropagation();
        if(!toggle_bug_reporter){
            $("#left_bug_sidebar").addClass("leftmodal-toggled");
            $("#toggle_bug_reporter").addClass("toggle_html_toggled");
            $("#toggle_bug_reporter").html('<i class="fa fa-bug"></i><br/> Close Bug Reporter');
            toggle_bug_reporter=true;
        }else{
            $("#left_bug_sidebar").removeClass("leftmodal-toggled");
            $("#toggle_bug_reporter").removeClass("toggle_html_toggled");
            $("#toggle_bug_reporter").html('<i class="fa fa-bug"></i><br/> Report Bug');
            toggle_bug_reporter=false;
        }
    });


    $("#submitBugReport").click( function() {
	    $.ajax({
            type: "POST",
            url: "sendmail.php",
            data: {
                maildata : "From: " + $("#nameBug").val() + "\nBug Description: " + $("#descBug").val() + "\nReproduction: " + $("#reproBug").val(),
                mailsubject: "[BUG REPORT] " + $("#nameBug").val(),
                to: "james@keyturnmedia.com"
            },
            dataType:'text',
        });
   });
   
   // GLOBALLY SELECTED ELEMENTS
   // ==========================

	var current_img;
    var current_text;
   
    // REPLACE ALL HREF WITH DHREF
    // ===========================

    $('div#docBody').each( function() { 
        $(this).html($(this).html().replace(/href/g,'dhref'));
    });

    // ADD EDITABLE CLASS TO ALL VALID ELEMENTS
    // ========================================

	$('div#docBody p, div#docBody a, div#docBody span, div#docBody h1, div#docBody h2, div#docBody h3, div#docBody h4, div#docBody h5, div#docBody h6, div#docBody small').addClass("editable_text");
	$('div#docBody img').addClass("editable_img");

	$('div[pid]').children().append("<delbtn class='delDynamic'><i class='fa fa-trash'></i></delbtn>");
   
    // ADD THE "ADD" BUTTON TO DYNAMIC ELEMENTS
    // ========================================

    $("div[pid]").each( function() { 
	$(this).append("<addbtn class='addDynamic' pid='" + $(this).attr("pid") + "'>Add</addbtn>");
	$(this).addClass("dynamicParent");
    });
   
    $("addbtn[pid]").on('click', function() {
        var parent = $(this).parent();
	    $.ajax({
            type: "POST",
            url: "plugins/pluginman.php",
            data: {
                pid : $(this).attr("pid")
                },
            dataType:'text', //or HTML, JSON, etc.
            success: function(response){
				var html = $($.parseHTML(response)).append("<delbtn class='delDynamic'><i class='fa fa-trash'></i></delbtn>");

                if($(html).prop("tagName") == "IMG"){
                    $(html).addClass("editable_img");
                }

                if($(html).is("p,a,span,h1,h2,h3,h4,h5,h6")){
                    $(html).addClass("editable_text");
                }

				$(html).find("img").addClass("editable_img");
				$(html).find("p,a,span,h1,h2,h3,h4,h5,h6").addClass("editable_text");
                parent.append(html);
            }
        });
    });
   
	$("div#docBody").on('click', 'delbtn', function(){
		$(this).parent().remove();
	});

    // HANDLE EDITABLE TEXT AND IMAGE CLICK EVENTS
    // ===========================================

    $("div#docBody").on('click', '.editable_text', function(e){ 
        e.stopPropagation();
		current_text = $(this);
		var tag_type = $(this).prop("tagName");
		
		$("div#updateText #newText").val($(this).html());
		$("div#updateText #textClasses").val($(this).attr("class").replace("editable_text", ""));
		if(tag_type.toLowerCase() == "a"){
			$("div#updateText #hrefOptions").attr("style", "display:block;");
			$("div#updateText #linkHref").val($(this).attr("dhref"));
		}else{
			$("div#updateText #hrefOptions").attr("style", "display:none;");
		}
		
		// $("#updateText").modal();
    });
    
    $("div#docBody").on('click', '.editable_img', function(e){
        e.stopPropagation();
		current_img = $(this);
		$("#imageAlt").val(current_img.attr("alt"));
		$("#imageClass").val($(this).attr("class").replace("editable_img", ""));
		//$("#changeImage").modal();
    });
    
    // SIDEBAR CODE
    // ============

    var text_sidebar_toggle = false;
    var image_sidebar_toggle = false;
    var main_sidebar_toggle = false;


    function toggleTextSidebar(state){

        if(image_sidebar_toggle){
            toggleImageSidebar(false);
        }
        if(main_sidebar_toggle){
            toggleMainSidebar(false);
        }

        if(state == true){
            if(!text_sidebar_toggle){
                $("#text_sidebar").addClass("sidebar-toggled");
                text_sidebar_toggle=true;
            }
        }else{
            if(text_sidebar_toggle){
                $("#text_sidebar").removeClass("sidebar-toggled");
                text_sidebar_toggle=false;
            }
        }
    }

    function toggleImageSidebar(state){

        if(text_sidebar_toggle){
            toggleTextSidebar(false);
        }
        if(main_sidebar_toggle){
            toggleMainSidebar(false);
        }

        if(state == true){
            if(!image_sidebar_toggle){
                $("#image_sidebar").addClass("sidebar-toggled");
                image_sidebar_toggle=true;
            }
        }else{
            if(image_sidebar_toggle){
                $("#image_sidebar").removeClass("sidebar-toggled");
                image_sidebar_toggle=false;
            }
        }
    }

    function toggleMainSidebar(state){
        
                if(text_sidebar_toggle){
                    toggleTextSidebar(false);
                }
                if(image_sidebar_toggle){
                    toggleImageSidebar(false);
                }
        
                if(state == true){
                    if(!main_sidebar_toggle){
                        $("#main_sidebar").addClass("sidebar-toggled");
                        main_sidebar_toggle=true;
                    }
                }else{
                    if(main_sidebar_toggle){
                        $("#main_sidebar").removeClass("sidebar-toggled");
                        main_sidebar_toggle=false;
                    }
                }
            }

    function toggleAll(){
        toggleMainSidebar(false);
        toggleTextSidebar(false);
        toggleImageSidebar(false);
    }


    //Handle element clicks

    $("div#docBody").on('click', '.editable_text', function(e){ 
        e.stopPropagation();
        //if(!text_sidebar_toggle){$("#text_sidebar").animate({width:'20vw'});text_sidebar_toggle=true;}
        toggleTextSidebar(true);
        $("#content_textarea").val($(this).html());
        var tag_type = current_text.prop("tagName");
		if(tag_type.toLowerCase() == "a"){
            $("#href_edit").val($(this).attr("dhref"));
            $("#href_edit").attr("style", "display:block;");
		}else{
            $("#href_edit").attr("style", "display:none;");
		}
    });

    $("div#docBody").on('click', '.editable_img', function(e){ 
        e.stopPropagation();
        toggleImageSidebar(true);
        $("#image_alternate").val($(this).attr("alt"));
        $("#image_select").val($(this).attr("src").split('/').pop()).change();
    });

    $("#toggleMenuBar").on('click', function(e){ 
        e.stopPropagation();
        toggleMainSidebar(true);
    });

    //handle globals

    $("button#collapse_sidebar").on('click', function(e){ 
        e.stopPropagation();
        toggleAll();
    });

    $("div#docBody").on('click', function(e){
        e.stopPropagation();
        toggleAll();
    });

    $("#update_content_sidebar").on('click', function(e){
        e.stopPropagation();
        toggleAll();
    });


    //handle independant change functions
    
    $('#content_textarea').on('input', function() {
		current_text.html($("#content_textarea").val());
    });
    $('#href_edit').on('input', function() {
		current_text.attr('dhref', $("#href_edit").val());
    });

    $('#image_alternate').on('input', function() {
		current_img.attr('alt', ($("#image_alternate").val()));
    });
    $('#image_select').on('change', function() {
        current_img.attr('src', location.protocol + "//" + location.host + "/images/" + this.value);
    })



    // HANDLE LEFT SIDEBAR
    var toggle_left_sidebar = false;
    var has_loaded_dom = false;
    $("#toggle_html").on('click', function(e){ 
        e.stopPropagation();
        if(!toggle_left_sidebar){
            $("#left_sidebar").addClass("leftmodal-toggled");
            $("#toggle_html").addClass("toggle_html_toggled");
            $("#toggle_html").html('<i class="fa fa-code"></i><br/> Close HTML Editor');
            if(!has_loaded_dom){$('#edit_html').html($('#docBody').html());has_loaded_dom=true;}
            toggle_left_sidebar=true;
        }else{
            $("#left_sidebar").removeClass("leftmodal-toggled");
            $("#toggle_html").removeClass("toggle_html_toggled");
            $("#toggle_html").html('<i class="fa fa-code"></i><br/> Raw HTML');
            $('#docBody').html($('#edit_html').val());
            toggle_left_sidebar=false;
        }
    });

      

    // HANDLE TEXT AND IMAGE MODAL EVENTS
    // ==================================

	$("div#updateText #confirmChange").on('click', function(){
		var tag_type = current_text.prop("tagName");
		current_text.attr("class", $("div#updateText #textClasses").val());
		current_text.html($("div#updateText #newText").val());
		current_text.addClass("editable_text");
		
		if(tag_type.toLowerCase() == "a"){
			current_text.attr("dhref", $("div#updateText #linkHref").val());
		}else{
			$("div#updateText #hrefOptions").attr("style", "display:none;");
		}
	});

	$('#imageList').on('change', function (e) {
		$("#displaySelectedImage").attr("src", "../images/" + $(this).val());
	});
	
	$("div#changeImage #confirmChange").on('click', function(){
		current_img.attr("src", location.protocol + "//" + location.host + "/images/" + $("#imageList").val());
		current_img.attr("alt", $("#imageAlt").val());
		current_img.attr("class", $("#imageClass").val());
		current_img.addClass("editable_img");
	});
    

    // OPEN DOCUMENT HTML MODAL
    $('#openHTML').on('click', function(){
        $('#htmlbody').html($('#docBody').html());
        //$('#editHTML').modal('show');
    });

    // HANDLE DOCBODY HTML REPLACE
    $("div#editHTML #confirmChange").on('click', function(){
        $('#docBody').html($('div#editHTML #htmlbody').val());
    });

    // EDITOR MANAGER TOGGLE
    // =====================
    $("#toggleMenuBar").click(function() {
        $("#top_bar").toggle();
    });


    function escapeRegExp(str) {
  return str.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"); // $& means the whole matched string
}
    // HANDLE PAGE SAVE
    // ================
    
	$("#btnSavePage").on('click', function(){
		$('.editable_text').removeClass('editable_text');
		$('.editable_img').removeClass('editable_img');
		$('.dynamicParent').removeClass('dynamicParent');
		$('addbtn').remove();
		$('delbtn').remove();
		$('div#docBody').each( function() { 
			$(this).html($(this).html().replace(/dhref/g,'href'));
        });

        /**var website_url = escapeRegExp("<?php echo $website; ?>");
        $('div#docBody').each( function() { 
            var re = new RegExp(website_url,"g");
			$(this).html($(this).html().replace(re,'{%ROOT%}'));
		});**/
		var str = $("div#docBody").html();
		$("#draftDoc").val(Base64.encode(str));
		$("#savedraft").submit();
	});
   

    // SESSION KEEP ALIVE
    // ==================
    setInterval(function(){$.post('keepalive.php');},600000);

}(jQuery);

});
$(document).ready(function(){

+function ($) {
    'use strict';
    
    // WELCOME MESSAGE
    // ===============

	//$('#welcomeMessage').modal('show'); - currently disabled
    
    // BUG REPORTER
    // ============

    $("#openBugPrompt").click( function() {
	    $('#reportABug').modal('show');
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
		
		$("#updateText").modal();
    });
    
    $("div#docBody").on('click', '.editable_img', function(e){
        e.stopPropagation();
		current_img = $(this);
		$("#imageAlt").val(current_img.attr("alt"));
		$("#imageClass").val($(this).attr("class").replace("editable_img", ""));
		$("#changeImage").modal();
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
        $('#editHTML').modal('show');
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
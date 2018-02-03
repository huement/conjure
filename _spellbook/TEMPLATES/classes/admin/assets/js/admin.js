var upshotCounter = 0;
var previewIframeSaved, WYSIWYGTML, editorHTML = "";
var fetchedOnce = false;

function loadEmailPreview(){
    var previewIframe = jQuery('#email_preview').contents().find('#customize-preview iframe').attr("src") ;

    if(previewIframe !== undefined && previewIframe.length > 10)
    {
        upshotCounter = 100;
        previewIframeSaved = previewIframe;
        jQuery("#email_preview").attr("src", previewIframe);
        jQuery("#PREVIEWFRAME").css("height","550px").css("width","100%");
        emailBtnReady();
        fetchedOnce = true;
    }
    else if(upshotCounter < 50)
    {
        upshotCounter++;
        setTimeout("loadEmailPreview()", 500);
    }
}

function AdminGrabLink(){
    var newURL = jQuery('a:contains("Email Templates")').attr("href");
    jQuery("#email_preview").attr("src", newURL);

    setTimeout("loadEmailPreview()", 500);
}

function emailBtnLoad(){
    jQuery('#upshotPreview').prop('disabled', true).addClass('btn-danger').removeClass('btn-default').text("Loading...");
}

function emailBtnReady(){
    jQuery('#upshotPreview').prop('disabled', false).addClass('btn-primary').removeClass('btn-danger').text("Email Preview");
}

function showModalEP(){
    jQuery('#emailPrevModal').modal('show');
}

jQuery(document).ready(function( $ ) {

    var htmlTarget = $("#UPSHOTADMIN").html();

    if(htmlTarget  !== undefined && htmlTarget.length > 10 )
    {
        emailBtnLoad();
        setTimeout("AdminGrabLink()", 1000);

        // $('#upshotPreview').on("click",function(ev){
        //     if($(this).prop('disabled') !== true){
        //         if(fetchedOnce !== true){
        //             ev.preventDefault();
        //         }
        //     }
        // });
    }

});
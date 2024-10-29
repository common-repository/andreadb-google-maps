function addImage(id) {
    var dbaGoogleMapsFrame;
    // If the media frame already exists, reopen it.
    if (dbaGoogleMapsFrame) {
        dbaGoogleMapsFrame.open();
        return;
    }
    // Create the media frame.
    dbaGoogleMapsFrame = wp.media.frames.dbaGoogleMapsFrame = wp.media({
        state: 'insert',
        frame: 'post',
        multiple: false
    });
    // When an image is selected, run a callback.
    dbaGoogleMapsFrame.on('insert', function () {
        // Get media attachment details from the frame state
        var attachment = dbaGoogleMapsFrame.state().get('selection').first().toJSON();
        // Clear out the preview image
        jQuery('#andreadb-google-maps-icon-marker-' + id + ' img').remove();
        // Send the attachment URL to our custom image input field.
        jQuery('#andreadb-google-maps-icon-marker-' + id).append('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');
        // Send the attachment id to our hidden input
        jQuery('#andreadb-google-maps-icon-id-' + id).val(attachment.id);
        // Show remove button
        jQuery('#andreadb-remove-image-' + id).removeClass('hidden');
    });
    // Finally, open the modal.
    dbaGoogleMapsFrame.open();
}

function removeImage(id) {
    // Clear out the preview image
    jQuery('#andreadb-google-maps-icon-marker-' + id + ' img').remove();
    // Delete the image id from the hidden input
    jQuery('#andreadb-google-maps-icon-id-' + id).val('');
    // Hide remove button
    jQuery('#andreadb-remove-image-' + id).addClass('hidden');
}

function openPreview(id) {
    var url = andreadb_google_maps.iframeurl + '&andreadb_google_maps_id=' + id;
    jQuery('body').append('<div class="andreadb-overlay"><div class="andreadb-iframe-container"><div class="andreadb-iframe-content"><div class="title">Andreadb Google Maps ' + id + '</div><div class="close"><span class="dashicons dashicons-no" onclick="removePreview()"></span></div></div><iframe src="' + url + '"></iframe></div></div>');
}

function removePreview() {
    jQuery('.andreadb-overlay').remove();
}

(function ($) {
    'use strict';

    $(function () {

        // Add tab
        $('#andreadb-add-marker').on('click', function () {
            var element = ($('.andreadb-tabs li').length) - 1;
            var data = {
                action: 'add_dba_google_maps_marker_tab',
                element: element,
                _wpnonce: andreadb_google_maps.addmarker_nonce
            };
            $.post(andreadb_google_maps.ajaxurl, data, function (response) {
                $('.andreadb-tabs li:last-child').before(response);
            });
            var data = {
                action: 'add_dba_google_maps_marker_content',
                element: element,
                _wpnonce: andreadb_google_maps.addmarker_nonce
            };
            $.ajax({
                type: 'POST',
                url: andreadb_google_maps.ajaxurl,
                data: data,
                beforeSend: function () {
                    $('#andreadb-add-marker').prop('disabled', true);
                },
                success: function (response) {
                    $('.andreadb-tabs-content .tab-content:last-child').after(response);
                    quicktags({id: 'andreadb-google-maps-info-content-' + element, buttons: "strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,dfw"});
                    tinymce.execCommand('mceAddEditor', false, 'andreadb-google-maps-info-content-' + element);
                },
                error: function () {
                    alert('Error occured please try again.');
                },
                complete: function () {
                    $('#andreadb-add-marker').prop('disabled', false);
                }
            });
        });

        // Remove tab
        $('.andreadb-tabs-content').on('click', '#andreadb-remove-marker', function () {
            if (confirm(andreadb_google_maps.confirm)) {
                var tab = $(this).attr('data-remove');
                $('.andreadb-tabs #tabl-' + tab).remove();
                $('.andreadb-tabs-content #tab-' + tab).remove();
                $('.andreadb-tabs li:first-child').addClass('selected');
                $('.andreadb-tabs-content .tab-content:first-child').addClass('selected');
                dbaNumberMarker();
                return false;
            }
        });

        // Change Tab
        $('.andreadb-google-maps').on('click', '.andreadb-tabs li', function () {
            var tab_id = $(this).attr('data-tab');
            $('.andreadb-tabs li').removeClass('selected');
            $('.andreadb-tabs-content .tab-content').removeClass('selected');
            $(this).addClass('selected');
            $("#" + tab_id).addClass('selected');
        });

        // Update the number marker
        function dbaNumberMarker() {
            $('.andreadb-tabs .tab-link').each(function () {
                var index = $(this).index();
                $(this).attr('id', 'tabl-' + index);
                $(this).attr('data-tab', 'tab-' + index);
                $(this).find('.num').html(parseInt(index + 1));
            });
            $('.andreadb-tabs-content .tab-content').each(function () {
                var index = $(this).index();
                $(this).attr('id', 'tab-' + index);
                $('.andreadb-tabs-content #andreadb-remove-marker').attr('data-remove', index);
            });
        }

    });

})(jQuery);

jQuery(document).ready(function($) {
    var mediaUploader;

    $('#custom_theme_options_image_button').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#custom_theme_options\\[dummy_image\\]').val(attachment.url);
        });
        mediaUploader.open();
    });
});


function openTabs(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";

    localStorage.setItem('activeTab', tabName);

}
// Function to load the last active tab from localStorage
function loadLastActiveTab() {
    var lastTab = localStorage.getItem('activeTab');
    if (lastTab) {
        document.querySelector(`button[data-tab="${lastTab}"]`).click();
    } else {
        document.getElementById("defaultOpen").click();
    }
}

// Load the last active tab on page load
window.onload = loadLastActiveTab;

document.addEventListener('DOMContentLoaded', function() {

    // Media uploader for image field
    jQuery(document).ready(function($) {
        var mediaUploader;

        $('#custom_theme_options_image_button').click(function(e) {
            e.preventDefault();
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#custom_theme_options\\[image\\]').val(attachment.url);
            });
            mediaUploader.open();
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('social-media-container');
    const addButton = document.getElementById('add-social-media');
    
    addButton.addEventListener('click', function() {
        const index = container.children.length;
        const div = document.createElement('div');
        div.classList.add('social-media-item');
        div.innerHTML = `
            <input type="text" required name="custom_theme_options[social_media][${index}][name]" placeholder="Name" required/>
            <input type="url" name="custom_theme_options[social_media][${index}][url]" placeholder="URL" />
            <input type="text" required name="custom_theme_options[social_media][${index}][icon]" placeholder="Icon Class" />
            <button type="button" class="remove-social-media button button-secondary">Remove</button>
        `;
        container.appendChild(div);
    });

    container.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-social-media')) {
            event.target.parentElement.remove();
        }
    });
});

function image_null(){
    jQuery(".image_display").hide();
    jQuery(".image_value_null").val('');
}


/* jQuery(document).ready(function($) {
    $('.nav-tab').click(function(e) {
        // e.preventDefault();
        $('.nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        var tab = $(this).attr('href');
        $('.settings-tab').hide();
        $(tab).show();
    });
    $('.nav-tab-active').trigger('click');
}); */

/* document.addEventListener('DOMContentLoaded', function() {
    var tabWrappers = document.querySelectorAll('#custom-theme-options-form .nav-tab-wrapper');
    
    tabWrappers.forEach(function(wrapper) {
        var tabs = wrapper.querySelectorAll('.nav-tab');
        var tabContents = document.querySelectorAll('.settings-tab');

        if (tabs.length > 0 && tabContents.length > 0) {
            tabs[0].classList.add('nav-tab-active');
            document.querySelector(tabs[0].getAttribute('href')).style.display = 'block';
        }
        
        tabs.forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                event.preventDefault();
                
                tabs.forEach(function(t) { t.classList.remove('nav-tab-active'); console.log(t); });
                tabContents.forEach(function(content) { content.style.display = 'none'; });
                
                tab.classList.add('nav-tab-active');
                document.querySelector(tab.getAttribute('href')).style.display = 'block';
            });
        });
    });
}); */

document.addEventListener('DOMContentLoaded', function () {
    function setupTabs(tabWrapper) {
        const tabs = tabWrapper.querySelectorAll('.nav-tab');
        const tabContents = tabWrapper.querySelectorAll('.settings-tab');

        tabs.forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                
                tabs.forEach(t => {
                    t.classList.remove('nav-tab-active');
                    const contentId = t.getAttribute('href').substring(1);
                    const content = document.getElementById(contentId);
                    if (content) {
                        content.style.display = 'none';
                    }
                });
                
                tab.classList.add('nav-tab-active');

                const activeTabContent = document.querySelector(tab.getAttribute('href'));
                if (activeTabContent) { activeTabContent.style.display = 'block'; }
            });
        });

        const activeTab = tabWrapper.querySelector('.nav-tab-active');
        if (activeTab) {
            activeTab.click();
        } else if (tabs.length > 0) {
            tabs[0].click();
        }
    }

    const tabWrappers = document.querySelectorAll('#custom-theme-options-form .nav-tab-wrapper');
    tabWrappers.forEach(wrapper => setupTabs(wrapper));
});


(function($) {
    $(document).ready(function() {
        $('#image-preview').on('click', '.delete-image', function() {
            var $this = $(this);
            var imageUrl = $this.data('url');
            var $hiddenInput = $('#custom_theme_options\\[banner_slider_images\\]');
            
            var imageUrls = $hiddenInput.val().split(',');
            imageUrls = imageUrls.filter(function(url) {
                return url !== imageUrl;
            });
            $hiddenInput.val(imageUrls.join(','));
            
            $this.closest('.image-item').remove();
        });
    });
})(jQuery);

function initializeFeatureTable(tableId, addButtonId, featureItemClass, imageUrlClass, imagePreviewClass, removeFeatureButtonClass, fieldName) {
    document.addEventListener('DOMContentLoaded', function () {
        let index = document.querySelectorAll(`${tableId} tbody ${featureItemClass}`).length;

        document.getElementById(addButtonId).addEventListener('click', function () {
            let tableBody = document.querySelector(`${tableId} tbody`);
            let newRow = document.createElement('tr');
            newRow.classList.add(featureItemClass.slice(1)); // Remove dot for class name
            newRow.innerHTML = `
                <td>
                    <input type="hidden" name="custom_theme_options[${fieldName}][${index}][image]" class="${imageUrlClass.slice(1)}" />
                    <img src="" alt="Image" class="${imagePreviewClass.slice(1)}" style="max-width: 100px;" />
                    <button type="button" class="button button-primary upload-image-button">Upload Image</button>
                    <button type="button" class="button button-secondary remove-image-button">Remove Image</button>
                </td>
                <td>
                    <input type="text" name="custom_theme_options[${fieldName}][${index}][title]" required/>
                </td>
                <td>
                    <textarea name="custom_theme_options[${fieldName}][${index}][description]" rows="3" cols="30"></textarea>
                </td>
                <td>
                    <button type="button" class="button button-primary ${removeFeatureButtonClass}">Remove</button>
                </td>
            `;
            tableBody.appendChild(newRow);
            index++;
        });

        document.querySelector(tableId).addEventListener('click', function (e) {
            if (e.target.classList.contains(removeFeatureButtonClass)) {
                e.target.closest('tr').remove();
            }

            if (e.target.classList.contains('upload-image-button')) {
                e.preventDefault();
                let button = e.target;
                let imageUrlField = button.previousElementSibling.previousElementSibling;
                let imagePreview = button.previousElementSibling;

                let customUploader = wp.media({
                    title: 'Select Image',
                    button: { text: 'Use this image' },
                    multiple: false
                })
                .on('select', function () {
                    let attachment = customUploader.state().get('selection').first().toJSON();
                    imageUrlField.value = attachment.url;
                    imagePreview.src = attachment.url;
                })
                .open();
            }

            if (e.target.classList.contains('remove-image-button')) {
                let imageUrlField = e.target.previousElementSibling.previousElementSibling.previousElementSibling;
                let imagePreview = e.target.previousElementSibling.previousElementSibling;
                imageUrlField.value = '';
                imagePreview.src = '';
            }
        });
    });
}

// initializeFeatureTable(
//     '#choose-us-features-table',
//     'add-choose-us-feature-item',
//     '.choose-us-feature-item',
//     '.image-url',
//     '.image-preview',
//     'remove-choose-us-feature-item',
//     'choose_us_features'
// );

initializeFeatureTable(
    '#our-clients-features-table',
    'add-client-feature-item',
    '.our-client-feature-item',
    '.image-url',
    '.image-preview',
    'remove-client-feature-item',
    'our_clients_features'
);


function initializeImageUploader(uploadButtonClass, hiddenInputSelector, previewContainerSelector, previewImageClass, deleteButtonClass = 'delete-image') {
    jQuery(document).ready(function($) {
        $(uploadButtonClass).click(function(e) {
            e.preventDefault();
            
            var frame = wp.media({
                title: 'Select Images',
                button: {
                    text: 'Use these images'
                },
                multiple: true
            });

            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var imageUrls = [];
                var previewHtml = '';

                selection.each(function(attachment) {
                    if (attachment.attributes.url) {
                        imageUrls.push(attachment.attributes.url);
                        previewHtml += '<div class="' + previewImageClass + '" style="display: inline-block; position: relative; margin: 5px;">' +
                            '<img src="' + attachment.attributes.url + '" style="max-width: 150px;" />' +
                            '<button type="button button-secondary" class="' + deleteButtonClass + '" data-url="' + attachment.attributes.url + '" style="position: absolute; top: 0; right: 0; background: red; color: white; border: none;">X</button>' +
                            '</div>';
                    }
                });

                $(hiddenInputSelector).val(imageUrls.join(','));
                $(previewContainerSelector).html(previewHtml);
            });

            frame.open();
        });

        $(previewContainerSelector).on('click', '.' + deleteButtonClass, function() {
            var $this = $(this);
            var imageUrl = $this.data('url');
            var $hiddenInput = $(hiddenInputSelector);
            
            var imageUrls = $hiddenInput.val().split(',');
            imageUrls = imageUrls.filter(function(url) {
                return url !== imageUrl;
            });
            $hiddenInput.val(imageUrls.join(','));
            
            $this.closest('.' + previewImageClass).remove();
        });
    });
}
initializeImageUploader(
    '.upload-images',                    // Class for the upload button
    'input[name="custom_theme_options[banner_slider_images]"]',  // Selector for the hidden input
    '#image-preview',                     // Selector for the preview container
    'image-item',
    'delete-banner-image',
);

initializeImageUploader(
    '.upload-choose-us-images',            // Class for a different upload button
    'input[name="custom_theme_options[choose_us_slider]"]',  // Selector for another hidden input
    '#choose-us-image-preview',                   // Selector for a different preview container
    'image-item',
    'delete-choose_us-image',
);
initializeImageUploader(
    '.upload-mission-images',            // Class for a different upload button
    'input[name="custom_theme_options[about_mission_slider]"]',  // Selector for another hidden input
    '#mission-image-preview',                   // Selector for a different preview container
    'image-item',
    'delete-mission-image',
);

jQuery(document).ready(function($) {
    var image_frame;

    function handleImageField(fieldContainer) {
        var $fieldContainer = $(fieldContainer);
        var $imageFieldUrl = $fieldContainer.find('.image-field-url');
        var $imagePreview = $fieldContainer.find('.image-preview');
        var $uploadButton = $fieldContainer.find('.upload-image-button');
        var $removeButton = $fieldContainer.find('.remove-image-button');

        $uploadButton.on('click', function(e) {
            e.preventDefault();

            if (image_frame) {
                image_frame.open();
                return;
            }

            image_frame = wp.media({
                title: 'Select or Upload an Image',
                button: { text: 'Use this image' },
                multiple: false
            });

            image_frame.on('select', function() {
                var attachment = image_frame.state().get('selection').first().toJSON();
                $imageFieldUrl.val(attachment.url);
                $imagePreview.attr('src', attachment.url).show();
                $removeButton.show();
            });

            image_frame.open();
        });

        $removeButton.on('click', function(e) {
            e.preventDefault();
            $imageFieldUrl.val('');
            $imagePreview.attr('src', '').hide();
            $(this).hide();
        });
    }

    // Apply the handler to all image field containers
    $('.image-field-container').each(function() {
        handleImageField(this);
    });
});
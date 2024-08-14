jQuery(document).ready(function($) {
    $('#add-school-features').on('click', function(e) {
        e.preventDefault();
        var featureItem = `
            <div class="school-feature-item" style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;">
                <p><label style="font-weight: bold;">Title:</label>
                <input type="text" name="school_features_title[]" value="" style="width: 100%;  margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;" required=""/></p>
                <p><label style="font-weight: bold;">Description:</label>
                <textarea name="school_features_description[]" style="width: 100%;  margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;"></textarea></p>
                <button type="button" class="remove-feature" style="background-color: #e74c3c; color: #fff; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer;">Remove</button>
            </div>`;
        $('#school-features-wrapper').append(featureItem);
    });

    $(document).on('click', '.remove-feature', function(e) {
        e.preventDefault();
        $(this).closest('.school-feature-item').remove();
    });
});

jQuery(document).ready(function($) {
    $('#add-excursions-features').on('click', function(e) {
        e.preventDefault();
        var featureItem = `
            <div class="excursions-feature-item" style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;">
                <p><label style="font-weight: bold;">Description:</label>
                <textarea name="excursions_features_description[]" style="width: 100%;  margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;" required></textarea></p>
                <button type="button" class="remove-feature" style="background-color: #e74c3c; color: #fff; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer;">Remove</button>
            </div>`;
        $('#excursions-features-wrapper').append(featureItem);
    });

    $(document).on('click', '.remove-feature', function(e) {
        e.preventDefault();
        $(this).closest('.excursions-feature-item').remove();
    });
});


/* jQuery(document).ready(function($) {
    $('#add-wrap-button').on('click', function() {
        var index = $('#wraps-container .wrap').length;
        $('#wraps-container').append(`
            <div class="wrap" data-index="${index}">
                <input type="text" name="wraps[${index}][title]" placeholder="Wrap Title" />
                <button type="button" class="remove-wrap-button">Remove Wrap</button>
                <div class="titles-container"></div>
                <button type="button" class="add-title-button">Add Title</button>
            </div>
        `);
    });

    $(document).on('click', '.remove-wrap-button', function() {
        $(this).closest('.wrap').remove();
    });

    $(document).on('click', '.add-title-button', function() {
        var wrap = $(this).closest('.wrap');
        var index = wrap.data('index');
        var titleIndex = wrap.find('.title').length;
        wrap.find('.titles-container').append(`
            <div class="title" data-index="${titleIndex}">
                <input type="text" name="wraps[${index}][titles][${titleIndex}]" placeholder="Title" />
                <button type="button" class="remove-title-button">Remove Title</button>
            </div>
        `);
    });

    $(document).on('click', '.remove-title-button', function() {
        $(this).closest('.title').remove();
    });
}); */

jQuery(document).ready(function($) {
    function initializeDynamicFields(containerId, wrapClass, titleClass, addWrapBtnId, addTitleBtnClass, removeWrapBtnClass, removeTitleBtnClass) {
        // Add new wrap
        $(document).on('click', addWrapBtnId, function() {
            var index = $(containerId + ' .' + wrapClass).length;
            $(containerId).append(`
                <div class="${wrapClass}" data-index="${index}"  style="margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;">
                    <button type="button" class="${removeWrapBtnClass}" style="background-color: #d9534f; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-bottom: 10px;">Remove Wrap</button>
                    <input type="text" name="${containerId.replace(/[#\-]/g, '').replace('container', '')}[${index}][title]" placeholder="Wrap Title" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"/>
                    <button type="button" class="${addTitleBtnClass}" style="background-color: #5bc0de; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-top: 10px;">Add Title</button>
                    <div class="titles-container"></div>
                </div>
            `);
        });

        // Remove wrap
        $(document).on('click', '.' + removeWrapBtnClass, function() {
            $(this).closest('.' + wrapClass).remove();
        });

        // Add title inside a wrap
        $(document).on('click', '.' + addTitleBtnClass, function() {
            var wrap = $(this).closest('.' + wrapClass);
            var index = wrap.data('index');
            var titleIndex = wrap.find('.' + titleClass).length;
            wrap.find('.titles-container').append(`
                <div class="${titleClass}" data-index="${titleIndex}" style="margin-bottom: 10px;">
                    <input type="text" name="${containerId.replace('#', '').replace('-container', '')}[${index}][titles][${titleIndex}]" placeholder="Title" style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required/>
                    <button type="button" class="${removeTitleBtnClass}" style="background-color: #d9534f; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-left: 10px;">Remove Title</button>
                </div>
            `);
        });

        // Remove title
        $(document).on('click', '.' + removeTitleBtnClass, function() {
            console.log($(this).closest('.' + titleClass));
            
            $(this).closest('.' + titleClass).remove();
        });
    }

    initializeDynamicFields(
        '#whats_included-container',       // Container ID
        'wrap-whats_included',                             // Wrap class
        'title-whats_included',                            // Title class
        '#add-wrap-whats_included',        // Add wrap button ID
        'add-whats_included-title',        // Add title button class
        'remove-whats_included-wrap',      // Remove wrap button class
        'remove-whats_included-title'      // Remove title button class
    );
    initializeDynamicFields(
        '#optional_addons-container',       // Container ID
        'wrap-optional_addons',                             // Wrap class
        'title-optional_addons',                            // Title class
        '#add-wrap-optional_addons',        // Add wrap button ID
        'add-optional_addons-title',        // Add title button class
        'remove-optional_addons-wrap',      // Remove wrap button class
        'remove-optional_addons-title'      // Remove title button class
    );
    initializeDynamicFields(
        '#course_highlights-container',       // Container ID
        'wrap-course_highlights',                             // Wrap class
        'title-course_highlights',                            // Title class
        '#add-wrap-course_highlights',        // Add wrap button ID
        'add-course_highlights-title',        // Add title button class
        'remove-course_highlights-wrap',      // Remove wrap button class
        'remove-course_highlights-title'      // Remove title button class
    );
});
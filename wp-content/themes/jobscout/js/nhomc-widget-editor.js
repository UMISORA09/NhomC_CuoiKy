jQuery(function ($) {
    $(document).on('click', '.nc-widget-image-select', function () {
        const field = $(this).closest('.nc-widget-field');
        const frame = wp.media({ title: 'Chọn hình ảnh cho tiện ích', button: { text: 'Dùng hình ảnh này' }, library: { type: 'image' }, multiple: false });
        frame.on('select', function () {
            const selected = frame.state().get('selection').first().toJSON();
            field.find('input').val(selected.url).trigger('change');
            field.find('.nc-widget-image-preview').attr('src', selected.url).prop('hidden', false);
        });
        frame.open();
    });
    $(document).on('click', '.nc-widget-image-remove', function () {
        const field = $(this).closest('.nc-widget-field');
        field.find('input').val('').trigger('change');
        field.find('.nc-widget-image-preview').removeAttr('src').prop('hidden', true);
    });
    $(document).on('change', '.nc-widget-field input', function () {
        const value = this.value;
        $(this).closest('.nc-widget-field').find('.nc-widget-image-preview').attr('src', value || null).prop('hidden', !value);
    });
});

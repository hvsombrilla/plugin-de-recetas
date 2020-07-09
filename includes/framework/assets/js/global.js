var TypeRocket = {
    httpCallbacks: [],
    repeaterCallbacks: [],
    lastSubmittedForm: !1,
    redactorSettings: {}
};
if (typeof jQuery === 'function') {
    jQuery(document).ready(function($) {
        if ($('.code_editor').length) {
            wp.codeEditor.initialize($('.code_editor'));
        }
        if (typeof jQuery('.tr-repeater-fields').sortable === 'function') {
            jQuery('.tr-repeater-fields').sortable();
        }
    });
}
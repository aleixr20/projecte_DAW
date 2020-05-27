/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function(config) {
    // Define changes to default configuration here. For example:
    config.language = 'es';
    config.uiColor = '#cccccc';
    config.toolbar = [
        { name: 'tools', items: ['Maximize', 'ShowBlocks', 'CreateDiv', 'Source'] },
        { name: 'document', items: ['Preview', 'Print'] },
        { name: 'clipboard', items: ['SelectAll', 'PasteText'] },
        { name: 'editing', items: ['Find', 'Replace'] },
        { name: 'insert', items: ['Link', 'Unlink', 'Image', 'HorizontalRule', 'PageBreak', 'Iframe'] },
        '/',
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'Blockquote', 'TextColor', 'BGColor', '-', 'RemoveFormat'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'BidiLtr', 'BidiRtl', 'Language', 'CodeSnippet'] },
    ];
    // config.toolbarCanCollapse = true;
    config.extraPlugins = 'codesnippet';
    // config.codeSnippet_theme = 'monokai_sublime';
    config.codeSnippet_theme = 'rainbow';
    // config.codeSnippet_theme = 'darcula';

    config.codeSnippet_languages = {
        javascript: 'JavaScript',
        php: 'PHP',
        css: 'CSS',
        html: 'HTML',
        apache: 'Apache',
        nginx: 'Nginx'
    };
};
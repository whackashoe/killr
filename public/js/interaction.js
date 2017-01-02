/*
 * TODO
 * only recreate linenumbers when we paste,enter newline, or mass delete
 * use timeout to delay running hljs until we haven't typed for a moment
 * create diff page:
 *  killr.io/asdaa/diff/lkjww
 * when modifying existing paste highlight (in linenumbers) modified rows
 * add total_mods column to db, we need to traverse upwards along tree and increment count when mod is added
 * add killr.io/asdaa/demo -- view raw as actual html
*/
var getCaretCoordinates = require('textarea-caret-position');

String.prototype.replaceAll = function(target, replacement) {
    return this.split(target).join(replacement);
};

String.prototype.endsWith = function(suffix) {
    return this.indexOf(suffix, this.length - suffix.length) !== -1;
};

$(document).ready(function() {
    hljs.initHighlightingOnLoad();

    //update caret
    if($("#editor").length > 0) {
        document.querySelector('#editor').addEventListener('input', function() { update_caret(this); });
        document.querySelector('#editor').addEventListener('propertychange', function() { update_caret(this); });
        document.querySelector('#editor').addEventListener('click', function() { update_caret(this); });
        document.querySelector('#editor').addEventListener('keydown', function() { update_caret(this); });
        document.querySelector('#editor').addEventListener('keyup', function() { update_caret(this); });
    }

    //catch tabs
    $("body").on('keydown', '#editor', function(e) {
        var keyCode = e.keyCode || e.which;
        if(keyCode == 9) {
            e.preventDefault();
            $('#editor').caret('    ');
        }
    });

    $("#editor").bind('input propertychange', function() {
        $("#editor").val($("#editor").val().replaceAll('\t', '    '));
        var decoded = $("#editor").val();

        $('#content pre code').text(decoded);

        $("#content code").each(function(i, block) {
            hljs.initHighlighting.called = false;
            hljs.highlightBlock(block);
        });
        $('#content, #content pre, #content code, #editor, #linenumbers').css('height', $('#editor')[0].scrollHeight);
        $('#content, #console pre, #content code, #editor').css('width', $('#editor')[0].scrollWidth);


        $("#linenumbers").height($("#linenumbers table").height());
    }).trigger('propertychange');

});

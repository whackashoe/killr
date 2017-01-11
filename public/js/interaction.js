/*
 * TODO
 * only recreate linenumbers when we paste,enter newline, or mass delete
 * use timeout to delay running hljs until we haven't typed for a moment
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

function redraw() {
    $("#editor").val($("#editor").val().replaceAll('\t', '    '));
    var decoded = $("#editor").val();

    $('#content pre code').text(decoded);

    $("#content code").each(function(i, block) {
        hljs.initHighlighting.called = false;
        hljs.highlightBlock(block);
    });
    $('#content, #content pre, #content code, #editor, #linenumbers').height($('#linenumbers table').height() + 30);
    $('#content, #console pre, #content code').css('width', $('#editor')[0].scrollWidth);
    $('#editor').css('width', $('#editor')[0].scrollWidth);
}

$(document).ready(function() {
    hljs.initHighlightingOnLoad();

    function update_caret(el)
    {
        var coordinates = getCaretCoordinates(el, el.selectionEnd);
        var content_offset = $("#content").offset();

        $("#caret").css({
            left: content_offset.left + coordinates.left,
            top:  content_offset.top + coordinates.top
        });
    }

    //update caret
    if($("#editor").length > 0) {
        document.querySelector('#editor').addEventListener('input', function() { update_caret(this); });
        document.querySelector('#editor').addEventListener('propertychange', function() { update_caret(this); });
        document.querySelector('#editor').addEventListener('click', function() { update_caret(this); });
        document.querySelector('#editor').addEventListener('keydown', function() { update_caret(this); });
        document.querySelector('#editor').addEventListener('keyup', function() { update_caret(this); });
    }

    $("body").on('keydown', '#editor', function(e) {
        var keyCode = e.keyCode || e.which;
        // catch tab
        if(keyCode == 9) {
            e.preventDefault();
            redraw();
            $('#editor').caret('    ');
        }

        // catch home key
        if(keyCode == 36) {
            $('body').scrollLeft(0);
        }
    });

    $("#editor").bind('input propertychange', function() {
        redraw();
    }).trigger('propertychange');
});

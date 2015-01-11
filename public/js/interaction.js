var getCaretCoordinates = require('textarea-caret-position');

$(document).ready(function() {
    hljs.initHighlightingOnLoad();
    var cols_per_line = [];

    //update caret
    document.querySelector('#editor').addEventListener('input', function() { update_caret(this); });
    document.querySelector('#editor').addEventListener('propertychange', function() { update_caret(this); });
    document.querySelector('#editor').addEventListener('click', function() { update_caret(this); });

    //catch tabs
    $("body").on('keydown', '#editor', function(e) {
        var keyCode = e.keyCode || e.which;
        if(keyCode == 9) {
            e.preventDefault();
            $('#editor').caret('    ');
        }
    });

    $("#editor").bind('input propertychange', function() {
        var decoded = $("#editor").val();

        $('#content pre code').text(decoded);

        $("#content code").each(function(i, block) {
            hljs.initHighlighting.called = false;
            hljs.initHighlighting();
        });
        $('#content, #content pre, #content code, #editor, #linenumbers').css('height', $('#editor')[0].scrollHeight + 500);
        $('#content, #console pre, #content code, #editor').css('width', $('#editor')[0].scrollWidth + 20);

        cols_per_line = [];
        $('#linenumbers').html('<table>'+$.map(decoded.split('\n'), function(t, i) {
            cols_per_line.push(t.length);
            return '<tr><td>'+(i+1)+'</td></tr>';
        }).join('')+'</table>');
    }).trigger('propertychange');

    $("#save").click(function() {
        $.post('/', {code: $('#editor').val(), parent_id: $("#parent_id").val()}, function(result) {
            if(result.success) {
                $("#success-modal").html('<a href="/' + result.slug + '">killr.io/' + result.slug + '</a>');
                $("#overlay").show();
                $("#success-modal").show();
            }
        });
    });

    $("#delete").click(function() {
        $.post(document.URL, function(result) {
            console.log(result);
            if(result.success) {
                $("#success-modal").html('<a href="/">deleted</a>');
                $("#overlay").show();
                $("#success-modal").show();
            }
        });
    });

    function update_caret(el)
    {
        var coordinates = getCaretCoordinates(el, el.selectionEnd);
        var content_offset = $("#content").offset();

        $("#caret").css({
            left: content_offset.left + coordinates.left,
            top:  content_offset.top + coordinates.top
        });
    }
});

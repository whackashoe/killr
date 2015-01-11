$(document).ready(function() {
    hljs.initHighlightingOnLoad();

    $("#editor").bind('input propertychange', function() {
        var decoded = $("#editor").val();

        $('#content pre code').text(decoded);

        $("#content code").each(function(i, block) {
            hljs.initHighlighting.called = false;
            hljs.initHighlighting();
        });
        $('#content, #content pre, #content code, #editor, #linenumbers').css('height', $('#editor')[0].scrollHeight + 500);
        $('#content, #console pre, #content code, #editor').css('width', $('#editor')[0].scrollWidth + 20);

        var cols_per_line = [];
        $('#linenumbers').html('<table>'+$.map(decoded.split('\n'), function(t, i) {
            cols_per_line.push(t.length);
            return '<tr><td>'+(i+1)+'</td></tr>';
        }).join('')+'</table>');

        console.log(cols_per_line);
    }).trigger('propertychange');

    $("#save").click(function() {
        $.post('/', {code: $('#editor').val()}, function(result) {
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
});

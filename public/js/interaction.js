$(document).ready(function() {
    hljs.initHighlightingOnLoad();
    var cols_per_line = [];

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

        update_caret();
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

    function update_caret()
    {
        var caret_row = 0;
        var caret_col = 0;
        var caret_tmp = $('#editor').caret();

        for(var i=0; i<cols_per_line.length; ++i) {
            if(cols_per_line[i] < caret_tmp) {
                caret_tmp -= cols_per_line[i] + 1;
                ++caret_row;
            } else break;
        }
        caret_col = caret_tmp;

        var ln_offset = $("#linenumbers tr:eq(" + (caret_row) + ")").offset();
        var content_offset = $("#content").offset();
        
        $("#caret").css({
            left: (14 / 2) + content_offset.left + (caret_col * 14) + "px",
            top: (14 / 2) + ln_offset.top + "px"
        });

    }
});

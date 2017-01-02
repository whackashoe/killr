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
    var cols_per_line = [];

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

        cols_per_line = [];
        $('#linenumbers').html('<table>'+$.map(decoded.split('\n'), function(t, i) {
            cols_per_line.push(t.length);
            return '<tr><td>'+(i+1)+'</td></tr>';
        }).join('')+'</table>');

        $("#linenumbers").height($("#linenumbers table").height());
    }).trigger('propertychange');

    $("#save").click(function() {
        var url = document.URL + (document.URL.endsWith('/') ? '' : '/') + 'create';
        $.post(url, {code: $('#editor').val(), parent_id: $("#parent_id").val()}, function(result) {
            console.log(result);
            if(result.success) {
                $("#success-modal").html('<a href="/' + result.slug + '">killr.io/' + result.slug + '</a>');
                $("#overlay").show();
                $("#success-modal").show();
            } else {
                var error_html = '<li>' + result.errors.code + '</li>';

                $("#error-modal").html('<ul>' + error_html + '</ul>');
                console.log(error_html);
                $("#overlay").show();
                $("#error-modal").show();
            }
        });
    });

    $("#delete").click(function() {
        var url = document.URL + (document.URL.endsWith('/') ? '' : '/') + 'delete';
        $.post(url, function(result) {
            console.log(result);
            if(result.success) {
                $("#success-modal").html('<a href="/">deleted</a>');
                $("#overlay").show();
                $("#success-modal").show();
            }
        });
    });

    $("#error-modal").click(function() {
        $("#overlay").hide();
        $("#error-modal").hide();
        $("#editor").focus();
    });

    function expand_mods(el)
    {
        el.hide();
        var parent = el.parent();
        var m_slug = el.data('slug');
        console.log(parent);
        parent.append($("<ul/>"));

        $.getJSON("/" + m_slug + "/mods.json", function(results) {
            $.each(results, function(i, v) {
                var html = '<li><a href="/' + v.slug + '">' + v.created_at + ' (' + v.mods.length + ' mods)</a>';
                if(v.mods.length > 0) {
                    html += '<button class="expand-mods" data-slug="' + v.slug + '">+</button></li>';
                }
                var nli = $(html);
                nli.click(function() { expand_mods(nli.find("button")); });
                parent.find("ul").append(nli);
            });
            console.log(results);
        });
    }

    $(".expand-mods").click(function() { expand_mods($(this)); });

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

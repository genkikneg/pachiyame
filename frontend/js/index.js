$(function() {
    $('#form').submit(function() {
        var textItem = $('#story').val();
        $('#output-text').text(textItem);
        return false;
    });
});

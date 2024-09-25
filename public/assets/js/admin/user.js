function changePage(url) {
    window.location.href = url;
}

$(document).ready(function() {
    $('#searchInput').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#searchForm').submit();
        }
    });
});
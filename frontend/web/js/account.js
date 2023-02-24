$(".edit-user").submit(function (event) {
    event.preventDefault();
    let data = $(this).serialize();
    event.stopImmediatePropagation();

    postData(data, '/site/edit-user');
    location.reload();
});

$(".change-password").submit(function (event) {
    event.preventDefault();
    let data = $(this).serialize();
    event.stopImmediatePropagation();

    postData(data, '/site/change-password');
    location.reload();
});

function postData(data, url) {
    $.ajax({
        url,
        type: 'POST',
        data: data,
        success: function (res) {
            return res.code === 'success';
        },
        error: function () {
            return false;
        }
    });
    return false;
}
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
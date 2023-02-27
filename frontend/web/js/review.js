$(".add-review").submit(function (event) {
    event.preventDefault();
    let data = $(this).serialize();
    event.stopImmediatePropagation();

    postData(data, '/reviews/create');
    location.reload();
});

$(".remove-review").click(function (event) {
    event.preventDefault();
    let data = {
        'reviewId': $(this).data('review')
    };
    postData(data, '/reviews/remove');
    location.reload();
});

$(".edit-review").submit(function (event) {
    event.preventDefault();
    let data = $(this).serialize();
    event.stopImmediatePropagation();

    postData(data, '/reviews/change');
    location.reload();
});
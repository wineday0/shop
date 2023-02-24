$(".add-product").submit(function (event) {
    event.preventDefault();
    let data = $(this).serialize();
    event.stopImmediatePropagation();

    postData(data, '/shop/append');
});

$(".cart-add").click(function (event) {
    event.preventDefault();
    let data = {'productId': $(this).data('product'), 'userId': $(this).data('user')};
    postData(data, '/shop/append');
});

$(".cart-remove").click(function (event) {
    event.preventDefault();
    let data = {'productId': $(this).data('product'), 'userId': $(this).data('user')};
    postData(data, '/shop/remove');
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
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


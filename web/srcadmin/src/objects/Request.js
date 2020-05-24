

export default {
    app: null,
    get(url, data, success, fail) {
        $.ajax({
            method: 'GET',
            url: url,
            data: data
        }).done((response) => {
            success(response);
        }).fail((response) => {
            fail(response);
        });
    },
    post(url, data, success, fail) {
        $.ajax({
            method: 'POST',
            url: url,
            data: data
        }).done((response) => {
            success(response);
            if (response.error && response.error.length) {
                alert(response.error.join(','));
            }
        }).fail((response) => {
            if (fail) {
                fail(response);
            } else {
                alert('Ошибка сервера');
            }
        });
    },
    file(url, formData, success, fail) {
        $.ajax({
            type: "POST",
            url: url,
            success: (response) => {
                success(response);
                if (response.error && response.error.length) {
                    alert(response.error.join(','));
                }
            },
            error: (response) => {
                fail(response);
                alert('Ошибка загрузки файла');
            },
            async: true,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 60000
        });
    }
};


export default {
    app: null,
    get(url, data, success, fail) {
        this.app.startProgress();
        $.ajax({
            method: 'GET',
            url: url,
            data: data
        }).done((response) => {
            success(response);
            this.app.stopProgress();
        }).fail((response) => {
            fail(response);
            this.app.stopProgress();
        });
    },
    post(url, data, success, fail) {
        this.app.startProgress();
        $.ajax({
            method: 'POST',
            url: url,
            data: data
        }).done((response) => {
            success(response);
            if (response.error && response.error.length) {
                this.app.alert(response.error.join(','));
            }
            this.app.stopProgress();
        }).fail((response) => {
            if (fail) {
                fail(response);
            } else {
                this.app.alert('Ошибка сервера');
            }
            this.app.stopProgress();
        });
    },
    file(url, formData, success, fail) {
        this.app.startProgress();

        $.ajax({
            type: "POST",
            url: url,
            success: (response) => {
                success(response);
                if (response.error && response.error.length) {
                    this.app.alert(response.error.join(','));
                }
                this.app.stopProgress();
            },
            error: (response) => {
                fail(response);
                this.app.alert('Ошибка загрузки файла');
                this.app.stopProgress();
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

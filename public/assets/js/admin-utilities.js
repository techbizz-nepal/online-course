/************************ Utilities functions  **********************/
const setInputFieldValue = (value, inputEl) => {
    inputEl.setAttribute('value', value)
}
const prepareRequestFormData = (field, fileObject, fileName) => {
    const formData = new FormData();
    formData.append(field, fileObject);
    formData.append('name', fileName)
    return formData
}
const postRequestToServer = (path, csrfToken, body, progressEl, textInputEl) => {
    const xhr = new XMLHttpRequest()
    xhr.open('post', path, true)
    xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken)
    xhr.upload.onprogress = (e) => {
        if (e.lengthComputable) {
            const percentComplete = (e.loaded / e.total) * 100;
            progressEl.setAttribute('aria-valuenow', `${Math.round(percentComplete)}%`)
            progressEl.setAttribute('style', `width: ${Math.round(percentComplete)}%;`)
            progressEl.innerHTML = `${Math.round(percentComplete)}%`
        }
    };
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            const response = JSON.parse(xhr.response)
            setInputFieldValue(response.fileName, textInputEl)
        } else {
            console.error('Error uploading file:', xhr.statusText);
        }
    };
    xhr.onerror = function () {
        console.error('Network error occurred');
    };

    xhr.send(body);
}

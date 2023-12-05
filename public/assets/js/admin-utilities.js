/************************ Utilities functions  **********************/
function uuidv4() {
    return "10000000-1000-4000-8000-100000000000".replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
    );
}

/***************** assessment and module part **********************/
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
/************************** closed question part *************************************/
const choose = document.querySelectorAll("input[name=choose]")
const answer = document.querySelector("input[name=answer]")

choose.forEach((value) => {
    // initialize isCorrect value
    if (value.checked) {
        answer.value = value.id
    }
    // change answer value after triggering event
    value.addEventListener('change', (event) => {
        event.preventDefault()
        answer.value = event.currentTarget.id
    })
})


/************************** dynamic question add ********************************************/
const appendInputBox = (element) => {
    const clone = element.nextElementSibling.cloneNode(true)
    const childrenCount = element.parentNode.childElementCount
    clone.id = `row-${childrenCount}`
    clone.querySelector('#questions1').placeholder = `Write question ${childrenCount}`
    clone.querySelector('#questions1').value = ''
    clone.querySelector('#questions1').name = `questions[${childrenCount - 1}][body]`
    clone.querySelector('#id1').name = `questions[${childrenCount - 1}][id]`
    clone.querySelector('#id1').value = uuidv4()
    element.parentNode.appendChild(clone)
    return true
}
const removeInputBox = (element) => {
    element.parentNode.remove()
}


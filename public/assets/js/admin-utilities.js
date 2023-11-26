/************************ Utilities functions  **********************/

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


/************************** read and answer part ********************************************/


const getPageId = (id) => {
    return id ?? "readAndAnswerQuestionCreate"
}
const removeSessionKey = (id) => {
    if (id === 'readAndAnswerQuestionCreate') {
        let number = sessionStorage.getItem(id)
        number = parseInt(number) - 1
        setSessionItem(id, number)
    }
}

const deleteRow = (el, id = 'readAndAnswerQuestionCreate', numberCount) => {
    removeSessionKey(id)
    const deletionRow = document.getElementById(`row-${numberCount}`)
    deletionRow.remove()
}

const setSessionItem = (key, value) => {
    sessionStorage.setItem(key, value)
}
const getSessionItem = (key) => {
    return sessionStorage.getItem(key)
}
const appendInputBox = (questionCount, addBtnEl) => {
    addBtnEl.parentNode.appendChild(wrapperDivEl(questionCount))
}
const incrementInputBox = (pageId, questionCount, addBtnEl) => {
    setSessionItem(pageId, questionCount)
    appendInputBox(questionCount, addBtnEl)
}
const populateExistingInputBox = (questionCount, node) => {
    if (questionCount) {
        for (let i = 1; i <= questionCount; i++) {
            if (questionCount > 5) {
                return false
            }
            appendInputBox(i, node)
        }
    }
}

const wrapperDivEl = (numberCount) => {
    const el = document.createElement("div")
    el.setAttribute("class", `form-group row`)
    el.setAttribute("id", `row-${numberCount}`)
    el.appendChild(colDivWithInputEl(numberCount))
    el.appendChild(colDivWithDelBtnEl(numberCount))
    return el
}
const colDivWithInputEl = (numberCount) => {
    const el = document.createElement("div")
    el.setAttribute("class", `col-10`)
    el.appendChild(inputEl(numberCount))
    return el
}
const colDivWithDelBtnEl = (numberCount) => {
    const el = document.createElement("div")
    el.setAttribute("class", `col-2 `)
    el.appendChild(removeBtnEl(numberCount))
    return el
}
const inputEl = (numberCount) => {
    const el = document.createElement("input")
    el.setAttribute("name", "questions[]")
    el.setAttribute("type", "text")
    el.setAttribute("class", "form-control mb-2")
    el.setAttribute("placeholder", `Write question ${numberCount}`)
    el.setAttribute("id", `questions${numberCount}`)
    return el
}
const removeBtnEl = (numberCount) => {
    const el = document.createElement("button")
    el.setAttribute("class", "btn btn-danger")
    el.setAttribute("id", `btn-${numberCount}`)
    el.setAttribute("type", "button")
    el.textContent = "Remove Question"
    el.addEventListener("click", (event) => {
        event.preventDefault()
        const deletionRow = document.getElementById(`row-${numberCount}`)
        removeSessionKey('readAndAnswerQuestionCreate')
        deletionRow.remove()
    })
    return el
}


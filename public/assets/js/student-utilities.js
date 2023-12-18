const fireToast = (type, msg) => {
    Toast.fire({
        icon: type,
        title: msg
    })
    return false
}
/************************************** student part start*********************************************/
const handleBackToModuleIndex = (el, routePath) => {
    window.location = routePath
}

/***********************************answer submission part***************************************/
const submitAnswer = (url, formData, csrfToken, successCall) => {
    fetch(url, {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Accept": "application/json"
        },
        mode: "same-origin",
        credentials: "same-origin"
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error(response.statusText);
        })
        .then(successCall)
        .catch(error => {
            console.log(error.message)
        })
}

/***********************************true false handle click ***************************************/
const handleTrueFalseClick = (el) => {
    const optionsEl = document.querySelectorAll(".options")
    const trueFalseAnswer = document.getElementById('answer')

    optionsEl.forEach((element) => {
        element.classList.add('bg-white')
        element.classList.remove("tb-bg-1-clicked", "tb-bg-2-clicked")
    })
    if (el.id === "true") {
        el.classList.remove('bg-white')
        el.classList.add('tb-bg-1-clicked')
    }
    if (el.id === "false") {
        el.classList.remove('bg-white')
        el.classList.add('tb-bg-2-clicked')
    }
    trueFalseAnswer.value = el.id === "true" ? "1" : "0"
}
/***********************************closed options handle click ***************************************/
const handleOptionClick = (el) => {
    const optionsEl = document.querySelectorAll(".options")
    const trueFalseAnswer = document.getElementById('answer')

    optionsEl.forEach((element) => {
        element.classList.add('bg-white')
        element.classList.remove("tb-bg-1-clicked", "tb-bg-2-clicked", "tb-bg-3-clicked", "tb-bg-4-clicked")
    })
    if (el.id === "option1") {
        el.classList.remove('bg-white')
        el.classList.add('tb-bg-1-clicked')
    }
    if (el.id === "option2") {
        el.classList.remove('bg-white')
        el.classList.add('tb-bg-2-clicked')
    }
    if (el.id === "option3") {
        el.classList.remove('bg-white')
        el.classList.add('tb-bg-3-clicked')
    }
    if (el.id === "option4") {
        el.classList.remove('bg-white')
        el.classList.add('tb-bg-4-clicked')
    }
    trueFalseAnswer.value = el.id
}

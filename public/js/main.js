function getBaseUrl() {
    var re = new RegExp(/^.*\//);
    return re.exec(window.location.href);
}

function reload() {
    var methodSelect = document.getElementById('methodSelect');
    var numberInput = document.getElementById('numberInput');
    var query = '?method=' + methodSelect.value + '&number=' + numberInput.value;
    location.href = getBaseUrl() + query;
}
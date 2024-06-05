function goBack() {
    window.history.back();
}

function changeRowsPerPage() {
    const rowsPerPage = document.getElementById('rows').value;
    window.location.href = `?page=1&rows=${rowsPerPage}`;
}

function handlePagination(action) {
    if (action === 'first') {
        document.getElementById("toast__text").innerHTML =
            "First Page now.";
        document.getElementById("van-toast").style.display = "flex";
        setTimeout(function() {
            document.getElementById("van-toast").style.display = "none";
        }, 3000);
    } else if (action === 'last') {
        document.getElementById("toast__text").innerHTML =
            "Last Page now.";
        document.getElementById("van-toast").style.display = "flex";
        setTimeout(function() {
            document.getElementById("van-toast").style.display = "none";
        }, 3000);
    }
}
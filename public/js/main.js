
function updateFilename() {
    const fileInput = document.getElementById('photo');
    const fileNameDisplay = document.getElementById('file-name-display');
    const file = fileInput.files[0];

    if (file) {
        fileNameDisplay.textContent = 'Selected File: ' + file.name;
    } else {
        fileNameDisplay.textContent = 'No file selected';
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const successMsg = document.getElementById('successMsg');
    if (successMsg) {
        setTimeout(() => {
            successMsg.style.display = 'none';
        }, 5000);
    }
});


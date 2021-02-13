function displayImageCategory(e) {

    if (e.files[0]) {

        const reader = new FileReader();
        reader.onload = function (e) {
                document.querySelector('#categoryImage').setAttribute('src', e.target.result);
            };

        reader.readAsDataURL(e.files[0]);
    }
}

function triggerCategoryAdd() {
    document.querySelector('#categoryUpload').click();
}

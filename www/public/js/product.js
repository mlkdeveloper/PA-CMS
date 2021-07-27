function getSelectedAttributes(id) {

    if ($('#attr-' + id).is(':checked')) {
        addAttribute(id)
    } else {
        deleteAttributes(id);
    }
}

function deleteAttributes(id) {
    $("#selectedAttributes-" + id).remove();
}

function addAttribute(id) {

    let name = $("#lab-" + id).text();

    $.ajax({
        url: "/admin/valeurs-attribut-ajax?id=" + id,
        type: 'GET',
        success: (data) => {

            let array = JSON.parse(data);

            let html =
                "<div id='selectedAttributes-" + id + "' class='row'>" +
                "<div class=\"col-md-6\">" +
                "<h4>" + name + "</h4>" +
                "</div>" +
                "<div class=\"col-md-6\">" +
                "<div class='attributes attrValues' id='val-" + id + "'>\n";

            array.map((value) => {
                html += "<div class='mb-1'><input id='" + value.id + "' class='" + name + " terms' name='" + value.name + "' type='checkbox' value='" + value.id + "'><label>" + value.name + "</label></div>"
            });

            html +=
                "</div>\n" +
                "</div>\n" +
                "</div>";

            $("#selectedAttributes").append(html);

        },
        error: () => {
            //error
        }
    })
}


function isVariant() {
    if ($('#variant').is(':checked')) {
        $('#blockAttributes').show();
        $(".checked").prop('checked', false);
        $('#variant').val(1)
        $('#attr_container').show()
        $('#var_container').show()
        $('#without_attr').hide()
        $('#valider').show()
        $('#comb').empty()
    } else {
        $('#blockAttributes').hide();
        $('#selectedAttributes').html("")
        $('#variant').val(0)
        $('#attr_container').hide()
        $('#var_container').hide()
        $('#without_attr').show()
        $('#valider').hide()
        $('#comb').html("<button class='button button--success' onclick='addProductWV()'>Enregistrer</button>")
    }
}

function getTerms() {
    return $("input:checkbox.terms").is(':checked')
}

function buildArray(callback, id) {
    if (getTerms()) {
        var className = '';
        var array = [];
        var count = 0;
        var arrayAttributs = $('.attrValues input:checked');
        array_id = []

        $.each(arrayAttributs, function (i, attrib) {
            if (i === 0) {
                array.push([]);
                array_id.push([]);
                className = $(attrib).attr("class");
            }

            if ($(attrib).attr("class") === className) {
                array[count].push($(attrib).attr("name"));
                array_id[count].push($(attrib).attr("id"));
            } else {
                className = $(attrib).attr("class");
                array.push([]);
                array_id.push([]);
                count++;
                array[count].push($(attrib).attr("name"));
                array_id[count].push($(attrib).attr("id"));
            }
        });

        comb = generation(array_id);
        let comb_label = generation(array);

        comb.map((x, y) => {
            generateInputs("#comb", comb_label[y]);
        })

        display_buttons(callback, id)

        $("#loader").show();
        $("div[name='comb']").hide();
        $("#sub_comb").hide();

        setTimeout(() => {
            $("#loader").fadeOut();
            $("div[name='comb']").show();
            $("#sub_comb").show();
        }, 10);

        clearInterface()
    } else {
        showStatus("<div class='alert--red alert'>Sélectionnez des variants</div>")
    }

}

function generation(parts) {
    const result = parts.reduce((a, b) => a.reduce((r, v) => r.concat(b.map(w => [].concat(v, w))), []));

    // result = result.map(a => a.join(', '));
    return result;
}

function generateInputs(selector, label) {
    $(selector).append(
        "<div name='comb' class='row mb-2'>" +
        "<label class='col-md-2'>" + label + "</label>" +
        "<input type='number' class='input col-md-3 mr-1' name='stock' placeholder='Stock' /> " +
        "<input type='number' class='input col-md-3' name='price' placeholder='Prix' />" +
        "<input accept='image/png, image/jpg, image/jpeg, image/svg' class='input' type='file' name='files_groups' required='required'>" +
        "</div>"
    )
}

let array_id = [];
let comb;


function createProduct() {
    var err = checkProduct($("#product_name").val())
    if (err.length === 0) {

        var stock = $("input[name='stock']");
        var price = $("input[name='price']");
        var files = $("input[name='files_groups']");
        var form_data = new FormData();

        for (var i = 0; i < files.length; i++) {
            if (files[i].files[0] !== undefined) form_data.append("file_" + i, files[i].files[0])
        }

        var product = {
            name: $("#product_name").val(),
            description: $("#description").val(),
            type: $("#variant").val(),
            isPublished: 0,
            idCategory: $("#category").val()
        };


        comb.forEach((element, y) => {
            if (Array.isArray(element)) {
                element.push(stock[y].value)
                element.push(price[y].value)
            } else {
                element = element.split();
                element.push(stock[y].value)
                element.push(price[y].value)
                comb.push(element)
                comb = comb.filter(type_var => Array.isArray(type_var))
            }
        })

        var comb_object = Object.assign({}, comb);
        comb_object = JSON.stringify(comb_object)

        product = JSON.stringify(product)

        form_data.append("comb_array", comb_object);
        form_data.append("product", product);

        $.ajax({
            type: 'POST',
            url: "/admin/creer-produit-ajax",
            data: form_data,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            success: (data) => {
                showStatus(data)
                reset()
            },
            error: () => {
            }
        })
    } else {
        err.map(x => showStatus(x))
    }

}


function clearInterface() {
    $('#valider').parent().hide()
}

function reset() {
    $('#valider').parent().show()
    $("#comb").empty()
}

function checkProduct(pn) {
    var err = []
    if (!pn) {
        err.push("<div class='alert alert--red'>Le produit doit avoir un nom</div>")
    }
    return err;
}

function showStatus(data) {
    $('#status').show();
    $('#status').html(data);
    $("html").css({
        'scrollBehavior': 'smooth'
    })
    $("html").scrollTop(0)
}

// Modification du produit

function updateProduct(id) {

    var err = checkProduct($("#product_name").val())
    if (err.length === 0) {
        var stock = $("input[name='stock']");
        var price = $("input[name='price']");
        var files = $("input[name='files_groups']");
        var form_data = new FormData();

        for (var i = 0; i < files.length; i++) {
            if (files[i].files[0] !== undefined) form_data.append("file_" + i, files[i].files[0])
        }

        var product = {
            name: $("#product_name").val(),
            description: $("#description").val(),
            type: $("#variant").val(),
            isPublished: 0,
            idCategory: $("#category").val()
        };

        comb.forEach((element, y) => {
            if (Array.isArray(element)) {
                element.push(stock[y].value)
                element.push(price[y].value)
            } else {
                element = element.split();
                element.push(stock[y].value)
                element.push(price[y].value)
                comb.push(element)
                comb = comb.filter(type_var => Array.isArray(type_var))
            }
        })

        var comb_object = Object.assign({}, comb);
        comb_object = JSON.stringify(comb_object)

        product = JSON.stringify(product)

        form_data.append("comb_array", comb_object);
        form_data.append("product", product);

        $.ajax({
            type: 'POST',
            url: "/admin/update-product-ajax?id=" + id,
            data: form_data,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            success: (data) => {
                showStatus(data)
                reset()
            },
            error: () => {
            }
        })
    } else {
        err.map(x => showStatus(x))
    }
}

function add_variante() {
    var url = new URL(location);
    var search_params = url.searchParams;
    $("div[name='comb']").parent().remove();
    $("#attr_container").show()
    $("#var_container").show()
    $("#addVar").hide()
    $("#btns").html("<button id='valider' class='button button--blue' onclick=\"buildArray('updateProduct', '" + search_params.get('id') + "')\">Valider</button>")
}

function update_var(idGroup) {
    const form_data = new FormData();
    form_data.append("stock", $("#stock-" + idGroup).val())
    form_data.append("price", $("#price-" + idGroup).val())
    form_data.append("file", $('#file-' + idGroup)[0].files[0])

    console.log($('#file-' + idGroup)[0].files[0])
    $.ajax({
        type: 'POST',
        url: "/admin/update-var?id=" + idGroup,
        data: form_data,
        processData: false,
        contentType: false,
        success: (data) => {
            showStatus(data)
        },
        error: () => {
        }
    })
}

function display_buttons(callback, id) {
    $("#comb").append("<input id='back' type='submit' value='Réinitialiser' onclick='reset()' class='button button--warning mr-1' />")
    $("#comb").append("<input id='sub_comb' type='submit' value='Enregistrer' onclick='" + callback + "(" + id + ")' class='button button--success' />")
}

function updateP(id) {
    $.ajax({
        type: 'POST',
        url: "/admin/update-p?id=" + id,
        data: "name=" + $("#product_name").val() + "&idCategory=" + $("#category").val() + "&description=" + $("#description").val() + "&type=" + $("#variant").val(),
        success: (data) => {
            showStatus(data)
        },
        error: (data, res) => {
            console.log(data)
        }
    })
}

function addProductWV() {
    var stock = $("#stock").val();
    var price = $("#price").val();
    var form_data = new FormData();

    var product = {
        name: $("#product_name").val(),
        description: $("#description").val(),
        type: $("#variant").val(),
        isPublished: 0,
        idCategory: $("#category").val(),
        price: price,
        stock: stock

    };

    product = JSON.stringify(product)
    form_data.append("product", product)
    form_data.append("file", $('#file')[0].files[0])

    $.ajax({
        type: 'POST',
        url: "/admin/add-product-wv",
        data: form_data,
        processData: false,
        contentType: false,
        // enctype: 'multipart/form-data',
        success: (data) => {
            showStatus(data)
        },
        error: () => {
        }
    })
}

function hasVariants() {
    if ($('#variant').is(':checked')) {
        $("#btns").show();
        $("#variantes_inputs").show();
        $('#without_attr').hide()
        $('#variant').val(1)
        $("#comb").children().remove()
    } else {
        $('#attr_container').hide()
        $('#var_container').hide()
        $('#variant').val(0)
        $("#variantes_inputs").hide();
        $("#btns").hide();
        $('#without_attr').show()
        $('#comb').html("<button class='button button--success' onclick='updateProductWV()'>Enregistrer</button>")
    }
}

if (!$('#variant').is(':checked') && $("#btns") !== undefined) $("#btns").hide();

function updateProductWV() {
    var stock = $("#stock").val();
    var price = $("#price").val();
    var form_data = new FormData();
    var url = new URL(location);
    var search_params = url.searchParams;

    var product = {
        name: $("#product_name").val(),
        description: $("#description").val(),
        type: $("#variant").val(),
        isPublished: 0,
        idCategory: $("#category").val(),
        price: price,
        stock: stock
    };

    product = JSON.stringify(product)
    form_data.append("product", product)
    form_data.append("file", $('#file')[0].files[0])

    $.ajax({
        type: 'POST',
        url: "/admin/update-product-wv?id=" + search_params.get('id'),
        data: form_data,
        processData: false,
        contentType: false,
        // enctype: 'multipart/form-data',
        success: (data) => {
            showStatus(data)
        },
        error: () => {
        }
    })
}

function iconFile(id) {
    const idG = $(id).attr('id').split("-")[2]
    $("#file-" + idG).click()
}

function previewImage(id) {
    const [file] = $("#file-" + id)[0].files
    let fileName = file.name.split(".")

    if (fileName[fileName.length - 1] === "jpg" ||
        fileName[fileName.length - 1] === "jpeg" ||
        fileName[fileName.length - 1] === "png'") {
        $("#previewPicture-" + id).show()
        $("#preview-" + id).attr("src", URL.createObjectURL(file))
    } else {
        $("#previewPicture-" + id).hide()
    }
}

function setDefaultComb() {
    $
}
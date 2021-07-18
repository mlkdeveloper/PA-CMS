function getSelectedAttributes(id){

    if($('#attr-' + id ).is(':checked')){
        addAttribute(id)
    }else{
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
               "<div id='selectedAttributes-"+id+"' class='row'>" +
               "<div class=\"col-md-6\">" +
               "<h4>"+ name +"</h4>" +
               "</div>" +
               "<div class=\"col-md-6\">" +
               "<div class='attributes attrValues' id='val-"+id+"'>\n";

          array.map((value) => {
                html += "<div class='mb-1'><input id='" + value.id + "' class='"+name+"' name='"+value.name+"' type='checkbox' value='"+ value.id+"'><label>" + value.name + "</label></div>"
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
    if($('#variant' ).is(':checked')){
        $('#blockAttributes').show();
        $(".checked").prop('checked', false);
        $('#variant').val(1)
        $('#attr_container').show()
        $('#var_container').show()
        $('#without_attr').hide()
        $('#valider').show()
        $('#comb').empty()
    }else{
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

function buildArray(callback, id) {
    var className = '';
    var array = [];
    var count = 0;
    var arrayAttributs = $('.attrValues input:checked');
    array_id = []

    $.each(arrayAttributs, function(i, attrib){
        if (i === 0){
            array.push([]);
            array_id.push([]);
            className = $(attrib).attr("class");
        }

        if ($(attrib).attr("class") === className){
            array[count].push($(attrib).attr("name"));
            array_id[count].push($(attrib).attr("id"));
        }else{
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

    comb.map((x, y)=>{
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

}

function generation(parts){
    const result = parts.reduce((a, b) => a.reduce((r, v) => r.concat(b.map(w => [].concat(v, w))), []));

    // result = result.map(a => a.join(', '));
    return result;
}
    
function generateInputs(selector, label){
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


function createProduct(){
    var stock = $("input[name='stock']");
    var price = $("input[name='price']");
    var files = $("input[name='files_groups']");
    var form_data = new FormData();

    for(var i = 0; i < files.length; i++){
        if(files[i].files[0] !== undefined) form_data.append("file_"+i, files[i].files[0])
    }

    var product = {
        name: $("#product_name").val(), 
        description: $("#description").val(),
        type: $("#variant").val(),
        isPublished: 0,
        idCategory: $("#category").val()
    };

    var err = checkProduct($("#product_name").val())

    comb.forEach((element, y) => {
        if (Array.isArray(element)) {
            element.push(stock[y].value)
            element.push(price[y].value)
        }else{
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

    if(err.length === 0){
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
            error: () => {}
        })
    }else{
        err.map(x => showStatus(x))
    }

}


function clearInterface(){
    $('#valider').parent().hide()
}

function reset(){
    $('#valider').parent().show()
    $("#comb").empty()
}

function checkProduct(pn){
    var err = []
    if(!pn){
        err.push("<div class='alert alert--red'>Le produit doit avoir un nom</div>")
    }
    return err;
}

function showStatus(data){
    $('#status').show();
    $('#status').html(data);
    $("html").css({
        'scrollBehavior': 'smooth'
    })
    $("html").scrollTop(0)
}



// Modification du produit

function updateProduct(id){
    
    var stock = $("input[name='stock']");
    var price = $("input[name='price']");
    var files = $("input[name='files_groups']");
    var form_data = new FormData();

    for(var i = 0; i < files.length; i++){
        if(files[i].files[0] !== undefined) form_data.append("file_"+i, files[i].files[0])
    }

    var product = {
        name: $("#product_name").val(), 
        description: $("#description").val(),
        type: $("#variant").val(),
        isPublished: 0,
        idCategory: $("#category").val()
    };

    var err = checkProduct($("#product_name").val())

    comb.forEach((element, y) => {
        if (Array.isArray(element)) {
            element.push(stock[y].value)
            element.push(price[y].value)
        }else{
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


    if(err.length === 0){
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
            error: () => {}
        })
    }else{
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
    $("#btns").html("<button id='valider' class='button button--blue' onclick=\"buildArray('updateProduct', '"+search_params.get('id')+"')\">Valider</button>")
}

function update_var(idGroup){
    $.ajax({
        type: 'POST',
        url: "/admin/update-var?id="+idGroup,
        data: "stock=" + $("#stock-"+idGroup).val() + "&price=" + $("#price-"+idGroup).val(),
        success: (data) => {
            showStatus(data)
        },
        error: (data, res) => {
            console.log(data)
        }
    })
}


function display_buttons(callback, id){
    $("#comb").append("<input id='back' type='submit' value='Réinitialiser' onclick='reset()' class='button button--warning mr-1' />")
    $("#comb").append("<input id='sub_comb' type='submit' value='Enregistrer' onclick='"+callback+"("+id+")' class='button button--success' />")

}


function updateP(id){
    $.ajax({
        type: 'POST',
        url: "/admin/update-p?id="+id,
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
        error: () => {}
    })
}

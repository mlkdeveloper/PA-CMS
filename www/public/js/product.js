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
    }else{
        $('#blockAttributes').hide();
        $('#selectedAttributes').html("")
    }
}

function buildArray() {
    var arrayAttributs = $('.attrValues input:checked');

    var className = '';
    var array = [];
    var count = 0;

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

    comb.map((x, value)=>{
        generateInputs("#comb", x);
    })

    $("#comb").append("<input id='sub_comb' type='submit' value='Enregistrer' onclick='createProduct()' class='button button--success' />")

    $("#loader").show();
    $("div[name='comb']").hide();
    $("#sub_comb").hide();

    setTimeout(() => {
        $("#loader").fadeOut();
        $("div[name='comb']").show();
        $("#sub_comb").show();
    }, 500);

}

function generation(parts){
    const result = parts.reduce((a, b) => a.reduce((r, v) => r.concat(b.map(w => [].concat(v, w))), []));

    // result = result.map(a => a.join(', '));
    return result;
}
    
function generateInputs(selector, id){
    $(selector).append(
        "<div name='comb' class='row mb-2'>" +
            "<label class='col-md-1'>" + id + "</label>" +
            "<input type='number' class='input col-md-5 mr-1' name='stock' placeholder='Stock' /> " +
            "<input type='number' class='input col-md-5' name='price' placeholder='Prix' />" +
        "</div>" 
    )
}
let array_id = [];
let comb;

function createProduct(){
    var stock = $("input[name='stock']");
    var price = $("input[name='price']");

    if(comb.length === 1){
        comb.push(stock[0].value)
        comb.push(price[0].value)
        var comb2 = [comb]
        comb = comb2
    }else{
        comb.forEach((element, y) => {
            element.push(stock[y].value)
            element.push(price[y].value)
        })
    } 

    comb = Object.assign({}, comb);
    comb = JSON.stringify(comb)


    $.ajax({
        type: 'POST',
        url: "/admin/creer-produit-ajax",
        data: "comb_array=" + comb,
        success: (data) => {
            console.log(data)
        },
        error: () => {

        }

    })

}



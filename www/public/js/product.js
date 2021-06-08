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
                   "<div class='attributes' id='val-"+id+"'>\n";

              array.map((value) => {
                    html += "<div class='mb-1'><input name='value-"+ id + "' type='checkbox' value='"+ value.id+"'><label>" + value.name + "</label></div>"
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



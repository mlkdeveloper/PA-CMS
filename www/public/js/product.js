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
                    html += "<div class='mb-1'><input class='"+name+"' name='"+value.name+"' type='checkbox' value='"+ value.id+"'><label>" + value.name + "</label></div>"
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
    var arrayAttributs;
    arrayAttributs = $('.attrValues input:checked');

    var className = '';
    var array = [];
    var count = 0;

    $.each(arrayAttributs, function(i, attrib){
        if (i === 0){
            array.push([]);
            className = $(attrib).attr("class");
        }

        if ($(attrib).attr("class") === className){
            array[count].push($(attrib).attr("name"));
        }else{
            className = $(attrib).attr("class");
            array.push([]);
            count++;
            array[count].push($(attrib).attr("name"));
        }
    });


    generation(array);
}



function generation(parts){
        var result = parts.reduce((a, b) => a.reduce((r, v) => r.concat(b.map(w => [].concat(v, w))), []));

    result = result.map(a => a.join(', '));
    console.log(result);
    for (let i = 0; i < result.length; i++){
        $("#selectedAttributes").append(result[i]);
    }
}
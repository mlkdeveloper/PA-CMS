


function getValueAttribute() {

    let getId = $('#attribute').val();
    $("#value").empty();
    if (getId !== '1'){

        $.ajax({
            url: "/admin/valeurs-attribut-ajax?id=" + getId,
            type: 'GET',
            success: (data) => {
                let array = JSON.parse(data);
                displayInputValue(array);
            },
            error: () => {
              //error
            }
        })
    }else{
        displayInputValue([]);
    }
}

function displayInputValue(array) {

    array.map( (value) => {
        $("#value").append("<li><input class='' type='checkbox' value='"+ value.id+"'><label>"+ value.name+"</label>")
    } );
}

function displayAttribute() {

    let html = "                    <div class=\"row\">\n" +
        "                        <div class=\"col-md-6 col-lg-6 col-sm-6 col\">\n" +
        "                            <div class=\"form_align--top\">\n" +
        "                                <label class=\"label\">Attribut *</label>\n" +
        "                                <select class=\"input\" id=\"attribute\" onchange=\"getValueAttribute()\">\n" +

        "                                </select>\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "                        <div class=\"col-md-6 col-lg-6 col-sm-6 col\">\n" +
        "                            <div class=\"form_align--top\">\n" +
        "                                <label class=\"label\">Valeurs</label>\n" +
        "                                <div id=\"value\"></div>\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "                    </div>\n";


    $("#blockAttribute").append(html)
}
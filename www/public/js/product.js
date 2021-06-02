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


let attributes = $("input[name='attributs']");
let inputs = [];

function all_comb_products()
{
/*
* Récupérer tous les checkbox des attributs dont la prop 'checked' est égal à true =====> OK
*
* Récupérer tous les checkbox des valeurs des attributs dont le prop 'checked' est égal à true ======> OK
*
* Faire une combinaison de chaque attribut - valeur
*
* Une fois fait envoyer les datas dans une fonction ajax
*
* */

    let i;
    for( i = 0; i < attributes.length; i++){
        if(attributes[i].checked) {
            //On récup les inputs qui sont sélectionnés
            inputs.push(attributes[i])
        }
    }

}

attributes.on("click", all_comb_products)

function test(){
    //initialisation du tableau
    let val_array = []
    for ( let i = 0; i < inputs.length; i++){
        //On crée un tableau clé : valeur
        //Clé = id de l'input de l'attribut
        val_array[inputs[i].id] = []
        $("input[name='value-"+ inputs[i].value +"']").map((x, val) => {
            if(val.checked){
                val_array[inputs[i].id].push(val.value)
            }
        })
    }
    console.table(val_array)
}


/*
*
* Couleur : [vert, rouge, bleu]
*
* Taille : [XS, S, M, L]
*
* Matière : [Cuire, Coton, Plastique]
*
* */

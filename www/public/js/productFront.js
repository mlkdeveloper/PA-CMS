function getPrice(id){

    let values = [];
    let isEmpty = 0;

    $(".variant option:selected").each(function( index ) {

        if ($(this).val() === ""){
            isEmpty = 1;
        }else{
            values.push($(this).val());
        }
    });

    if (isEmpty === 0){
        $.ajax({
            url: "/produit/prix",
            data: {id:id, values : values},
            success: (data) => {

                let json = JSON.parse(data);
                $("#price").empty().append("€ " + json.price);

                if (json.picture !== null)
                    $("#displayImage").html("<img width='100%' src='../../images/products/"+ json.picture+"'>")
                else
                    $("#displayImage").html("<img width='100%' src='../../images/cc.png'>");


                if (json.stock == 0){
                    $("#quantity").attr('disabled','disabled');
                    $("#add").css("display","none");
                    $("#msg").empty().append("<p>Stock épuisé !</p>");
                }else{
                    $("#quantity").removeAttr('disabled');
                    $("#quantity").attr('max',json.stock);
                    $("#add").attr('onclick','addShoppingCart('+id+','+json.id+')');
                    $("#add").css("display","block");
                    $("#msg").empty().append("<p>Stock : " + json.stock + "</p>");

                }
            },
        });

    }


}

function addShoppingCart(id,idGroup){


    let values = [];
    let isEmpty = 0;

    $(".variant option:selected").each(function( index ) {

        if ($(this).val() === ""){
            isEmpty = 1;
        }else{
            values.push($(this).val());
        }
    });
    let quantity = $('#quantity').val();

    if (isEmpty === 0){
        $.ajax({
            url: "/ajout-panier",
            data: {id:id, idGroup:idGroup, values : values,quantity:quantity},
            success: (data) => {
                $('#msgShoppingCart').empty().append(data);
            },
            error:(data) => {
                $('#msgShoppingCart').empty().append(data.responseText);
            },
        });

    }

}
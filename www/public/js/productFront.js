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

                if (json.stock == 0){
                    $("#quantity").attr('disabled','disabled');
                    $("#add").css("display","none");
                    $("#msg").empty().append("<p>Stock épuisé !</p>");
                }else{
                    $("#quantity").removeAttr('disabled');
                    $("#quantity").attr('max',json.stock);
                    $("#add").css("display","block");
                    $("#msg").empty().append("<p>Stock : " + json.stock + "</p>");

                }
            },
        });

    }


}
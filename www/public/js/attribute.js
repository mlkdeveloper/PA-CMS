function handleDelete(id){
    $.ajax({
        url: "/admin/suppression-attribut",
        type: 'POST',
        data: {id:id},
        success: function (response,status){
            $("#attr-" + id).remove();
            $('#msg').html('<div class="alert alert--green">'+ response + '</div>');
        },
        error: function (res){
            $('#msg').html('<div class="alert alert--red">' + res.responseText +'</div>');
        }
    })
}

function handleDeleteTerm(id, idAttribute){
    $.ajax({
        url: "/admin/suppression-terme",
        type: 'POST',
        data: {id:id, idAttributes:idAttribute},
        success: function (response,status){
            $("#term-" + id).remove();
            $('#msg').html('<div class="alert alert--green">'+ response + '</div>');
        },
        error: function (res){
            $('#msg').html('<div class="alert alert--red">' + res.responseText +'</div>');
        }
    })
}

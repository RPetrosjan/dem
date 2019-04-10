var PanierArray = {};
var TotalPrixPanier = 0;
var ArticlesCount = 0;

// Write Panel Articles in Mon Panier
function WrtiePanierArticles(){

    html_panier = ''
    ArticlesCount = 0;
    TotalPrixPanier = 0;

    // Get all Panier Articles
    $.each(PanierArray,function (key,value) {
        ArticlesCount += parseInt(value['count'],10);
        TotalPrixPanier += parseFloat(String(value['prix']).replace(',','.'));

        // Creating preparation for HTML show
        html_panier += '<div><span class="nom_carton">'+value['name']+'</span><span class="quantite_carton">'+value['count']+'</span><span class="prix_carton">'+parseFloat(value['prix']).toFixed(2)+' &euro;</span><i name="'+key+'" class="fas fa-trash"></i></div>';
    });

    // Check if exist Articles
     if(ArticlesCount == 0) {
         html_panier = '<div><h3>Votre Panier est vide</h3></div>';
         $('.toppanelarticles, .articles_valider').hide();
     }
     else {
         $('.toppanelarticles, .articles_valider').show();
     }

    // Make HTML data
    $('.articles').html(html_panier);

    //Update for Removing Update Trash
    UpdateTrash();

    // Write in Panier Title info Article
    $('.panier_count').html('Articles ' + ArticlesCount + ' - Total ' +TotalPrixPanier.toFixed(2)+'&euro;');
}

// Update removing Trash liste function
function UpdateTrash(){
    $('.fa-trash').unbind('click').click(function () {
        delete PanierArray[$(this).attr('name')];
        WrtiePanierArticles();
    });
}

// Add new Article in to Panier
$('.spanplusadmin.ajouter.button').click(function () {
    var carton_parent = $(this).closest('.divcarton');
    var count_carton = carton_parent.find('.resultspanplusadmin').text();
    var code_carton = carton_parent.find('.codecarton').text();

    TotalPrixPanier = 0;
    ArticlesCount= 0;
    // Creation Array Panier Articles
    PanierArray[code_carton] = {
        'name' : carton_parent.find('.nomcarton').text(),
        'count' : carton_parent.find('.resultspanplusadmin').text(),
        'prix' : parseFloat(carton_parent.find('.spanprixunite').text().replace(',','.')) * parseFloat(carton_parent.find('.resultspanplusadmin').text()),
    };

    // Wrtie in to Articles liste
    WrtiePanierArticles();
});

$('.fa-plus-square').click(function () {

    var carton_parent = $(this).closest('.divcarton');
    var number = carton_parent.find('.resultspanplusadmin').text();

    if(parseInt(number,10) < 10) {
        carton_parent.find('.resultspanplusadmin').text(++number);
    }
});

$('.mon_panier_panel').click(function () {
    $('.panier_details').toggle('fast');

    // Show Table liste des Articles
    if($('.articles_valider').text() != 'Valider') {
        $('.articles').show();
        $('.toppanelarticles').show();
        $('.cartonform').hide();
        $('.articles_valider').text('Valider');
    }

});
$('.panier_details .fa-chevron-up').click(function () {
    $(this).closest('.panier_details').toggle('fast');
}) ;


$('.fa-minus-square').click(function () {

    var carton_parent = $(this).closest('.divcarton');
    var number = carton_parent.find('.resultspanplusadmin').text();

    if(parseInt(number,10) > 1) {
        carton_parent.find('.resultspanplusadmin').text(--number);
    }
});

$('.articles_valider').click(function () {
    var text = $(this).text();
    if(text == 'Retour') {
        $('.articles').show();
        $('.toppanelarticles').show();
        $('.cartonform').hide();
    }
    else {

        console.log(JSON.stringify(PanierArray));
        $("[name *= 'cartonJson']").val(JSON.stringify(PanierArray));
        $('.articles').hide();
        $('.toppanelarticles').hide();
        $('.cartonform').show();
    }

    $(this).text($(this).text() == 'Retour' ? 'Valider' : 'Retour');


});

$('.mon_panier_panel').scrollToFixed();
$('.panier_details').scrollToFixed();

WrtiePanierArticles();
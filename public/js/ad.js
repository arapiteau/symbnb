$('#add-image').click(function(){
    // On récupère le numéro du prochain champ à créer
    const index = +$('#widgets-counter').val();
    console.log(index);

    // On récupère le prototype de l'entrée à créer
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);
    
    
    // On injecte le code (prototype) récupéré 
    $('#ad_images').append(tmpl);

    $('#widgets-counter').val(index + 1);

    // On rattache le bouton supprimer
    handleDeleteButtons();
});

function updateCounter(){
    const count = +$('#ad_images div.form-group').length;
    $('#widgets-counter').val(count);
}

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

updateCounter();
handleDeleteButtons();
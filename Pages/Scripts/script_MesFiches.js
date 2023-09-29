var bouton = document.getElementById("demander");
var modal = document.getElementById("fiche");
var fermerModal = document.getElementById("fermer");

bouton.addEventListener("click", function() {
    modal.style.display = "block";
});
fermerModal.addEventListener("click", function() {
    modal.style.display = "none";
});


function ajouterLigne() {
    numLigne++;
    // On crée une nouvelle div pour la ligne ajoutée
    var div = document.createElement('div');
    div.setAttribute('id', 'ligne'+numLigne);
    div.setAttribute('style', 'clear:left;');

    // On ajoute le numéro de ligne en tant que label
    var label = document.createElement('label');
    label.setAttribute('class', 'titre');
    label.innerHTML = numLigne+' : ';
    div.appendChild(label);

    // On ajoute l'input pour la date
    var inputDate = document.createElement('input');
    inputDate.setAttribute('type', 'date');
    inputDate.setAttribute('size', '12');
    inputDate.setAttribute('name', 'FRA_AUT_DAT'+numLigne);
    inputDate.setAttribute('class', 'zone');
    div.appendChild(inputDate);

    // On ajoute l'input pour le libellé
    var inputLibelle = document.createElement('input');
    inputLibelle.setAttribute('type', 'text');
    inputLibelle.setAttribute('size', '30');
    inputLibelle.setAttribute('name', 'FRA_AUT_LIB'+numLigne);
    inputLibelle.setAttribute('class', 'zone');
    inputLibelle.setAttribute('placeholder', 'ex : Frais de déplacement');
    div.appendChild(inputLibelle);

    // On ajoute l'input pour le montant
    var inputMontant = document.createElement('input');
    inputMontant.setAttribute('type', 'number');
    inputMontant.setAttribute('size', '3');
    inputMontant.setAttribute('name', 'FRA_AUT_MONT'+numLigne);
    inputMontant.setAttribute('class', 'zone');
    inputMontant.setAttribute('placeholder', 'ex : 30');
    div.appendChild(inputMontant);

    // On ajoute la nouvelle ligne au formulaire
    var lignes = document.getElementById('lignes');
    lignes.appendChild(div);
}
function supprLigne() {
    var ligne = document.getElementById('ligne'+numLigne);
    ligne.parentNode.removeChild(ligne);

    // Ré-indexer les numéros de lignes des inputs suivants
    var lignes = document.querySelectorAll('[id^="ligne"]');
    for (var i = 0; i < lignes.length; i++) {
        var num = parseInt(lignes[i].getAttribute('id').substr(5));
        if (num > numLigne) {
            var inputs = lignes[i].getElementsByTagName('input');
            for (var j = 0; j < inputs.length; j++) {
                var name = inputs[j].getAttribute('name');
                var newName = name.substring(0, 10) + (num-1);
                inputs[j].setAttribute('name', newName);
            }
            lignes[i].setAttribute('id', 'ligne'+(num-1));
            var label = lignes[i].getElementsByTagName('label')[0];
            label.innerHTML = (num-1) + ' : ';
        }
    }
    numLigne = numLigne-1;
}

function supprimerToutesLignes() {
    var parentElement = document.getElementById('lignes');
    var child = parentElement.lastElementChild;

    while (child.previousElementSibling) {
        parentElement.removeChild(child);
        child = parentElement.lastElementChild;
    }
    numLigne = 1;
}

function verifdate(i){
    var date = document.querySelector("[name='FRA_AUT_DAT"+i+"']");
    var dateAuj = new Date();
    var UnAnAvant = new Date();
    UnAnAvant.setFullYear(dateAuj.getFullYear()-1);
    if (date.value < unAnAvant || date.value > dateAuj){
        return false;
    }
    else{
        return true;
    }
}

function verifform() {
    var formulaire = document.getElementById("formulaire_fiche");
    if (FRA_REPAS.value == "" || FRA_REPAS.value <0) {
        alert("Le nombre de repas ne peut pas être vide ou négatif");
    }
    if (FRA_NUIT.value == "" || FRA_NUIT.value <0) {
        alert("Le nombre de nuit ne peut pas être vide ou négatif");
    }
    if (FRA_ETAP.value == "" || FRA_ETAP.value <0) {
        alert("Le nombre d'étapes ne peut pas être vide ou négatif");
    }
    if (FRA_KM.value == "" || FRA_KM.value <0) {
        alert("Le nombre de km ne peut pas être vide ou négatif");
    }
    for (var i = 1; i <= numLigne; i++) {
        if (verifdate(i) == false) {
            alert("La date doit être comprise entre aujourd'hui et il y a un an, ligne n°" + i + " incorrecte");
        }
        if (document.querySelector("[name='FRA_AUT_LIB" + i + "']").value == "") {
            alert("Le libellé ne peut pas être vide, ligne n°" + i + " incorrecte");
        }
        if (document.querySelector("[name='FRA_AUT_MONT" + i + "']").value == "") {
            alert("Le montant ne peut pas être vide, ligne n°" + i + " incorrecte");
        }
    }
    formulaire.submit();
}

function envoyerform(){
    var inputHidden = document.createElement("input");

    inputHidden.setAttribute("type", "hidden");
    inputHidden.setAttribute("name", "numLigne");
    inputHidden.setAttribute("value", numLigne);
    document.querySelector("#formulaire_fiche").appendChild(inputHidden);
}



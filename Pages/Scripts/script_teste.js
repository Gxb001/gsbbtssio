var bouton = document.getElementById("ouvrir-modal");
var modal = document.getElementById("modal");
var fermerModal = document.getElementById("fermer-modal");

bouton.addEventListener("click", function() {
    modal.style.display = "block";
});
fermerModal.addEventListener("click", function() {
    modal.style.display = "none";
});
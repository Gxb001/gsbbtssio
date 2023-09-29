document.getElementById("Valider").addEventListener("click", function() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'Validation.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert("Fiche de frais acceptée !!!");
            location.reload(true);
        }
    };
    xhr.send('action=valider');
});

document.getElementById("Refuser").addEventListener("click", function() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'Validation.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert("Fiche de frais refusée !!!");
            location.reload(true);
        }
    };
    xhr.send('action=refuser');
});

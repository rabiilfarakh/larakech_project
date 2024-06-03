function showModalShow(contactId) {
    fetch(`/contacts/${contactId}`)
    .then(response => response.json())
    .then(data => {
        document.getElementById('show_prenom').value = data.prenom;
        document.getElementById('show_nom').value = data.nom;
        document.getElementById('show_e-mail').value = data.e_mail;
        document.getElementById('show_entreprise').value = data.organisation.nom; 
        document.getElementById('show_adresse').value = data.organisation.adresse; 
        document.getElementById('show_postal').value = data.organisation.code_postal; 
        document.getElementById('show_ville').value = data.organisation.ville;
        
        var statutSelect = document.getElementById('show_statut');
        statutSelect.value = data.organisation.statut;
        statutSelect.disabled = true;  
        
        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        overlay.addEventListener('click', hideModal_show); 
        document.body.appendChild(overlay);

        document.getElementById('modal_show').classList.remove('hidden');
    })
    .catch(error => console.error('Error:', error));
}

function hideModal_show() {
    var overlay = document.querySelector('.overlay');
    document.getElementById('modal_show').classList.add('hidden');
    if (overlay) {
        document.body.removeChild(overlay);
    }
}

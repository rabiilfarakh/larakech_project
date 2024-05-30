function showModalUpdate(contactId) {
    fetch(`/contacts/${contactId}`)
    .then(response => response.json())
    .then(data => {
        document.getElementById('contact_id').value = data.id;
        document.getElementById('update_prenom').value = data.prenom;
        document.getElementById('update_nom').value = data.nom;
        document.getElementById('update_e-mail').value = data.e_mail;
        document.getElementById('update_entreprise').value = data.organisation.nom; 
        document.getElementById('update_adresse').value = data.organisation.adresse; 
        document.getElementById('update_postal').value = data.organisation.code_postal; 
        document.getElementById('update_ville').value = data.organisation.ville;
        document.getElementById('update_statut').value = data.organisation.statut; 

        var overlay = document.createElement('div');
        overlay.classList.add('overlay');
        overlay.addEventListener('click', hideModal_update); 
        document.body.appendChild(overlay);

        document.getElementById('modal_update').classList.remove('hidden');
    })
    .catch(error => console.error('Error:', error));
}

function hideModal_update() {
    var overlay = document.querySelector('.overlay');
    document.getElementById('modal_update').classList.add('hidden');
    if (overlay) {
        document.body.removeChild(overlay);
    }
}

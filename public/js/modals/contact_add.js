document.addEventListener('DOMContentLoaded', function() {
    var addContactBtn = document.getElementById('addContactBtn');
    var modal = document.getElementById('crud-modal');
    var modal2 = document.getElementById('modal_doublon');
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');

    function showModal() {
        modal.classList.remove('hidden');
        document.body.appendChild(overlay); 
    }

    function hideModal() {
        modal.classList.add('hidden');
        document.body.removeChild(overlay); 
    }

    function showModalDoublon() {
        modal2.classList.remove('hidden');
        document.body.appendChild(overlay); 
    }

    function hideModalDoublon() {
        modal2.classList.add('hidden');
        if (document.body.contains(overlay)) {
            document.body.removeChild(overlay);
        }
    }

    addContactBtn.addEventListener('click', function() {
        showModal();
    });

    modal.querySelector('[data-modal-toggle="crud-modal"]').addEventListener('click', function() {
        hideModal();
    });

    overlay.addEventListener('click', function() {
        hideModal();
        hideModalDoublon();
    });
    
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    modal.querySelector('#btn').addEventListener('click', function(event) {
        event.preventDefault();

        var contactName = document.getElementById('nom').value;
        var contactPrenom = document.getElementById('prenom').value;
        var entrepriseName = document.getElementById('entreprise').value;

        fetch('/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken 
            },
            body: JSON.stringify({ nom: contactName, prenom: contactPrenom, entreprise: entrepriseName }) 
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.contact_exists || data.company_exists) {
                showModalDoublon();
            } else {
                storeContact(contactName, contactPrenom, entrepriseName);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la validation du contact:', error);
        });
    });

    function storeContact(nom, prenom, entreprise) {
        var e_mail = document.getElementById('e-mail').value;
        var adresse = document.getElementById('adresse').value;
        var code_postal = document.getElementById('postal').value;
        var ville = document.getElementById('ville').value;
        var statut = document.getElementById('statut').value;

        fetch('/contacts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken 
            },
            body: JSON.stringify({
                nom: nom,
                prenom: prenom,
                entreprise: entreprise,
                e_mail: e_mail,
                adresse: adresse,
                code_postal: code_postal,
                ville: ville,
                statut: statut
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log("data:", data);
            if (data.success) {
                window.location.href = '/contacts'; 
            } else {
                console.error('Erreur lors de l\'ajout du contact:', data.message);
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'ajout du contact:', error);
        });
    }

    function confirmCreateContact() {
        var contactName = document.getElementById('nom').value;
        var contactPrenom = document.getElementById('prenom').value;
        var entrepriseName = document.getElementById('entreprise').value;
        storeContact(contactName, contactPrenom, entrepriseName);
        hideModalDoublon();
    }

    document.querySelector('#modal_doublon button[data-modal-toggle="modal_delete"]').addEventListener('click', function() {
        hideModalDoublon();
    });

    document.querySelector('#modal_doublon button.confirm-button').addEventListener('click', function() {
        confirmCreateContact();
    });
});

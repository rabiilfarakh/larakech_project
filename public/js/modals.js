document.addEventListener('DOMContentLoaded', function() {
    var addContactBtn = document.getElementById('addContactBtn');

    var modal = document.getElementById('crud-modal');

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

    addContactBtn.addEventListener('click', function() {
        showModal();
    });

    modal.querySelector('[data-modal-toggle="crud-modal"]').addEventListener('click', function() {
        hideModal();
    });

    overlay.addEventListener('click', function() {
        hideModal();
    });



});  
var overlay = document.createElement('div');
overlay.classList.add('overlay');

  var modal_delete = document.getElementById('modal_delete');

    function showModal_delete() {
        modal_delete.classList.remove('hidden');
        document.body.appendChild(overlay); 
    }

    function hideModal_delete() {
        modal_delete.classList.add('hidden');
        document.body.removeChild(overlay); 
    }

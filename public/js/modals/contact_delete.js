
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

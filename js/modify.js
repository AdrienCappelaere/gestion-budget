let checkBox = document.getElementById("switch");
let elemsIn = document.getElementsByClassName('2');
for (let i=0; i < elemsIn.length; i+=1){
    if (checkBox.checked == true){
        elemsIn[i].style.display = "block";
    } else {
        elemsIn[i].style.display = "none";
    }
}    

var url = window.location.href;
var id = url.substring(url.lastIndexOf('=') + 1);

var modalContainer = document.createElement('div');
modalContainer.setAttribute('id', 'modal'); 

var customBox = document.createElement('div');
customBox.className = 'custom-box';


// Affichage boîte de confirmation
document.getElementById('delete').addEventListener('click', function() {
    customBox.innerHTML = '<p class="del-box-txt">Voulez-vous vraiment supprimer cette transaction ? <br>Cette action est irréversible.</p>';
    customBox.innerHTML += '<button id="modal-close" class="btn-annuler">Annuler</button>';
    customBox.innerHTML += '<button id="modal-confirm" class="btn-confirmer">Confirmer</button>';
    modalShow();
});

function modalShow() {
    modalContainer.appendChild(customBox);
    document.body.appendChild(modalContainer);

    document.getElementById('modal-close').addEventListener('click', function() {
        modalClose();
    });

    if (document.getElementById('modal-confirm')) {
        document.getElementById('modal-confirm').addEventListener('click', function () {
           console.log('Confirmé !');
           window.location.href = `../controls/delete.php?id=${id}`;
           modalClose();
        });
    }
}

function modalClose() {
    while (modalContainer.hasChildNodes()) {
        modalContainer.removeChild(modalContainer.firstChild);
    }
    document.body.removeChild(modalContainer);
}
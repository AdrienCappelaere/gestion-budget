function get_type() {

    var checkBox = document.getElementById("switch");

    var elemsOut = document.getElementsByClassName('1');
    for (var i=0; i < elemsOut.length; i+=1){
        if (checkBox.checked == true){
            elemsOut[i].style.display = "none";
        } else {
            elemsOut[i].style.display = "block";
        }
    }

    var elemsIn = document.getElementsByClassName('2');
    if (checkBox.checked == true) {
        elemsIn[0].setAttribute('selected', true);
        elemsOut[0].removeAttribute('selected', true);
    } else {
        elemsOut[0].setAttribute('selected', true);
        elemsIn[0].removeAttribute('selected', true);
    }
    for (var i=0; i < elemsIn.length; i+=1){
        if (checkBox.checked == true){
            elemsIn[i].style.display = "block";

        } else {
            elemsIn[i].style.display = "none";
        }
    }    
}

function color_amount() {
    let amount = getElementsByClassName("trans-amount");
    if (amount > 0){
        amount.classList.add(".is-up");
    }
}

function hide_revenu_category() {
    let checkBox = document.getElementById("switch");
    let elemsIn = document.getElementsByClassName('2');
    for (let i=0; i < elemsIn.length; i+=1){
        if (checkBox.checked == true){
            elemsIn[i].style.display = "block";
        } else {
            elemsIn[i].style.display = "none";
        }
    }  
}
  
function set_date() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 

    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("datefield").setAttribute("max", today);
    document.getElementById("datefield").setAttribute("value", today);
}

function delete_control() {
    var url = window.location.href;
    var id = url.substring(url.lastIndexOf('=') + 1);

    var modalContainer = document.createElement('div');
    modalContainer.setAttribute('id', 'modal'); 

    var customBox = document.createElement('div');
    customBox.className = 'custom-box';

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
            window.location.href = `controls/delete_operation.php?id=${id}`;
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
}

function add_green() {
    let nbtrans = document.getElementsByName("amount");
    for (let i=0; i < nbtrans.length; i+=1){
        let text = document.getElementsByName("amount")[i].innerHTML;
        const num = Number(text.replace(/[^0-9\.-]+/g, ''));
        if (num > 0){
            nbtrans[i].classList.add("is-up");
        }
    }
}

function paidwith_selected() {
    var checkBox = document.getElementsByName("paid_with");
    var elemsOut = document.getElementsByClassName('paidwith-li');
    console.log(checkBox);
    console.log(elemsOut);
    for (var i=0; i < elemsOut.length; i+=1){
        if (checkBox[i].checked == true){
            elemsOut[i].classList.add("is-checked");
        } else {
            elemsOut[i].classList.remove("is-checked");
        }
    }
}

function get_tri() {
    var option = document.getElementsByName("option-tri");
    var url_string = window.location.href;
    var url = new URL(url_string);
    var param = url.searchParams.get("filtre");
    for (var i=0; i < option.length; i++) {
        if (option[i].value == "?filtre="+param) {
            option[i].setAttribute('selected', true);
    }
    }
}

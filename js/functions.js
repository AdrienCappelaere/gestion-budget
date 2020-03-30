function myFunction() {
    let element = document.getElementById("1");
    element.classList.add("is-hidden");
}

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
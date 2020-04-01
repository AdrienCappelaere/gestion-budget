let checkBox = document.getElementById("switch");
let elemsIn = document.getElementsByClassName('2');
for (let i=0; i < elemsIn.length; i+=1){
    if (checkBox.checked == true){
        elemsIn[i].style.display = "block";
    } else {
        elemsIn[i].style.display = "none";
    }
}    



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





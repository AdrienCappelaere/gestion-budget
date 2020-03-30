
let nbtrans = document.getElementsByName("amount");
for (let i=0; i < nbtrans.length; i+=1){
    let text = document.getElementsByName("amount")[i].innerHTML;
    console.log(text);
    const num = Number(text.replace(/[^0-9\.-]+/g, ''));
    console.log(num);
    if (num > 0){
        nbtrans[i].classList.add("is-up");
    }
}    

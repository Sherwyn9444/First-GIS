var modal = document.getElementsByClassName("modal")[0];
var content = document.getElementsByClassName("modal-content")[0];
var btn = document.getElementsByClassName("modal-open");

var span = document.createElement("span");
span.setAttribute("class","close");
span.innerHTML = "&times;";
content.insertBefore(span, content.firstChild);


function openModal(title,add = true){
    document.getElementById("modal-title").innerHTML = title;
    modal.style.display = "block";
    isAdd = add;
}


window.onclick = function(event){
    if(event.target == modal){
        modal.style.display = "none";
    }
}
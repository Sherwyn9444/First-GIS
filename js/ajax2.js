/*
$(document).ready(function(){
    $(a).click(function(){
        alert(this.id);
    });
});
*/
function loadPage(str){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        document.getElementById("main").innerHTML = this.responseText;
    };
    xhttp.open("GET",str+".php");
    xhttp.send();
    xhttp.close();
}
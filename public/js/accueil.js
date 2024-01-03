function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";

    document.getElementById("main").style.borderLeft = "1px solid gray";
    // le contour est imposé par le moteur bootsrap: donc on peut pas l'enlever
    // on va juste foncer un peu le bouton pour casser l' effet contour vide
    document.getElementById("openbtn").style.border = "none";
    document.getElementById("openbtn").style.background = "#111";
    document.getElementById("openbtn").style.color = "white";
}
function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

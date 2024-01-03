/******
 * Scroll contenu
 * Author: Andjib
 * Date: Samedi 07 Mars 2020
 */

window.onscroll = function () { scrollFunction(); myFunction(); }; /* Attention! i fo pas inverser l'ordre de ces fonction sinon sa marche pas */

var menu = document.getElementById("menu");
var positionInitiale = menu.offsetTop;

function myFunction() {
	if (window.pageYOffset > positionInitiale) {
		menu.classList.add("stickyNavbar");
		//sidbarG.classList.add("mySidebar");
	} else {
		menu.classList.remove("stickyNavbar");
		//sidbarG.classList.remove("mySidebar");
	}
}




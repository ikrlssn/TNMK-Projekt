//toggle showing help div
function showhelp() {
	var hlp = document.getElementById("helpcontent");
	if (hlp.style.display === "block"){
		hlp.style.display = "none";
	}
	else {
		hlp.style.display = "block";
	}
}
//toggle showing about div
function showabout() {
	var abt = document.getElementById("aboutcontent");
	if (abt.style.display === "block"){
		abt.style.display = "none";
	}
	else {
		abt.style.display = "block";
	}
}
//toggle showing sort div
function showsort() {
	document.getElementById("sortlist").classList.toggle("show");
}
//close the dropdown menu if the user clicks outside of it
//copied code from w3schools
window.onclick = function(event) {
	if (!event.target.matches('.dropbtn')) {
	  var dropdowns = document.getElementsByClassName("dropdown-content");
	  var i;
	  for (i = 0; i < dropdowns.length; i++) {
		var openDropdown = dropdowns[i];
		if (openDropdown.classList.contains('show')) {
		  openDropdown.classList.remove('show');
		}
	  }
	}
  }
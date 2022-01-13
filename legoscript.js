
function showhelp() {
	var hlp = document.getElementById("helpcontent");
	if (hlp.style.display === "block"){
		hlp.style.display = "none";
	}
	else {
		hlp.style.display = "block";
	}
}
function showabout() {
	var abt = document.getElementById("aboutcontent");
	if (abt.style.display === "block"){
		abt.style.display = "none";
	}
	else {
		abt.style.display = "block";
	}
}
function showsort() {
	document.getElementById("sortlist").classList.toggle("show");
}
// Close the dropdown menu if the user clicks outside of it
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
window.onscroll = function() {stickyfunction()};

var ontop = document.getElementById("ontopsticky");
var sticky = ontop.offsetTop;
function stickyfunction() {
  if (window.pageYOffset > sticky) {
    ontop.classList.add("sticky");
  } else {
    ontop.classList.remove("sticky");
  }
}



function navfunction() {
  var x = document.getElementById("navbar-ul");
  if (x.className === "navbar-ul") {
    x.className += " responsive";
  } else {
    x.className = "navbar-ul";
  }
}


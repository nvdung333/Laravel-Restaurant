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


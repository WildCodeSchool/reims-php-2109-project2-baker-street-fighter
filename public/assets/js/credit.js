  // Get the modal
  var modal = document.getElementById("antoineModal");
  var modal2 = document.getElementById("bilalModal");
  var modal3 = document.getElementById("clementModal");
  var modal4 = document.getElementById("jordanModal");
  var modal5 = document.getElementById("marjorieModal");
  var modal6 = document.getElementById("robinModal");
  var modal7 = document.getElementById("romainModal");
  var modal8 = document.getElementById("theoModal");
// Get the button that opens the modal
  var btn = document.getElementById("antoine");
  var btn2 = document.getElementById("bilal");
  var btn3 = document.getElementById("clement");
  var btn4 = document.getElementById("jordan");
  var btn5 = document.getElementById("marjorie");
  var btn6 = document.getElementById("robin");
  var btn7 = document.getElementById("romain");
  var btn8 = document.getElementById("theo");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close")[1];
  var span3 = document.getElementsByClassName("close")[2];
  var span4 = document.getElementsByClassName("close")[3];
  var span5 = document.getElementsByClassName("close")[4];
  var span6 = document.getElementsByClassName("close")[5];
  var span7 = document.getElementsByClassName("close")[6];
  var span8 = document.getElementsByClassName("close")[7];
// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}
  btn2.onclick = function() {
      modal2.style.display = "block";
  }
  btn3.onclick = function() {
      modal3.style.display = "block";
  }
  btn4.onclick = function() {
      modal4.style.display = "block";
  }
  btn5.onclick = function() {
      modal5.style.display = "block";
  }
  btn6.onclick = function() {
      modal6.style.display = "block";
  }
  btn7.onclick = function() {
      modal7.style.display = "block";
  }
  btn8.onclick = function() {
      modal8.style.display = "block";
  }
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
  span2.onclick = function() {
      modal2.style.display = "none";
  }
  span3.onclick = function() {
      modal3.style.display = "none";
  }
  span4.onclick = function() {
      modal4.style.display = "none";
  }
  span5.onclick = function() {
      modal5.style.display = "none";
  }
  span6.onclick = function() {
      modal6.style.display = "none";
  }
  span7.onclick = function() {
      modal7.style.display = "none";
  }
  span8.onclick = function() {
      modal8.style.display = "none";
  }
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
  window.onclick = function(event) {
      if (event.target == modal2) {
      modal2.style.display = "none";
      }
  }
  window.onclick = function(event) {
      if (event.target == modal3) {
      modal3.style.display = "none";
      }
  }
  window.onclick = function(event) {
      if (event.target == modal4) {
      modal4.style.display = "none";
      }
  }
  window.onclick = function(event) {
      if (event.target == modal5) {
      modal5.style.display = "none";
      }
  }
  window.onclick = function(event) {
      if (event.target == modal6) {
      modal6.style.display = "none";
      }
  }
  window.onclick = function(event) {
      if (event.target == modal7) {
      modal7.style.display = "none";
      }
  }
  window.onclick = function(event) {
      if (event.target == modal8) {
      modal8.style.display = "none";
      }
  }
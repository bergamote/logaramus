function tog_vis(div) {
  var state = document.getElementById(div).style;
  if(state.display == "block"){
    state.display = "none"; 
  } else {
    state.display = "block";
  }
}

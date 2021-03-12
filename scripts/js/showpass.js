var el = document.getElementById('check');
el.addEventListener("change", function(){
  let x = document.getElementById("pass1");
  let y = document.getElementById("pass2");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

  if (y.type === "password") {
      y.type = "text";
  } else {
      y.type = "password";
  }
}, false)


var el2 = document.getElementById('showpass');
el2.addEventListener("change", function(){
    let x = document.getElementById("pass");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}, false)
// function all() {

var frames = document.getElementsByClassName('case-img');

framesArr = [];
for (let frame of frames) {
  framesArr.push(frame);
}

framesArr[0].style.display = "block";

var initial = 1000;
var mspf = 80;
var stopTime = (mspf * framesArr.length) + (mspf / 2);

function open() {

  var i = 0;
  var frameInterval = setInterval(function () {

    if (i in framesArr) {
      framesArr[i].style.display = "block";

      if (i >= 1) {
        framesArr[i - 1].style.display = "none";
      }

      i++;
    } else {
      // i = 0;
      // framesArr[3].style.display = "none";
    }

  }, mspf);

  setTimeout(function () {
    clearInterval(frameInterval);
  }, stopTime + initial);

}

setTimeout(function () {
  open();
}, initial);


// }

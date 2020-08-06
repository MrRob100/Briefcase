var audio = document.querySelector('audio');

setTimeout(function () {
  audio.play();
}, 1500);


// var bod = document.querySelector('body');
// bod.onmouseover = function() {
//   audio.play();
// }

// navigator.getUserMedia(
//   'audio'
// )


//WITHOUT THE ELEMENT

// var isso = this;
// const AudioContext = window.AudioContext || window.webkitAudioContext;
// const audioCtx = new AudioContext();
// // this.ctx = audioCtx;
// // this.tunesFormatted = this.tunes.split(" ");

// const loopUrl = '../sites/default/files/tunes/bernardFC.mp3';

// const source = audioCtx.createBufferSource();

// var request = new XMLHttpRequest();
// request.open('GET', loopUrl, true);
// request.responseType = 'arraybuffer';

// request.onload = function () {
//   var audioData = request.response;

//   audioCtx.decodeAudioData(audioData, function (buffer) {
//       var myBuffer = buffer;
//       source.buffer = myBuffer;
//       source.connect(audioCtx.destination);
//       isso.initSource = source;
//       // source.start();

//     },
//     function (e) {
//       "Error decoding audio data"
//     });
// }

// request.send();

// setTimeout(function() {
//   // console.log(source);
//   source.start(0, 1);
// }, 2000);
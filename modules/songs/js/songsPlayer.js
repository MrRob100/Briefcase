window.addEventListener('load', function () {

    var i = 0;
    newAudio(i, "audio/mpeg");

});

function newAudio(i, type) {

    var list = document.getElementsByClassName('list-item-song');

    var toPlay = list[i].dataset.fn;
    list[i].classList.add('playing');

    // var type = "audio/mpeg";

    var url = document.getElementById("audio-container").dataset.url;

    var src = url + "/sites/default/files/songs/" + toPlay;

    var ae = document.createElement("audio");
    ae.setAttribute("type", type);
    ae.setAttribute("controls", "");
    ae.setAttribute("autoplay", "");
    ae.setAttribute("src", src);

    document.getElementById("audio-container").appendChild(ae);

    var audio = document.querySelector("audio");


    for (let item of list) {
        item.onclick = function () {
            ae.setAttribute("src", url + "/sites/default/files/songs/" + item.dataset.fn);
            item.classList.add('playing');
        }
    }

    audio.onended = function () {

        list[i].classList.remove('playing');

        i = i + 1;

        /* playing highlighted */
        list[i].classList.add('playing');

        var toPlay2 = list[i].dataset.fn;

        var src2 = document.getElementById("audio-container").dataset.url + "/sites/default/files/songs/" + toPlay2;
        ae.setAttribute("src", src2);
    }

    function playclicked(songname) {
        console.log('play', songname);
    }

}





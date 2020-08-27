window.addEventListener('load', function () {

    var i = 0;
    newAudio(i, "audio/mpeg");
    buttonLogic();

});

function newAudio(i, type) {

    var list = document.getElementsByClassName('list-item-song');

    var toPlay = list[i].dataset.fn;
    list[i].classList.add('playing');
    list[i].setAttribute("data-playing", true);

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

    var inc = 0;
    for (let item of list) {

        /* sets all i's */
        item.setAttribute("data-i", inc);

        item.onclick = function () {

            /** sorts out playing class */
            getPlaying().classList.remove('playing');
            item.classList.add('playing');

            ae.setAttribute("src", url + "/sites/default/files/songs/" + item.dataset.fn);

            wasplaying = getPlaying().setAttribute("data-playing", "false");

            item.setAttribute("data-playing", "true");
        }

        inc++;
    }

    audio.onended = function () {

        /* run button logic */
        buttonLogic();

        /* find item thats playing then add 1 to it */
        var item = getPlaying();
        var i = parseInt(item.dataset.i);

        /* remove playing data attribute from it */
        item.setAttribute("data-playing", "false");

        /* add playing data attribute to new */
        list[i + 1].setAttribute("data-playing", "true");

        /* playing highlighted */
        list[i].classList.remove('playing');
        list[i + 1].classList.add('playing');

        var toPlay2 = list[i + 1].dataset.fn;

        var src2 = document.getElementById("audio-container").dataset.url + "/sites/default/files/songs/" + toPlay2;
        ae.setAttribute("src", src2);
    }

    function getPlaying() {
        var list = document.getElementsByClassName('list-item-song');
        for (let item of list) {
            if (item.dataset.playing == "true") {
                return item;
            }
        }

    }

}

/**
 * overlay button
 */

function buttonLogic() {

    var rplay = document.getElementById("r-play");
    var rstop = document.getElementById("r-stop");

    var audio = document.querySelector("audio");

    setInterval(function() {

        if (!audio.paused) {
            //playing
            rplay.style.display = "none";
            rstop.style.display = "block";

        } else {
            //not playing
            rplay.style.display = "block";
            rstop.style.display = "none";
        }

    }, 1000);


    rplay.onclick = function() {
        audio.play();
        rplay.style.display = "none";
        rstop.style.display = "block";
    }

    rstop.onclick = function() {
        audio.pause();
        rplay.style.display = "block";
        rstop.style.display = "none";
    }
}








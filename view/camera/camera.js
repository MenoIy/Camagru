const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const img1 = document.getElementById('setImage1');
const img2 = document.getElementById('setImage2');
const img3 = document.getElementById('setImage3');
const noImg = document.getElementById('noImage');
const save = document.getElementById('save');





function takePreview(img) {
    var context = canvas.getContext('2d');
    canvas.width = 500;
    canvas.height = 500;
    context.drawImage(video, 0, 0, 500, 500);
    var data = canvas.toDataURL('image/png');
    console.log(img);
    if (img)
        context.drawImage(img, 100, 100, 100, 100);
    save.addEventListener('click', function () {
        var element = document.getElementById('data');
        var superpos = document.getElementById('superpos');
        superpos.value = '0';
        element.value = data;
        superpos.form.submit();
        element.form.submit();
    });
}




function startup() {
    navigator.mediaDevices.getUserMedia({
        audio: false,
        video: true
    }).then(stream => {

        video.srcObject = stream;
        video.play();
    }).catch(console.error);
}
video.addEventListener('canplay', function () {
    video.setAttribute('width', 500);
    video.setAttribute('height', 500);
    canvas.setAttribute('width', 500);
    canvas.setAttribute('height', 500);
});
window.addEventListener('load', startup, false);

img1.addEventListener('click', function () {
    var element = document.getElementById("1");
    takePreview(element);
});
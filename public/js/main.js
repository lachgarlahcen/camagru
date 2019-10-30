var video = document.getElementById('video');
var snap = document.getElementById('snap');
var canvas = document.getElementById('canvas');

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        //video.src = window.URL.createObjectURL(stream);
        video.srcObject = stream;
        video.play();
    });
}

var context = canvas.getContext('2d');
snap.addEventListener("click", function() {
    context.drawImage(video, 0, 0);
    canvas.style.display = 'block';
});
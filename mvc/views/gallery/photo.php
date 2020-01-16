<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row flex-fill d-flex justify-content-between">
    <div class="col ">
        <div class="row m-2 w-100 h-40">
            <div class="col">
                <div class="card text-center h-100">
                    <video id='video' class="card-img-top">
                    </video>
                    <div class="card-body">
                        <button id='snap' class="btn btn-orange lighten-1">Take Photo!</button>
                        <button class="btn btn-orange lighten-1  " onclick="document.getElementById('file').click();">
                            <span>Choose files</span>
                            <input type="file" accept="image/x-png,image/gif,image/jpeg" style="display:none;" id="file"
                                name="file" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-2 w-100 h-40">
            <div class="col">
                <div class="card text-center h-100">
                    <canvas id='canvas' class="card-img-top "> </canvas>

                    <div class="card-body">
                        <div class="row  text-center justify-content-center" id="drag-items">
                            <div class="col-md-2 col-4">
                                <img id="1" src="<?php echo URLROOT; ?>/public/img/1.png" class="img-fluid"
                                    draggable="true">
                            </div>
                            <div class="col-md-2 col-4">
                                <img id="2" src="<?php echo URLROOT; ?>/public/img/2.png" class="img-fluid"
                                    draggable="true">
                            </div>
                            <div class="col-md-2 col-4">
                                <img id="3" src="<?php echo URLROOT; ?>/public/img/3.png" class="img-fluid"
                                    draggable="true">
                            </div>
                            <div class="col-md-2 col-4">
                                <img id="4" src="<?php echo URLROOT; ?>/public/img/4.png" class="img-fluid"
                                    draggable="true">
                            </div>
                        </div>
                        <div class="row no-gutters text-center justify-content-center">
                            <button id='upload' class="btn btn-orange lighten-1">UPLOAD PIC</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col">
        somthing
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
var video = document.getElementById('video');
var snap = document.getElementById('snap');
var canvas = document.getElementById('canvas');
var upload = document.getElementById('upload');
var context = canvas.getContext('2d');
var info = {
    photo: {
        data: null,
        w: null,
        h: null,
    },
    stickers: new Array()
};
/* ****
Drag and drop functions
*******/
function getMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect();
    return {
        x: evt.clientX - rect.left,
        y: evt.clientY - rect.top
    };
}



// what is url of dragging element?
var item;
document
    .getElementById('drag-items')
    .addEventListener('dragstart', function(e) {
        item = e.target;
    });

canvas.addEventListener('dragover', function(e) {
    e.preventDefault(); // !important
});

canvas.addEventListener('drop', function(e) {
    var pos = getMousePos(canvas, e);
    e.preventDefault();
    context.drawImage(item, pos.x + 50, pos.y + 50,
        150, 150);
    var sticker = {
        id: item.id,
        x: pos.x + 50,
        y: pos.y + 50
    };
    info.stickers.push(sticker);
});
/* ****
Drag and drop functions
*******/

// Get access to the camera!
if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({
        video: true
    }).then(function(stream) {
        //video.src = window.URL.createObjectURL(stream);
        video.srcObject = stream;
        video.play();
    });
}


upload.addEventListener("click", function() {
    //console.log(JSON.stringify(info));
    $.ajax({
        type: 'POST',
        url: '/gallery/photo/',
        dataType: 'text',
        data: {
            data: JSON.stringify(info)
        },
        processData: true,
        success: function(data) {
            console.log(data);
        },
        error: function(request, status, error) {
            alert(error);
        }
    });
});

snap.addEventListener("click", function() {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
    info.photo.data = canvas.toDataURL("image/png");
    info.photo.w = video.videoWidth;
    info.photo.h = video.videoHeight;
});
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
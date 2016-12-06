(function()
{
	var streaming 	 = false,
			video        = document.querySelector('#video'),
			cover        = document.querySelector('#cover'),
			canvas       = document.querySelector('#canvas'),
			photo        = document.querySelector('#photo'),
			startbutton  = document.querySelector('#startbutton'),
			width				 = 500,
			height			 = 0;

// // // // // // // // // // // // // // // // // // // // // // // // // // //
//                           BROWSERS COMPATIBILITY:
// This feature allows operations to work on every browsers, isn't it awesome ?
// // // // // // // // // // // // // // // // // // // // // // // // // // //

navigator.getMedia = ( navigator.getUserMedia ||
										 	 navigator.webkitGetUserMedia ||
										 	 navigator.mozGetUserMedia ||
										 	 navigator.msGetUserMedia);
navigator.getMedia(
{
    video: true,
    audio: false,
},

function(stream)
{
	if (navigator.mozGetUserMedia)
		video.mozSrcObject = stream;
	else
	{
		var vendorURL = window.URL || window.webkitURL || window.mozURL || window.msURL;
		video.src = vendorURL.createObjectURL(stream);
	}
	video.play();
},

function(err)
{
	console.log("An error occured! " + err);
}
);

video.addEventListener('canplay', function(ev)
{
	if (!streaming)
	{
		height = video.videoHeight / (video.videoWidth/width);
		video.setAttribute('width', width);
		video.setAttribute('height', height);
		canvas.setAttribute('width', width);
		canvas.setAttribute('height', height);
		streaming = true;
	}
}
, false);

// // // // // // // // // // // // // // // // // // // // // // // // // // //
//                              TAKE A PICTURE:
// This part is simply used to take a photo of the video flux displayed on the
// screen.
// The last two functions serve to start the taking of the photo. One by using
// the keyboard, the other with a clickable button.
// // // // // // // // // // // // // // // // // // // // // // // // // // //

	function takepicture()
	{
		canvas.width = width;
		canvas.height = height;
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		var data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);

		document.getElementById('hidden_data').value = data;
		var fd = new FormData(document.forms["form1"]);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'img_post.php', true);
		xhr.upload.onprogress = function(e)
		{
			if (e.lengthComputable)
				var percentComplete = (e.loaded / e.total) * 100;
		};
		xhr.onload = function() {};
		xhr.send(fd);
	}

	// Trigger //
	startbutton.addEventListener('click', function(ev)
	{
		if (streaming == true)
		{
			takepicture();
			ev.preventDefault();
		}
		location.reload();
		
	}
	, false);
	// Trigger off //

}
)();

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Detection</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="camera-container">
        <video id="video" autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <button id="capture-btn">Capture</button>
    </div>

 <script>
    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture-btn');

        // Get user media
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                video.srcObject = stream;
            })
            .catch(function(err) {
                console.error('Error accessing webcam: ', err);
            });

        // Capture image
        captureBtn.addEventListener('click', function() {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            console.log('Image captured');
            const imageData = canvas.toDataURL('image/jpeg');

            // Send captured image to server
            fetch('process_image.php', {
                method: 'POST',
                body: JSON.stringify({ image: imageData }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    console.log('Image saved successfully');
                } else {
                    console.error('Error saving image:', data.error);
                }

                // console.log('Response from server:', data);
            })
            .catch(function(error) {
                console.error('Error sending image to server: ', error);
            });
        });
    });

 </script>
</body>
</html>

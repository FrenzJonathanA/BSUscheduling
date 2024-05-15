const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const captureBtn = document.getElementById('capture-btn');
const loginBtn = document.getElementById('login-btn');
const registerBtn = document.getElementById('register-btn');

let stream;

// Request access to the camera
navigator.mediaDevices.getUserMedia({ video: true, audio: false })
   .then(stream => {
        video.srcObject = stream;
        stream.getTracks()[0].enabled = true;
    })
   .catch(error => console.error('Error accessing camera:', error));

// Capture face image
captureBtn.addEventListener('click', () => {
    canvas.getContext('2d').drawImage(video, 0, 0, 640, 480);
    const faceImage = canvas.toDataURL('image/jpeg');
    // Send face image to backend API for processing
    fetch('/capture', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ faceImage })
    })
       .then(response => response.json())
       .then(data => console.log(data))
       .catch(error => console.error('Error capturing face:', error));
});

// Login
loginBtn.addEventListener('click', () => {
    // Send face image to backend API for login
    fetch('/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ faceImage })
    })
       .then(response => response.json())
       .then(data => console.log(data))
       .catch(error => console.error('Error logging in:', error));
});

// Register
registerBtn.addEventListener('click', () => {
    // Send face image to backend API for registration
    fetch('/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ faceImage })
    })
       .then(response => response.json())
       .then(data => console.log(data))
       .catch(error => console.error('Error registering:', error));
});
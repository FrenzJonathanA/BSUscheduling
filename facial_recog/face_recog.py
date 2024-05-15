import cv2
import numpy as np
import base64
import json

def detect_faces(image_data):
    # Decode base64 image data
    decoded_data = base64.b64decode(image_data.split(',')[1])
    nparr = np.frombuffer(decoded_data, np.uint8)
    
    # Read image from numpy array
    image = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
    
    # Load face detection cascade
    face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
    
    # Convert image to grayscale
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    
    # Detect faces in the grayscale image
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))
    
    # Draw rectangles around the detected faces
    for (x, y, w, h) in faces:
        cv2.rectangle(image, (x, y), (x+w, y+h), (255, 0, 0), 2)
    
    # Encode image to base64 for sending back to PHP
    _, encoded_image = cv2.imencode('.jpg', image)
    encoded_image_data = base64.b64encode(encoded_image).decode('utf-8')
    
    return encoded_image_data

if __name__ == "__main__":
    # Read image data from stdin
    image_data = input()
    
    # Detect faces and encode image
    result_image = detect_faces(image_data)
    
    # Print result image data
    print(json.dumps({'image_data': result_image}))

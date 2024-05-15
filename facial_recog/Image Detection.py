# #IMPORT
# import cv2 as cv
# import numpy as np
# import os
# os.environ['TF_CPP_MIN_LOG_LEVEL']='2'
# import tensorflow as tf
# from sklearn.preprocessing import LabelEncoder
# import pickle
# from keras_facenet import FaceNet

# #INITIALIZE
# facenet = FaceNet()
# faces_embeddings = np.load('Members.npz')
# Y = faces_embeddings['arr_1']
# encoder = LabelEncoder()
# encoder.fit(Y)
# haarcascade = cv.CascadeClassifier("haarcascade_frontalface_default.xml")
# model = pickle.load(open("SVM_Model.pkl", 'rb'))

# # Load the image
# image_path = "./frenz1.jpg"
# image = cv.imread(image_path)

# rgb_img = cv.cvtColor(image, cv.COLOR_BGR2RGB)
# gray_img = cv.cvtColor(image, cv.COLOR_BGR2GRAY)
# faces = haarcascade.detectMultiScale(gray_img, 1.3, 5)

# for x,y,w,h in faces:
#     img = rgb_img[y:y+h, x:x+w]
#     img = cv.resize(img, (160,160)) # 1x160x160x3
#     img = np.expand_dims(img,axis=0)
#     ypred = facenet.embeddings(img)
#     face_name = model.predict(ypred)
#     final_name = encoder.inverse_transform(face_name)[0]
#     cv.rectangle(image, (x,y), (x+w,y+h), (0,255,0), 10) # Change color to green
#     cv.putText(image, str(final_name), (x,y-10), cv.FONT_HERSHEY_SIMPLEX,
#                1, (0,0,255), 3, cv.LINE_AA)

# cv.imshow("Face Recognition:", image)
# cv.waitKey(0)
# cv.destroyAllWindows()

import cv2

# Initialize the camera
cap = cv2.VideoCapture(0)

# Set the resolution
cap.set(cv2.CAP_PROP_FRAME_WIDTH, 640)
cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 480)

# Initialize the image and flag to capture the image
image = None
capture_image = False

while True:
    # Read the frame from the camera
    ret, frame = cap.read()

    # Display the frame
    cv2.imshow('frame', frame)

    # Check if the user pressed the 'space' key to capture the image
    if cv2.waitKey(1) & 0xFF == ord(' '):
        capture_image = True

    # If the user pressed the 'q' key, break the loop
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

    # If the user pressed the 'c' key, capture the image
    if capture_image:
        image = frame
        capture_image = False

    # If the image is captured, break the loop
    if image is not None:
        break

# Release the camera
cap.release()

# Destroy all windows
cv2.destroyAllWindows()

# Save the image to a file
cv2.imwrite('user_image.jpg', image)
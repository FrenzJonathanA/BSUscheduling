import cv2
import json
import mysql.connector


# Connect to the MySQL database
conn = mysql.connector.connect(
    host="localhost",  # Change this if your MySQL server is hosted elsewhere
    user="root",       # Replace with your MySQL username
    password="",       # Replace with your MySQL password
    database="BSUscheduling_db"  # Replace with your database name
)

# Create a cursor object
cursor = conn.cursor()

# Create the users table
#alter_query = "ALTER TABLE user ADD COLUMN face_image VARCHAR(255)"
#cursor.execute(alter_query)

# Commit the changes and close the connection
conn.commit()
# conn.close()

# Load the face detection cascade
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + "haarcascade_frontalface_default.xml")

# Open the default camera
cap = cv2.VideoCapture(0)

# Prompt the user to capture an image
print('Press "c" to capture the image')

while True:
    # Read a frame from the camera
    ret, frame = cap.read()
    
    # Convert the frame to grayscale
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    
    # Detect faces in the grayscale image
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))
    
    # Draw a rectangle around the detected face
    for (x, y, w, h) in faces:
        cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
    
    # Display the output
    cv2.imshow('Face Detection', frame)
    
    # Press "c" to capture the image
    if cv2.waitKey(1) & 0xFF == ord('c'):
        cv2.imwrite('captured_image.jpg', frame)
        break

# Release the camera and close the window
cap.release()
cv2.destroyAllWindows()

def save_user_profile(user_profile):
    """Save the user profile to a file or database."""
    # Save the user profile to a file
    with open('user_profile.json', 'w') as f:
        json.dump(user_profile, f)

    # Save the user profile to a database (using SQLite as an example)
    import sqlite3
    conn = sqlite3.connect('users.db')
    c = conn.cursor()
    c.execute('INSERT INTO users (face_image) VALUES (?)', (user_profile['face_image'],))
    conn.commit()
    conn.close()

# Save the captured image to the user's profile
user_profile = {'face_image': 'captured_image.jpg'}
save_user_profile(user_profile)


# import cv2
# import json

# # Load the face detection cascade
# face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + "haarcascade_frontalface_default.xml")

# # Open the default camera
# cap = cv2.VideoCapture(0)

# # Prompt the user to capture an image
# print('Press "c" to capture the image')

# while True:
#     # Read a frame from the camera
#     ret, frame = cap.read()
    
#     # Convert the frame to grayscale
#     gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    
#     # Detect faces in the grayscale image
#     faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))
    
#     # Draw a rectangle around the detected face
#     for (x, y, w, h) in faces:
#         cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
    
#     # Display the output
#     cv2.imshow('Face Detection', frame)
    
#     # Press "c" to capture the image
#     if cv2.waitKey(1) & 0xFF == ord('c'):
#         cv2.imwrite('captured_image.jpg', frame)
#         break

# # Release the camera and close the window
# cap.release()
# cv2.destroyAllWindows()

# def save_user_profile(user_profile):
#     """Save the user profile to a file or database."""
#     # Save the user profile to a file
#     with open('user_profile.json', 'w') as f:
#         json.dump(user_profile, f)

#     # Save the user profile to a database (using SQLite as an example)
#     import sqlite3
#     conn = sqlite3.connect('users.db')
#     c = conn.cursor()
#     c.execute('INSERT INTO users (face_image) VALUES (?)', (user_profile['face_image'],))
#     conn.commit()
#     conn.close()

# # Save the captured image to the user's profile
# user_profile = {'face_image': 'captured_image.jpg'}
# save_user_profile(user_profile)

# import cv2

# # Load the face detection cascade
# face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + "haarcascade_frontalface_default.xml")

# # Open the default camera
# cap = cv2.VideoCapture(0)

# while True:
#     # Read a frame from the camera
#     ret, frame = cap.read()
    
#     # Convert the frame to grayscale
#     gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    
#     # Detect faces in the grayscale image
#     faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))
    
#     # Draw a rectangle around the detected face
#     for (x, y, w, h) in faces:
#         cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
    
#     # Display the output
#     cv2.imshow('Face Detection', frame)
    
#     # Print instructions
#     print('Press "c" to capture the image')
    
#     # Press "c" to capture the image
#     if cv2.waitKey(1) & 0xFF == ord('c'):
#         cv2.imwrite('captured_image.jpg', frame)
#         break

# # Release the camera and close the window
# cap.release()
# cv2.destroyAllWindows()
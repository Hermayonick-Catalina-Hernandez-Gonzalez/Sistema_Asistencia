import cv2
import os
import imutils

personName = "Prueba"                      
#Url donde se encuetra las imagenes de los usuarios
dataPath = "c:/Users/herca/OneDrive/Documentos/Lista de asistencia Final/Sistemas-Inteligentes/Face detection/Data"
personPath = dataPath + '/' + personName

if not os.path.exists(personPath):
    print("Creando carpeta")
    os.makedirs(personPath)

# Ip del esp-32
url='http://192.168.0.69/1024x768.jpg'

cap = cv2.VideoCapture(url)
#cap = cv2.VideoCapture(2)

faceClassif = cv2.CascadeClassifier(cv2.data.haarcascades + "haarcascade_frontalface_default.xml")
count = 0

while cap.isOpened():
    cap.open(url)
    ret, frame = cap.read()
    if ret == False:
        break
    
    frame = imutils.resize(frame, width=320)
    gray = cv2.cvtColor(frame, 6)
    
    auxFrame = frame.copy()

    faces = faceClassif.detectMultiScale(gray, 1.3, 5)

    for (x, y, w, h) in faces:
        cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
        rostro = auxFrame[y:y + h, x:x + w]
        rostro = cv2.resize(rostro, (720, 720), interpolation=cv2.INTER_CUBIC)
        cv2.imwrite(personPath + '/rostro_{}.jpg'.format(count), rostro)
        count = count + 1
    
    cv2.imshow('frame', frame)

    if cv2.waitKey(1) == 27 or count >= 300:
        break

cap.release()
cv2.destroyAllWindows()
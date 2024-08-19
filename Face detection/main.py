import cv2
import os
from cv2 import face

# Ruta donde se encuentran las imágenes de los usuarios
dataPath = "c:/Users/herca/OneDrive/Documentos/Lista de asistencia Final/Sistemas-Inteligentes/Face detection/Data"
imagePath = os.listdir(dataPath)

print('Imágenes: ', imagePath)

face_recognizer = face.LBPHFaceRecognizer_create()
face_recognizer.read('Modelo_Rostros_2024.xml')

cap = cv2.VideoCapture(0)

faceClassif = cv2.CascadeClassifier(cv2.data.haarcascades + "haarcascade_frontalface_default.xml")

while cap.isOpened():
    ret, frame = cap.read()
    if not ret:
        print("Error al capturar la imagen")
        break

    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    auxFrame = gray.copy()

    faces = faceClassif.detectMultiScale(gray, 1.3, 5)

    for (x, y, w, h) in faces:
        rostro = auxFrame[y:y + h, x:x + w]
        rostro = cv2.resize(rostro, (720, 720), interpolation=cv2.INTER_CUBIC)
        result = face_recognizer.predict(rostro)

        cv2.putText(frame, '{}'.format(result), (x, y-5), 1, 1.3, (255, 255, 0), 1, cv2.LINE_AA)

        if result[1] < 25:
            cv2.putText(frame, '{}'.format(imagePath[result[0]]), (x, y-25), 2, 1.1, (0, 255, 0), 1, cv2.LINE_AA)
            cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
        else:
            cv2.putText(frame, 'Desconocido', (x, y-20), 2, 0.8, (0, 0, 255), 1, cv2.LINE_AA)
            cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 0, 255), 2)

    cv2.imshow('Ventana', frame)

    if cv2.waitKey(1) == 27:
        break

cap.release()
cv2.destroyAllWindows()

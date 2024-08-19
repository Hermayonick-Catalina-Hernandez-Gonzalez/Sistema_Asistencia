import cv2
import numpy as np

# URL de la cámara ESP32-CAM
url='http://192.168.0.69/1024x768.mjpg'

# Abrir la cámara del ESP32-CAM
print("Intentando abrir la cámara en la URL:", url)
cap = cv2.VideoCapture(url)

if not cap.isOpened():
    print("Error al abrir la cámara. Verifica la URL y la conexión.")
else:
    print("Cámara abierta correctamente")

while cap.isOpened():
    ret, frame = cap.read()
    if not ret:
        print("Error al capturar la imagen. Ret:", ret)
        break

    # Verifica las dimensiones del frame
    if frame is not None:
        print("Dimensiones del frame:", frame.shape)
    else:
        print("El frame es None")

    cv2.imshow('ESP32-CAM', frame)

    if cv2.waitKey(1) == 27:  # Presiona 'Esc' para salir
        print("Cerrando la ventana.")
        break

cap.release()
cv2.destroyAllWindows()

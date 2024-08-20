<a name="readme-top"></a>

# Sistema Escolar de Control de Asistencia mediante el uso de tecnología RFID

<!-- TABLE OF CONTENTS -->
<details>
    <summary>Tabla de Contenidos</summary>
    <ol>
        <li>
            <a href="#about-the-project">About The Project</a>
            <ul>
                <li>
                    <a href="#abstract">Abstract</a>
                </li>
                <li>
                    <a href="#resumen">Resumen</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#introducción">Introducción</a>
        </li>
        <li>
            <a href="#desarrollo">Desarrollo</a>
            <ul>
                <li>
                    <a href="#materiales">Materiales</a>
                </li>
                <li>
                    <a href="#circuito-de-pase-de-lista">Circuito de Pase de Lista</a>
                </li>
                <li>
                    <a href="#base-de-datos-y-backend">Base de Datos y Backend</a>
                </li>
                <li>
                    <a href="#sistema-web">Sistema Web</a>
                </li>
            </ul>
        </li>
        <li><a href="#conclusiones">Conclusiones</a></li>
    </ol>
</details>




## About the Project

### Abstract

*The School Attendance Control System developed for the Information Technology career at the Polytechnic University of Victoria represents an advanced solution for the efficient management of academic attendance. This project comprises a physical circuit, a structured database and an interactive web system. The physical circuit allows for roll call via RFID cards or manual entry of the student's control number, providing clear visual feedback via an RGB LED and LCD display. The database and web system, differentiated for teachers and students, offers advanced tools for graphical visualization, editing and group management by teachers, as well as transparent access to attendance records for students.*


### Resumen

*El Sistema Escolar de Control de Asistencia desarrollado para la carrera de Tecnologías de la Información en la Universidad Politécnica de Victoria representa una solución avanzada para la gestión eficiente de la asistencia académica. Este proyecto abarca un circuito físico, una base de datos estructurada y un sistema web interactivo. El circuito físico permite la toma de lista mediante tarjetas RFID o la introducción manual del número de control del alumno, ofreciendo una retroalimentación visual clara a través de un LED RGB y una pantalla LCD. La base de datos y el sistema web, diferenciado para profesores y estudiantes, ofrece herramientas avanzadas para la visualización gráfica, edición y administración de grupos por parte de los profesores, así como acceso transparente a los registros de asistencia para los estudiantes.*


<p align="right">(<a href="#readme-top">back to top</a>)</p>


## Introducción

En un entorno educativo en constante evolución, la gestión eficiente del control de asistencia se vuelve esencial para garantizar un seguimiento preciso del rendimiento académico de los estudiantes. El presente proyecto se propone diseñar e implementar un Sistema Integral de Pase de Lista para los grupos de la carrera de Tecnologías de la Información en la Universidad Politécnica de Victoria. A partir de los conocimientos adquiridos en la clase de Sistemas Embebidos . Este sistema no solo automatizará el proceso de toma de lista, sino que también proporcionará herramientas tanto al profesor como al alumno para visualizar y gestionar su asistencia de manera efectiva.

El sistema consta de un circuito físico que permitirá el pase de lista mediante tarjetas RFID o la digitación del número de control del alumno. Además, se incorporarán indicadores visuales, como un LED RGB y una pantalla LCD, para informar al estudiante sobre el estado de su toma de lista. En adición, se desarrollará un sistema web con funcionalidades diferenciadas para profesores y alumnos.

Por un lado, el profesor contará con herramientas avanzadas, tales como visualización gráfica del pase de lista, capacidad de edición, administración de grupos y cálculo del porcentaje de asistencia por alumno. Por otro lado, el alumno podrá acceder fácilmente a sus registros de asistencia.

El proyecto no solo busca optimizar la eficiencia de la toma de lista, sino que también aspira a mejorar la comunicación entre profesores y alumnos mediante el acceso rápido y transparente a la información relevante. A continuación, se detalla el diseño y desarrollo de cada componente, así como los resultados obtenidos durante la implementación de este Sistema Integral de Pase de Lista.


<p align="right">(<a href="#readme-top">back to top</a>)</p>


## Desarrollo

El término clave de este proyecto es Radio Frequency Identification (RFID). La tecnología  RFID consiste en una serie de dispositivos denominados etiquetas, tarjetas o tags RFID que permiten el almacenamiento y recuperación de datos. El objetivo primero de la tecnología RFID es transmitir la identidad de un objeto mediante peticiones por radiofrecuencia desde un emisor-receptor de la señal. Es gracias a este comportamiento que es posible idear un sistema de transmisión de identidad para el control del acceso de los alumnos a su institución educativa.

### Materiales

- Microcontrolador ESP32
- Módulo RFID
- LED
- Resistencia 220 ohms.
- Pantalla LCD

1. **Microcontrolador ESP32**

> El módulo ESP32 es un microcontrolador con un módulo integrado de Wi-Fi/Bluetooth todo en uno, integrado y certificado que proporciona no solo la radio inalámbrica, sino también un procesador integrado con interfaces para conectarse con varios periféricos.

2. **Módulo RFID**

> El módulo RFID RC522 es un lector de tarjetas inteligentes que, entre otras cosas, permite activar un mecanismo cuando se presenta la tarjeta adecuada al lector.

3. **LED**

> LED, el cual es utilizado para mostrar estados del sistema, como errores, falla en la conexión a internet y demás.

4. **Pantalla LCD**

> La pantalla es un recurso que permite comunicar al usuario que valores debe ingresar y le permite conocer la respuesta que el servidor devuelve.


### Circuito de Pase de Lista

El componente físico del sistema se basa en un circuito diseñado para facilitar la toma de lista a través de tarjetas RFID o la introducción manual del número de control del alumno. El diseño incluye un LED RGB para indicar visualmente el resultado del proceso: verde para éxito, rojo para fallo y morado en caso de problemas de conexión a la base de datos u otros inconvenientes.

Se incorpora una pantalla LCD para proporcionar retroalimentación directa al alumno, mostrando mensajes relacionados con su estado de pase de lista. Este componente físico actúa como interfaz tangible entre el estudiante y el sistema.

A continuación se presenta el diseño del circuito en Fritzing:

[![Circuit Diagram][circuit-diagram]](./images/PROYECTO.png)

### Base de Datos y Backend

La base de datos se estructura para almacenar información clave, como datos de estudiantes, registros de asistencia y configuraciones del profesor. Se utiliza un diseño relacional para garantizar la integridad de los datos y facilitar las consultas.

El backend del sistema se encarga de gestionar las solicitudes desde el circuito físico y la interfaz web. Los códigos de script de backend están diseñados para interactuar eficientemente con la base de datos, garantizando la actualización precisa de los registros de asistencia. A continuación, se presenta el diagrama de la base de datos:

[![DataBase Diagram][db-diagram]](./images/assistance.png)

### Sistema Web

El sistema web se divide en dos roles principales: **Profesor** y **Alumno**.

#### Profesor

- **Visualización Gráfica:** El profesor tiene acceso a gráficas grupales y por alumno que representan el historial de asistencia.
- **Edición de Pase de Lista:** Se implementa una función que permite al profesor editar los registros de asistencia cuando sea necesario.
- **Administración de Grupos:** Cada profesor puede gestionar diferentes clases en diversos horarios.
- **Cálculo de Porcentaje de Asistencia:** La plataforma realiza automáticamente el cálculo del porcentaje de asistencia por alumno.

#### Alumno

- **Visualización de Registros:** Los alumnos pueden acceder a sus registros de asistencia, lo que proporciona transparencia y autoevaluación.

El código de script del frontend se integra con el backend para garantizar la coherencia y la eficiencia en la comunicación.

El desarrollo del proyecto se ha llevado a cabo de manera integral, asegurando la coherencia y la eficacia en cada componente. A continuación, se presentan las conclusiones obtenidas durante el proceso de implementación.


<p align="right">(<a href="#readme-top">back to top</a>)</p>


## Conclusiones

El desarrollo del Sistema Integral de Pase de Lista representa un paso significativo hacia la modernización y eficiencia en la gestión académica en la Universidad Politécnica de Victoria. A partir de la culminación de este proyecto, se derivan las siguientes conclusiones:

1. **Mejora en la Eficiencia Operativa:** Con la automatización de la toma de lista se espera mejorar la eficiencia operativa en las actividades diarias de los profesores.

2. **Fortalecimiento de la Transparencia:** La disponibilidad de registros de asistencia en tiempo real para estudiantes fortalecería la transparencia en el proceso educativo. Los alumnos pueden monitorear y asumir la responsabilidad de su propia asistencia.

3. **Flexibilidad y Adaptabilidad:** El diseño escalable del sistema proporciona flexibilidad para adaptarse a cambios en la estructura académica, nuevos requerimientos o futuras expansiones. Esto asegura que el sistema mantenga su utilidad a lo largo del tiempo.

4. **Facilitador de Análisis Académico:** La capacidad del sistema para generar gráficas de asistencia y calcular porcentajes de asistencia proporciona a los profesores herramientas valiosas para realizar análisis académicos más profundos, identificar patrones y mejorar la calidad de la enseñanza.

Para finalizar, el Sistema Integral de Pase de Lista cuenta con el potencial para ser una herramienta valiosa con el objetivo de optimizar la gestión de la asistencia en el ámbito académico. Su implementación sentaría las bases para futuros proyectos tecnológicos y mejora continua en la experiencia educativa en la Universidad Politécnica de Victoria.


<p align="right">(<a href="#readme-top">back to top</a>)</p>




<!-- MARKDOWN LINKS & IMAGES -->
[db-diagram]: images/assistance.png
[circuit-diagram]: images/PROYECTO.png
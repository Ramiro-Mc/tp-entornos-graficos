## Integrantes:

Matias Fernando Garcia Marianelli <br>
Jerónimo Corvi <br>
Elias Moramarco <br>
Ramiro Martinez Castro <br>

## Introducción

El trabajo práctico consiste en desarrollar un sitio web teniendo en cuenta las metodologías descritas dentro de la Arquitectura de la Información usando HTML, CSS, Bootstrap y PHP. El sitio web está diseñado para facilitar la gestión de ofertas y promociones tanto para los propietarios de locales como para los clientes de un shopping en Rosario.

La idea es garantizar la accesibilidad y funcionalidad en todo tipo de dispositivos implementando, a su vez, medidas de seguridad con el fin de proteger la información sensible de todos los usuarios del mismo, y mejorando la experiencia de usuarios, proporcionando un sitio accesible y usable.

## Definición del Sitio Web
### Objetivos del Sitio 
El objetivo del sitio web es gestionar promociones y/o descuentos en los distintos locales de un reconocido shopping de la ciudad de Rosario, a traves de sitio responsivo accesible desde cualquier dispositivo.
A traves del sitio, se busca:

- Brindar un sistema para la creacion, gestion, aprobacion y seguimiento de las distintas promociones, por parte de un administrador y un duemo del local.

-  Permitir a los clientes registrarse y consultar promociones.

- Garantizar un sistema de seguridad en las cuentas, protegiendo la integridad del servicio.

- Proveer reportes para el analisis del uso de promociones, tanto para administradores como para duenos de locales.

- Permitir la publicacion de novedades relevantes segun las distintas categorias de clientes.

### Descripcion del Sitio
El trabajo practico consiste en el desarrollo de un sitio web que permita gestionar los descuentos y promociones en los locales de un reconocido shopping de la ciudad de Rosario. En este contexto, los terminos ofertas, descuentos y promociones seran sinonimos.

El sitio web sera una Web APP totalmente responsiva, disenada para ser utilizada en diferentes dispositivos. Habra cuatro niveles de usuarios distintos: Administrador, Duenos de locales, Clientes y Usuarios no registrados.

Cada usuario, excepto el administrador, debera poder registrarse en el sitio web. Los registros de los Duenos de Locales deberan ser autorizados por el Administrador, mientras que los Clientes recibiran un enlace de validacion en su correo electronico.

El administrador gestionara las ofertas de todos los locales del shopping, aprobando o denegando las propuestas segun la politica comercial del centro. Ademas, podra crear locales, aprobar cuentas de duenos de locales, crear novedades y monitorear el uso de los descuentos mediante reportes gerenciales.

Los Duenos de locales ingresaran las promociones de sus locales, que seran aprobadas o denegadas por el Administrador. Tambien podran aceptar o rechazar solicitudes de descuento de los clientes y monitorear el uso de sus promociones.

Los Clientes podran registrarse, buscar descuentos, ingresar codigos de locales y elegir promociones disponibles segun su categoria (Inicial, Medium, Premium). Los Usuarios no registrados podran visualizar todas las promociones y acceder al email de contacto del administrador.

## Definicion de la Audiencia


> Administrador

•Es quien gestiona las promociones de todos los locales del shopping, aceptando o denegando las peticiones de las mismas que son propuestas por los dueños de los locales<br>
•Puede crear, editar, eliminar locales y validar  las cuentas de los dueños de los locales<br>
•También puede crear, editar y eliminar novedades, las cuales estarán destinadas a las distintas categorías de clientes, y aparecerán en el inicio del sitio web.<br>
•Por último va a tener acceso a una sección de reportes la cual donde se podrá monitorizar la utilización de los descuentos en los locales


> Dueños de los locales

Podran:

• Crear y eliminar descuentos en su propio local. No se permite la edicion para evitar consideraciones de publicidad enganosa. En caso de cometer errores en la carga, debera eliminar la promocion. <br>
• Aceptar o rechazar una solicitud de descuento de un cliente.<br>
• Ver la cantidad de clientes que usaron un descuento.<br>
•Los dueños de locales serán los encargados de aceptar o rechazar las solicitudes de descuento de los clientes que quieran adquirirlas<br>


> Clientes

•Para poder ser clientes deben primero registrarse con un email y contraseña<br>
•También van a tener que realizar solicitudes para que las nuevas promociones que quieran realizar sean aceptadas por el administrador en el caso de querer crear una nueva promoción.<br>
•Cada usuario podrá ver las novedades publicadas por el administrador, las cuales están vigentes y estén dirigidas a su categoría, aplicando la misma lógica de las promociones (médium puede ver inicial y medium, premium todas)<br>
•Cada cliente tiene una categoría, las cuales son inicial, medium y premium, al principio todos los usuarios estarán en la categoría inicial, la cual va a aumentar automáticamente a medida de que vaya adquiriendo promociones en los locales. El usuario Medium va a poder acceder a las promociones destinadas a su categoría y a la inicial y el premium va a poder tener acceso a todas las promociones de los locales, ya que cuenta con la categoría más alta.



> Usuarios no Registrados

Podran:<br>
• Visualizar todas las promociones de todos los locales del shopping para todas las categorias de clientes.<br>
• Poder acceder al email de contacto para poder comunicarse con el administrador del sitio web




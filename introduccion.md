## Integrantes:

Matias Fernando Garcia Marianelli <br>
Jerónimo Corvi <br>
Elias Moramarco <br>
Ramiro Martinez Castro <br>

## Introducción

El trabajo práctico consiste en desarrollar un sitio web teniendo en cuenta las metodologías descritas dentro de la Arquitectura de la Información usando HTML, CSS, Bootstrap y PHP. El sitio web está diseñado para facilitar la gestión de ofertas y promociones tanto para los propietarios de locales como para los clientes de un shopping en Rosario.

La idea es garantizar la accesibilidad y funcionalidad en todo tipo de dispositivos implementando, a su vez, medidas de seguridad con el fin de proteger la información sensible de todos los usuarios del mismo, y mejorando la experiencia de usuarios, proporcionando un sitio accesible y usable.

Para esto, tuvimos en cuenta conceptos como el de perceptibilidad, de modo que las componentes e información de la interfaz es muy clara y perceptible para los usuarios, con textos concisos que permiten al usuario saber dónde están y cómo moverse; operabilidad, pues las operaciones son muy sencillas de realizar y muy intuitivas, al mismo tiempo que pueden manejarse las componentes de la interfaz y los sistemas de navegación; comprensibilidad, pues todas las operaciones y la información que se presenta es muy clara, concisa y comprensible; y robusta, pues el contenido puede ser bien interpretado por una gran variedad de agentes de usuario, además de permitir el uso de dispositivos de distintos tamaños. Sumado a esto, se proporcionan sistemas de navegación, búsquedas y filtros necesarios para la accesibilidad del usuario, mejorando su experiencia al usar la página.

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

Debera poder:
• Crear, editar y eliminar locales. <br>
• Validar cuentas de duenos de locales.<br>
• Aprobar o denegar una solicitud de descuento de un local.<br>
• Crear, editar y eliminar novedades del shopping.<br>
• Ver reportes acerca de la utilizacion de los descuentos.

> Duenos de los locales

Podran:

• Crear y eliminar descuentos en su propio local. No se permite la edicion para evitar consideraciones de publicidad enganosa. En caso de cometer errores en la carga, debera eliminar la promocion. <br>
• Aceptar o rechazar una solicitud de descuento de un cliente.<br>
• Ver la cantidad de clientes que usaron un descuento.

> Clientes

Como cliente, podra:<br>
• Registrarse en el sistema para acceder a las ofertas del shopping.<br>
• Buscar descuentos en los locales del shopping.<br>
• Ingresar el codigo de un local y elegir un descuento disponible.<br>
• ver las novedades del shopping.

> Usuarios no Registrados

Podran:
• Visualizar todas las promociones de todos los locales del shopping para todas las categorias de clientes.<br>
• Poder acceder al email de contacto para poder comunicarse con el administrador del sitio web




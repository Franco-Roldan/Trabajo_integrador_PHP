# Trabajo_integrador_PHP

Crea una pequeña aplicación web (en php) que gestione operaciones sencillas de nuestro banco: **Diodos Bank **. Lo primero que mostrará es un pequeño menú con las siguientes opciones:
    •Últimos movimientos (últimos 5 movimientos).
    •Ingresar dinero.
    •Pagar recibos.
    •Devolver recibos.
Para el ingreso de dinero y el pago de recibos, crea un formulario en el que se solicite la siguiente información:
    •Fecha
    •Concepto
    •Cantidad

La fecha hace referencia al día en el que se realiza la operación (ingreso o pago), el Concepto es la descripción de la operación, y la Cantidad indicará el dinero empleado.

Toda la información referente a los movimientos (las operaciones de ingreso y pago) será almacenada en un array. Todos los campos son obligatorios. Si la inserción ( ingreso o pago ) se efectúa correctamente se debe avisar al usuario y mostrar la lista de los últimos movimientos. En el caso de que la inserción no fuese satisfactoria se notificarán los errores y el formulario seguirá mostrando los campos que se habían intentado introducir para poder modificarlos.

A la hora de mostrar los últimos movimientos se debe mostrar bien en una tabla (haciendo uso del tag <table> de HTML) o si se prefiere usar CSS haciendo uso de la propiedad display (display: table) una fila por cada elemento de la lista de la compra. Por cada fila deben aparecer 4 columnas: Fecha, Concepto, Cantidad, Saldo contable. Las tres primeras hacen referencia a la información almacenada y la cuarta es un campo calculado consistente en el saldo total después de cada operación. Al final del listado se debe mostrar el saldo contable actual con formato destacado. Si no hay nada que mostrar se debe avisar al usuario.

Para la devolución de recibos deberás listar los recibos con los 3 campos principales (Fecha, Concepto y Cantidad), en el caso de que hubiesen, sino, habría que notificarlo al usuario. La devolución consistirá en la eliminación del recibo, y por consiguiente en la desaparición del array de movimientos. En caso de que la eliminación se haya efectuado correctamente se debe avisar al usuario y mostrar la lista de recibos restantes, en el caso de que hubiesen.

Todo el código debe estar documentado correctamente (haciendo uso de los comentarios de php).

Deben utilizarse funciones, pueden crearse tantas como se precisen. Al menos 
existirán las funciones de:
    •Calcular_Saldo_Contable: tendrá un parámetro de salida que devolverá la cantidad calculada (se hará paso por referencia).
    •Validar_Datos: Validar los campos de fecha, concepto y cantidad.

Todas las funciones deben ser implementadas en un fichero independiente 
llamado funciones.php

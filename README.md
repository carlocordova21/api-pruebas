# api-pruebas
POST/ auth => Solicita usuario y password para autenticarse y generar el token
Body:
{
    "usuario" : "usuario1@gmail.com",
    "password" : "password"
}

POST/ paciente => Inserta usuario y solicita el token del usuario de la base de datos
Body:
{
    "dni" : "J000000010",
    "nombre" : "Pedro Perez",
    "direccion" : "Puente Piedra",
    "codigoPostal" : "15101",
    "telefono" : "987654222",
    "genero" : "M",
    "fechaNacimiento" : "1997-10-12",
    "correo" : "paciente10@gmail.com",
    "token" : "75d3956c84629e514f6f71c9447b3a31"
}

GET/ paciente?page=[numero de pagina] => Paginacion al solicitar la lista de pacientes(10 registros por pagina)
Respuesta: Json con todos los pacientes

GET/ paciente?id=[id de paciente] => Busqueda de datos de paciente por id
Respuesta:
{
    "PacienteId": 1,
    "DNI": "A000000001",
    "Nombre": "Juan Carlos Medina",
    "Direccion": "Calle de pruebas 1",
    "CodigoPostal": "20001",
    "Telefono": "633281515",
    "Genero": "M",
    "FechaNacimiento": "1989-03-02",
    "Correo": "Paciente1@gmail.com"
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestionAnswer;
use App\Models\Visit;
use App\Models\SurveyQuestion;

class SurveyQuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller1Answers = [
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "INSTITUTO DEL RIÑON DE CORDOBA",
                "Nombre de contacto" => "Juan posada",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "El señor Juan. Posada era el encargado de compras de la clínica Imat hace un tiempo y es quien ahora está en el instituto del riñón",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "15:30",
                "Hora de Finalización" => "16:10"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "FUNDACION OPORTUNIDAD Y VIDA",
                "Nombre de contacto" => "Rosemberg toro",
                "Cargo de contacto" => "Pagador - Financiero - Tesorería/Jurídica",
                "Proposito" => "Recaudo de cartera / Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Mi objetivo principal en la visita era poder conversar con el gerente el señor Wilmer pinto no se encontraba y me tomé la tarea de escribirle a su número el muy amablemente me respondió diciendo que para este mes realiza el pago doble  de lo que tenía programado",
                "Tarea y/o Pendiente" => "Frecuencia de visita",
                "Hora de Inicio" => "11:00",
                "Hora de Finalización" => "12:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CENTRO CARDIOINFANTIL  IPS SAS",
                "Nombre de contacto" => "Margarita watt",
                "Cargo de contacto" => "Pagador - Financiero - Tesorería/Jurídica",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "El cliente manifiesta que le mantengamos un stock de los salbutamol inhalador ventilan",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "09:14",
                "Hora de Finalización" => "10:14"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "MACRO SUMINISTROS DEL SINU S.A.S",
                "Nombre de contacto" => "Karol soto",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Es un cliente que está dentro de los prospecto nos envío cotización no paso orden de compra estoy trabajando para q convertirlo en cliente potencial para Surtimed",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "10:10",
                "Hora de Finalización" => "11:10"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "DIAC LTDA Y/O SALIM MIGUEL HADDAD GARCIA",
                "Nombre de contacto" => "Wilder blanco",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "El cliente manifiesta que el precio de nosotros está por encima de otros proveedores",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "10:00",
                "Hora de Finalización" => "11:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "MACRO SUMINISTROS DEL SINU S.A.S",
                "Nombre de contacto" => "Karol soto",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Es un cliente que está dentro de los prospecto nos envío cotización no paso orden de compra estoy trabajando para q convertirlo en cliente potencial para Surtimed",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "11:00",
                "Hora de Finalización" => "12:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "MEDISINU IPS S.A.S",
                "Nombre de contacto" => "Ramiro Benítez",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "El cliente manifiesta que hemos mejorado mucho en cuanto a inventario según los cotizado y en precio somos los mejores dentro de sus proveedores",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "15:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CLINICA MATERNO INFANTIL CASA DEL NIÑO LTDA",
                "Nombre de contacto" => "Patricia Granados",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "La señora Patricia del área de contabilidad me informa que estamos en los pagos programados",
                "Tarea y/o Pendiente" => "Llamar asistente de gerencia para acordar cita con gerencia",
                "Hora de Inicio" => "15:00",
                "Hora de Finalización" => "17:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CLINICA ZAYMA S.A.S.",
                "Nombre de contacto" => "Erika González",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "La señora Erika me informa que está semana cuando entre el recursos nos realizarán un abono",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "17:00",
                "Hora de Finalización" => "18:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CLINICA MONTERIA S.A",
                "Nombre de contacto" => "Hernán Noriega",
                "Cargo de contacto" => "Farmacia / Regente de Farmacia / Bodega / Almacén",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "Sí",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Recuperacion de cliente",
                "Breve observación entorno a la visita" => "Ofrecerle al señor Hernán Noriega un cupo por 8.000.000 para recuperar nuevamente nuestro vínculo comercial",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "09:00",
                "Hora de Finalización" => "10:20"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "FUNDACION OPORTUNIDAD Y VIDA",
                "Nombre de contacto" => "Rosemberg toro",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Están a la espera de el recuerdo de cajacopi para poder realizaron el pago del acuerdo pactado",
                "Tarea y/o Pendiente" => "Frecuencia de visita para hablar directamente con gerencia",
                "Hora de Inicio" => "10:20",
                "Hora de Finalización" => "11:20"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "UROCLINICA DE CORDOBA S.A.S",
                "Nombre de contacto" => "JOHANNA GONZALEZ",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "LA ME SEÑORA JOHANNA ME  INFORMA QUE NO PUDIERON REALIZAR PAGO A FIN DE MES PORQ AUN ESTAN A LA ESPERA DE LOS RECUERSOS LOS PROXIMO PAGO ESTA INCLUIDO SURTIMED POR UN VALOR DE 2.626.671",
                "Tarea y/o Pendiente" => "PROGRAMAR VISITA PARA EL DIA LUNES 10 DE OCTUBRE 2022",
                "Hora de Inicio" => "11:20",
                "Hora de Finalización" => "12:20"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CENTRAL DE URGENCIAS DE TRAUMA S.A.S",
                "Nombre de contacto" => "JENNIFER PEREZ",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Obsequios / Cumpleaños/No relacionado con venta o Recaudo",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "EL SEÑOR GERENTE SE ENCONTRABA DE CUMPLEAÑOS LE HICIMOS ENTREGA DE UNA TORTA POR PARTE DE SURTIMED SUMINISTROS S.A.S",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "15:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CMP PHARMA",
                "Nombre de contacto" => "LUBIS POLO",
                "Cargo de contacto" => "Farmacia / Regente de Farmacia / Bodega / Almacén",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "LA SEÑORA LUBIS ME COMENTA QUE ESTA EN PROGRAMACION DE PAGO",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "15:00",
                "Hora de Finalización" => "17:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E HOSPITAL UNIVERSITARIO DE CARTAGENA",
                "Nombre de contacto" => "PAOLA VERGARA",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "LA SEÑORA PAOLA VERGARA TESORERA SE DIRIGIA A UNA REUNION CON GERENCIA Y ME SOLICITO QUE LE ENVIARA CERTIFICACION BANCARIA PARA QUE AL MOMENTO QUE LE AUTORIZARAN EL PAGO",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "07:00",
                "Hora de Finalización" => "08:20"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "FUNDACION OPORTUNIDAD Y VIDA",
                "Nombre de contacto" => "ROSEMBERG TORO",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "ME DIRIJO HASTA LA IPS PUESTO QUE EL PAGO NO HA ENTRADO A SURTIMED EL SEÑOR ROSEMBERG ME HABIA DADO FECHA Y HORA Y AUN NO HA LLEGADO TRANFERENCIA",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "07:00",
                "Hora de Finalización" => "08:10"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CLINICA DE REFERENCIA",
                "Nombre de contacto" => "JENNIFER PEREZ",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Obsequios / Cumpleaños/No relacionado con venta o Recaudo",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "ENTREGA DE DOCUMENTOS DE SOLICUTD DE CREDITO PARA APERTURA NUEVO CLIENTE",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "RESPUESTA CUPO APROBADO",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "16:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "MEDICINA INTEGRAL S.A.",
                "Nombre de contacto" => "MANUEL RAMOS",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "EL SEÑOR MANUEL SE ENCONTRABA OCUPADO EN DISPENSACION",
                "Tarea y/o Pendiente" => "PROGRAMAR NUEVA VISITA",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "15:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "FUNDACION OPORTUNIDAD Y VIDA",
                "Nombre de contacto" => "ROSEMBERG TORO",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "REALIZARON PAGO DE FACTURAS  4286-4631 POR UN VALOR DE 2.266.009",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "ESPERAR TIEMPOS ACH DONDE SE REFLEJA EL PAGO",
                "Hora de Inicio" => "07:00",
                "Hora de Finalización" => "09:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CLINICA CARDIOVASCULAR DEL CARIBE S.A.S",
                "Nombre de contacto" => "KAREN MESTRA",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "LA SEÑORA KAREN SE ENCONTRABA OCUPADA NO PUDO ASTENDER MI VISITA",
                "Tarea y/o Pendiente" => "PROGRAMAR VISITA PARA PROXIMA SEMANA",
                "Hora de Inicio" => "09:00",
                "Hora de Finalización" => "09:20"
            ]
        ];

        $seller2Answers = [
            [
                "¿Es nuevo el cliente?" =>  ["Si"],
                "Cliente" =>  ["E.S.E. VIDA SINU"],
                "Nombre de contacto" =>  ["Karen Peña"],
                "Cargo de contacto" =>  ["Farmacia / Regente de Farmacia / Bodega / Almacén"],
                "Proposito" =>  ["Vender / Promoción de productos/ Documentos de crédito"],
                "¿Realizó venta?" =>  ["Sí"],
                "¿El cliente realizó pago?" =>  ["No"],
                "¿Se obtuvo un logro?" =>  ["Sí"],
                "Breve descripción SI obtuvo algún logro" =>  "Se acordaron los productos que estaban pendientes para hacer la facturación que nos hace falta del contrato No 051",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Organizar el archivo en Excel para poder hacer los cruces correspondientes y hacer la facturación",
                "Hora de Inicio" => "16:10",
                "Hora de Finalización" => "17:10"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. VIDA SINU",
                "Nombre de contacto" => "E.S.E. VIDASINU",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Organizar las remisiones entregadas y hacer la relación para poder hacer la factura correspondiente del saldo que tenemos en el contrato No 051",
                "Tarea y/o Pendiente" => "Organizar la factura con Claudia posterior a la autorización de Vidasinu ",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "18:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. VIDA SINU",
                "Nombre de contacto" => "Leidy Montesino",
                "Cargo de contacto" => "Gerente / Administrador",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Hablé con la Dra Leidy para preguntarle sobre nuevos procesos de contratación de medicamentos y dispositivos y consultarle sobre el contrato del Instrumental Odontológico.",
                "Tarea y/o Pendiente" => "Organizar los documentos para que apenas salga la convocatoria para el contrato del Instrumental poder presentar de manera oportuna.",
                "Hora de Inicio" => "09:00",
                "Hora de Finalización" => "09:25"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. VIDA SINU",
                "Nombre de contacto" => "Karen Peña",
                "Cargo de contacto" => "Farmacia / Regente de Farmacia / Bodega / Almacén",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "Si",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Se hizo la legalización y/o radicación de las últimas facturas correspondientes al contrato No 051 de medicamentos y dispositivos médicos",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Organizar la cuenta de cobro final para legalizar con Dina.",
                "Hora de Inicio" => "10:00",
                "Hora de Finalización" => "10:25"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. VIDA SINU",
                "Nombre de contacto" => "E.S.E. VIDASINU",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Organizar el archivo de los productos de Instrumental Odontológico con los costos y el proveedor al que se le debe pedir cada producto y se le hizo el envío al área de compras para que inicie con su proceso.",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Estar al pendiente con el área de compras para que los productos nos lleguen de manera oportuna y así hacer las entregas a nuestro cliente en los tiempos estimados",
                "Hora de Inicio" => "10:00",
                "Hora de Finalización" => "12:30"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. VIDA SINU",
                "Nombre de contacto" => "E.S.E. VIDASINU",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Terminar de organizar las dos propuestas de las OPS que manejaríamos con Vidasinú para el contrato de PIC que ellos manejarán con la alcaldía.",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Estar al pendiente de cuando el área jurídica saque las OPS para hacer el despacho y facturación de los productos.",
                "Hora de Inicio" => "10:00",
                "Hora de Finalización" => "12:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. CAMU SAN PELAYO",
                "Nombre de contacto" => "Harving Espitia",
                "Cargo de contacto" => "Gerente / Administrador",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Estuve en la alcaldía de San Pelayo tratando de reunirme con el señor alcalde pero no me atendieron.",
                "Tarea y/o Pendiente" => "Seguir haciendo seguimiento y visitas constantes hasta que nos cancelen el total de la cartera.",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "16:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "LABORATORIO CLINICO ANIMAL ELVELAS",
                "Nombre de contacto" => "Jorge Gonzalez",
                "Cargo de contacto" => "Gerente / Administrador",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Se hizo la presentación y muestra de nuestro portafolio de productos y el señor Jorge se muestra bastante interesado y me notifica que ya nos había hecho algunas compras.",
                "Breve observación entorno a la visita" => "Me comenta el señor Jorge que no le gusta tener muchos proveedores, que siempre le ha gustado comprar los productos que necesita en una sola parte y que si nosotros le podemos garantizar tenerle la disponibilidad él se fideliza con nosotros, tanto las compras que maneja con el laboratorio como las compras que se realizarían a nombre de la Universidad de Córdoba.",
                "Tarea y/o Pendiente" => "Enviar documentos para solicitud de crédito y catálogo de los productos que él más maneja.",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "14:50"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. CAMU SAN PELAYO",
                "Nombre de contacto" => "Eduar Orozco",
                "Cargo de contacto" => "Gerente / Administrador",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Pude hablar con el señor Eduar Orozco y este me manifiesta que cuando ingresen los recursos del giro nos estarían haciendo un nuevo abono a la cartera.",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Estar al pendiente del ingreso de los giros para seguir haciendo monitoreo a la cartera hasta que logremos sacar el pago.",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "15:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. VIDA SINU",
                "Nombre de contacto" => "Ingrid Arcia",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Se hizo entrega de una cotización de las que sirven como contrapropuestas en la cual habíamos tenido un error y hubo que corregirla.",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Hacer seguimiento al proceso de contratación para poder sacar el contrato lo antes posible para poder facturar todo lo que hemos despachado en remisión.",
                "Hora de Inicio" => "09:00",
                "Hora de Finalización" => "09:30"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "SERVICIO NACIONAL DE APRENDIZAJE - SENA",
                "Nombre de contacto" => "José Samir Obagi",
                "Cargo de contacto" => "Farmacia / Regente de Farmacia / Bodega / Almacén",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Hablando con el señor José Samir me expresa que no han podido hacer el informe final de la entrega porque estaban en un proceso de cambio en el software y en los usuarios de las personas y por lo tanto el proceso estaba un poco retrasado, pero que en los próximos días todo quedaría solucionado.",
                "Tarea y/o Pendiente" => "Seguir haciendo gestión tanto con el señor José Samir como con la señora Ludys para el pronto pago de lo pendiente.",
                "Hora de Inicio" => "15:00",
                "Hora de Finalización" => "16:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "DISTRISERVICIOS Y SUMINISTROS DEL BAJO SINU S.A.S",
                "Nombre de contacto" => "Alvaro Ortega Sibaja",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Se le explicó a Álvaro la diferencia y el porqué se da la diferencia que presentamos en estos momentos en la cartera y este me regala el número de celular de la contadora de ellos para que se pusieran de acuerdo ambas áreas contables y así solucionar la situación.",
                "Tarea y/o Pendiente" => "Estar al pendiente de la solución de las áreas contables y tratar de llegar a un buen acuerdo.",
                "Hora de Inicio" => "15:00",
                "Hora de Finalización" => "15:30"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. CAMU SANTA TERESITA",
                "Nombre de contacto" => "Lenin Doria Burgos",
                "Cargo de contacto" => "Gerente / Administrador",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Logré que el Dr. Lenin Doria me atendiera, pero este  me informa que en el momento toda la contratación que tiene la E.S.E. la está manejando por medio de Coodescor y que los demás productos son comprados a Distriservicios.",
                "Breve observación entorno a la visita" => "Noto que en el momento no tenemos oportunidad de venderle directamente al Camu Santa Teresita, debemos seguir manejando y afianzando las ventas con Distriservicios.",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "09:00",
                "Hora de Finalización" => "10:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "SOLUCIONES MEDICAS DEL SINU S.A.S",
                "Nombre de contacto" => "Monica Ortega",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Haciendo recordación a Mónica de nuestros productos me informa que en el momento tiene disponibilidad de la mayoría de los productos que ellos manejan como tal, pero que si llega a necesitar algo ella me pregunta enseguida.",
                "Tarea y/o Pendiente" => "Seguir haciendo seguimiento al cliente para fortalecer las ventas",
                "Hora de Inicio" => "10:00",
                "Hora de Finalización" => "10:20"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "SOLUCIONES MEDICAS DEL SINU S.A.S",
                "Nombre de contacto" => "Marta Nieves",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Me informa la señora Marta que en cuanto le ingresaran los recursos a ellos de algunos pagos que tienen pendientes del hospital San Vicente de Paul ellos nos estarían haciendo el pago de la cartera que tenemos.",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "10:20",
                "Hora de Finalización" => "10:30"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E CAMU IRIS LOPEZ DURAN",
                "Nombre de contacto" => "María Angelica Blanco",
                "Cargo de contacto" => "Pagador / Financiero / Tesorería/Jurídica",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Hablando con María Angelica (secretaria de gerencia) me informa que la gerente no estaba en el Camu. Entonces, me regaló su número de celular para que la llamara en los próximos días y así apartar una cita con la Dra Eliana.",
                "Tarea y/o Pendiente" => "Llamar en los próximos días para apartar la cita.",
                "Hora de Inicio" => "10:40",
                "Hora de Finalización" => "10:50"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E CAMU IRIS LOPEZ DURAN",
                "Nombre de contacto" => "Francisco Javier López",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Me dice Francisco que las cosas por la E.S.E. han estado pesadas, que actualmente el proveedor que les está suministrando es un recomendado político pero que la Dra Eliana quiere cambiar ese proveedor, que apenas él escuche algo nos apoya para que seamos nosotros quienes empecemos a hacer el suministro.",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "11:00",
                "Hora de Finalización" => "11:15"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "RADIOLOGOS ASOCIADOS DEL BAJO SINU S.A.S.",
                "Nombre de contacto" => "Astrid Argel",
                "Cargo de contacto" => "Gerente / Administrador",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "En conversación con Astrid me informa que ya ellos son cliente de nosotros y que los viene atendiendo mi compañera Verónica, de igual forma, yo le recordé nuestro portafolio de productos y/o servicios.",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "11:15",
                "Hora de Finalización" => "11:30"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. CAMU DEL PRADO",
                "Nombre de contacto" => "Ana María Doria",
                "Cargo de contacto" => "Gerente / Administrador",
                "Proposito" => "Recaudo de cartera /Acuerdos de Pago",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Me informa la señora Ana María que si el dinero que les va a girar la alcaldía no les alcanza a ingresar antes de que llegue el giro ellos nos hacen el pago total del contrato con los recursos que les ingresen por el giro directo.",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Seguir haciendo seguimiento constante hasta lograr el pago de los recursos.",
                "Hora de Inicio" => "11:30",
                "Hora de Finalización" => "12:30"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "E.S.E. CAMU DEL PRADO",
                "Nombre de contacto" => "Ana María Doria",
                "Cargo de contacto" => "Gerente / Administrador",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Si",
                "Breve descripción SI obtuvo algún logro" => "Me informa la señora Ana María que existe una gran posibilidad de que seamos nosotros quienes obtengamos el nuevo contrato de suministro hasta finalizar este año.",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "12:30",
                "Hora de Finalización" => "12:40"
            ]
        ];

        $seller3Answers = [
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "SOLUCIONES DIAGNOSTICAS DEL RIO S.A.S",
                "Nombre de contacto" => "Katherine Salas",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "No",
                "Breve descripción SI obtuvo algún logro" => "",
                "Breve observación entorno a la visita" => "Presentación con encargada de compras",
                "Tarea y/o Pendiente" => "Enviar portafolios o propuesta comer por correo suministrado",
                "Hora de Inicio" => "07:00",
                "Hora de Finalización" => "08:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "MULTISUMINISTROS Y ASESORIAS S.A.S.",
                "Nombre de contacto" => "Lina Correa",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos/ Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Establecer contacto con persona encargada de compras",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Pendiente por revisar agotados y generar pedido",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "15:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "KIDS CENTER UNIDAD PEDIATRICA S.A.S",
                "Nombre de contacto" => "Ingrid Oviedo",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se estableció contacto con encargada de compras",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "09:00",
                "Hora de Finalización" => "10:30"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "FUNDACION LA MANO DE DIOS",
                "Nombre de contacto" => "Denis Madera",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se estableció contacto con persona encargada de compras",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Seguimiento frecuente",
                "Hora de Inicio" => "15:10",
                "Hora de Finalización" => "16:40"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "ESPECIALISTAS ASOCIADOS S.A",
                "Nombre de contacto" => "Lucia Ayazo",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se estableció contacto con persona encargada de compras, cliente solicita producto que en la actualidad está agotado",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Diligenciar producto pendiente para generar pedido",
                "Hora de Inicio" => "14:10",
                "Hora de Finalización" => "16:10"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "NORELA VAZQUEZ MONTOYA",
                "Nombre de contacto" => "Norela Vasquez",
                "Cargo de contacto" => "Gerente / Administrador",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "Sí",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se generó pedido",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "14:05",
                "Hora de Finalización" => "15:05"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "VISALUD S.A.S",
                "Nombre de contacto" => "Nelly Argumedo",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se estableció contacto con persona encargada de compras",
                "Breve observación entorno a la visita" => "Cliente estará pasando pedido antes del 7 de agosto",
                "Tarea y/o Pendiente" => "Recordar al cliente pedido pendiente",
                "Hora de Inicio" => "07:05",
                "Hora de Finalización" => "08:35"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "SUMIDROGAS S.A.S",
                "Nombre de contacto" => "Jorge Fernando",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se estableció contacto con persona encargada de compras",
                "Breve observación entorno a la visita" => "Encargado de compras manifiesta que te usará inventario para establecer pedido",
                "Tarea y/o Pendiente" => "Seguimiento al cliente, recordándole pedido pendiente",
                "Hora de Inicio" => "09:00",
                "Hora de Finalización" => "10:10"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "LABORATORIO CLINICO DUNALAB I.P.S S.A.S",
                "Nombre de contacto" => "Diana Tamayo",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se estableció contacto con persona encargada de compras",
                "Breve observación entorno a la visita" => "Cliente solicita portafolio por vía e-mail",
                "Tarea y/o Pendiente" => "Enviar portafolios",
                "Hora de Inicio" => "10:00",
                "Hora de Finalización" => "11:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "MARIA PATRICIA SILVA ALEAN",
                "Nombre de contacto" => "Margarita Ospina",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se estableció contacto con persona encargada de compras",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "Seguimiento a clientes",
                "Hora de Inicio" => "10:00",
                "Hora de Finalización" => "10:45"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CENTRO AVANZADO DE ATENCION EN TRATAMIENTOS DE HERIDAS S.A.S",
                "Nombre de contacto" => "Sofia Torralbo",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "Sí",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Cliente realizó pedido",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "10:45",
                "Hora de Finalización" => "11:15"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "INVERSIONES DISTRIAGRO S.A.S",
                "Nombre de contacto" => "Keila",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se estableció contacto con persona encargada de compras y se entregó acuerdo de pago",
                "Breve observación entorno a la visita" => "Cliente manifiesta que realizará pago está semana y posteriormente realizará pedido",
                "Tarea y/o Pendiente" => "Enviar portafolio de productos",
                "Hora de Inicio" => "14:15",
                "Hora de Finalización" => "15:15"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "ENTRE PERROS Y GATOS PETSHOP Y CONSULTA VERTERINARIA Y/O GAB",
                "Nombre de contacto" => "Gabriel Alvarez",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "Sí",
                "¿El cliente realizó pago?" => "Sí",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Cliente realizó compra de contado",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "15:15",
                "Hora de Finalización" => "16:15"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CENTRAL DE COOPERATIVAS DE SERVICIOS INTEGRALES DE CORDOBA LOS OLIVOS",
                "Nombre de contacto" => "Tulia Muñoz",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "Sí",
                "¿El cliente realizó pago?" => "Sí",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Compra de contado",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "16:15",
                "Hora de Finalización" => "16:45"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CLINICA VETERINARIA MOMO",
                "Nombre de contacto" => "Victoria",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Hacer la respectiva presentación con la persona encargada de compras",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "16:45",
                "Hora de Finalización" => "17:45"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CENTRO VETERINARIO ALEAN LORA",
                "Nombre de contacto" => "Viviana Doria",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "Sí",
                "¿El cliente realizó pago?" => "Sí",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Cliente realiza compra de contado",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "09:30",
                "Hora de Finalización" => "10:30"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "MONTERRICO VETERIANARIA Y SPA Y/O JUAN SALLEG TABOADA",
                "Nombre de contacto" => "Julieth florez",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Se estableció contacto con persona encargada de compras",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "10:30",
                "Hora de Finalización" => "12:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "SCANER S.A",
                "Nombre de contacto" => "Rubiela Diaz",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "Sí",
                "¿El cliente realizó pago?" => "Sí",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Cliente Realiza compra de contado",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "14:00",
                "Hora de Finalización" => "15:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "COMERCIALIZADORA BETT- MEDICAL Y/O JORGE LUIS BETTIN ROJAS",
                "Nombre de contacto" => "Jorge Betin",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Presentación ante persona encargada",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "15:00",
                "Hora de Finalización" => "16:00"
            ],
            [
                "¿Es nuevo el cliente?" => "Si",
                "Cliente" => "CENTRO OFTALMOLOGICO DEL SINU S.A.S",
                "Nombre de contacto" => "Jennifer Paternina",
                "Cargo de contacto" => "Compras",
                "Proposito" => "Vender / Promoción de productos / Documentos de crédito",
                "¿Realizó venta?" => "No",
                "¿El cliente realizó pago?" => "No",
                "¿Se obtuvo un logro?" => "Sí",
                "Breve descripción SI obtuvo algún logro" => "Presentación ante persona encargada de compras",
                "Breve observación entorno a la visita" => "",
                "Tarea y/o Pendiente" => "",
                "Hora de Inicio" => "16:00",
                "Hora de Finalización" => "17:00"
            ]
        ];

        $data = [
            ['dni' => '1005478123', 'answers' => $seller1Answers],
            ['dni' => '1005472347', 'answers' => $seller2Answers],
            ['dni' => '1005479536', 'answers' => $seller3Answers],
        ];

        foreach ($data as $item) {
            $user = User::where('dni', $item['dni'])->first();

            if (!$user) {
                dump("The user with DNI {$item['dni']} was not found");
                continue;
            }

            $survey = $user->assignedSurvey;

            if (!$survey) {
                dump("The user with DNI {$item['dni']} does not have an assigned survey.");
                continue;
            }

            $visits = Visit::where('user_id', $user->id)
                ->orderBy('visit_date')
                ->get();

            $answersList = $item['answers'];

            foreach ($answersList as $index => $responseData) {
                $visit = $visits[$index] ?? null;

                if (!$visit) {
                    dump("There is no visit for $index for user {$user->id}");
                    continue;
                }

                $surveyAnswer = SurveyAnswer::create([
                    'user_id' => $user->id,
                    'survey_id' => $survey->id,
                    'date' => $visit->visit_date,
                ]);

                foreach ($responseData as $questionId => $answer) {

                    $question = SurveyQuestion::where('question', 'like', "$questionId")->first();

                    if (!$question) {
                        dump("The question was not found. $questionId");
                        continue;
                    }

                    SurveyQuestionAnswer::create([
                        'survey_answer_id' => $surveyAnswer->id,
                        'survey_question_id' => $question->id,
                        'answer' => $answer,
                    ]);
                }
            }
        }
    }
}

<?php
/***
 * Preguntas de HOSPITALIZACIÓN
 */


require_once __DIR__ . '/question.php';

return [
    # 1
    question::create(
        question: '¿Su ingreso al Hospital  fue por?',
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption(1, 'Servicio de urquencias'),
            question::newOption(2, 'Cirujía programada')
        ]
    ),

    # 2
    question::create(
        question:  'Al ingresar al Hospital  fue atendido',
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption(1, 'Inmediatamente'),
            question::newOption(2, 'Entre 20 a 40 minutos'),
            question::newOption(3, 'Mas de 40 minutos')
        ]
    ),
    
    # 3
    question::create(
        question: "Cuáles de las siguientes personas lo recibió",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption(1, 'Vigilante'),
            question::newOption(2, 'Auxiliar'),
            question::newOption(3, 'Recepcionista'),
            question::newOption(4, 'Médico'),
            question::newOption(5, 'Enfermero'),
            question::newOption(6, 'Nadie me recibio')
        ]
    ),

    # 4
    question::create(
        question: "La atención de la persona que lo recibió  fue  Amable y oportuna",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 5
    question::create(
        question: "Al registrarse le solicitaron la siguiente información",
        type: question::TYPE_RADIO_BUTTON_MAS,
        options: [
            question::newOption(1, 'Documento de identificación'),
            question::newOption(2, 'Autorización')
        ]
    ),

    # 6
    question::create(
        question: "Califique la comodidad de la habitación",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 7
    question::create(
        question: "Califique la  atención recibida por su(s) médico, especialista, tratantes",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 8
    question::create(
        question: "¿Está conforme con la información recibida por el médico sobre la enfermedad o motivo de  consulta?",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 9
    question::create(
        question: "¿Durante la hospitalización ha recibido o recibió oportunamente los medicamentos y los exámenes solicitados por el médico tratante?",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 10
    question::create(
        question: "Califique  en conjunto la  satisfacción de la atención brindada  durante la  hospitalización.",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    )
];
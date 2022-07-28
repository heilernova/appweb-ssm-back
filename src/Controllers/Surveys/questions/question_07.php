<?php
/***
 * Preguntas de ODONTOLOGIA
 */


require_once __DIR__ . '/question.php';

return [
    # 1
    question::create(
        question: 'Nombre de la IPS',
        type: question::TYPE_INPUT,
        style: ['text-transform' => 'uppercase']
    ),

    # 2
    question::create(
        question: "Cuando usted solicita una cita, se la asignan para",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('El mismo dia'),
            question::newOption('1 dia después'),
            question::newOption('5 días después'),
            question::newOption('8 días después')
        ]
    ),

    # 3
    question::create(
        question: "Al ingresar a la IPS el trato de la persona que lo atendió fue",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 4
    question::create(
        question: "¿El profesional estaba en el consultorio?",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 5
    question::create(
        question: "¿El profesional tenia buena disposición para atenderlo?",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 6
    question::create(
        question: "Califique la comunicación que pudo obtener  con el profesional",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 7
    question::create(
        question: "Califique la explicación  sobre exámenes  y tratamiento a seguir",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 8
    question::create(
        question: "Califique su satisfacción con  la atención recibida por el profesional en consultorio",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 9
    question::create(
        question: "Califique su satisfacción en general con la atención recibida en el servicio de medicina general",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 10
    question::create(
        question: "Califique su satisfacción en general con la atención recibida en el servicio de odontología",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    )
];
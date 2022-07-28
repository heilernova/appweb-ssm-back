<?php
/***
 * Preguntas de FARMACIA
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
        question: "El trato de la persona que le entrego los medicamentos  fue",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 3
    question::create(
        question: "Califique la comodidad  del área  para recibir los medicamentos",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 4
    question::create(
        question: "'Califique  el tiempo  de espera desde el momento  de entrega de la formula  y la recepción  de los medicamentos.",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('Inmediato'),
            question::newOption('A las 24 hora'),
            question::newOption('Mas de 48 horas')
        ]
    ),

    # 5
    question::create(
        question: "¿Entregaron el medicamento según lo formulado?",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 6
    question::create(
        question: "¿Fue entregado la totalidad de los medicamentos?",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 7
    question::create(
        question: "La farmacia ofrece el servicio de entrega de medicamentos a domicilio?",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('Si', 'Si'),
            question::newOption('No', 'No'),
            question::newOption('No sabe', 'No sabe')
        ]
    ),

    # 8
    question::create(
        question: "Califique en general el servicio de Farmacia.",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 9
    question::create(
        question: "Indique el tiempo en sala de espera",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('De 1 a 30 minutos'),
            question::newOption('De 30 a 60 minutos'),
            question::newOption('Mas de 1 hora'),
            question::newOption('Mas de 2 hora')
        ]
    )
];
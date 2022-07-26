<?php
/***
 * Preguntas de IPS
 */


require_once __DIR__ . '/question.php';

return [
    # 1
    question::create('Nombre de la IPS', question::TYPE_INPUT),

    # 2
    question::create(
        question:  '¿Al momento de solicitar algún servicio de la IPS, el trato hacia usted fue?',
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),
    
    # 3
    question::create(
        question: "El personal que le informó sobre el trámite que debía seguir fue claro, le supo dar las indicaciones?",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 4
    question::create(
        question: "Cuando usted solicita una cita médica, le asignan la cita para",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('1 día después'),
            question::newOption('2 a 3 días después'),
            question::newOption('4 a 5 días después'),
            question::newOption('8 días después'),
            question::newOption('Mas de 10 días despúes')
        ]
    ),

    # 5
    question::create(
        question: "En el momento que la IPS le solicita el nombre de la EPS a la cual esta afiliado la reacción fue con",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('Amabilidad'),
            question::newOption('Normalidad'),
            question::newOption('Indisposición'),
            question::newOption('Apatía')
        ]
    ),

    # 6
    question::create(
        question: "El tiempo de espera entre la hora de la cita asignada  y el momento  real de la atención fue",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('Inmediata'),
            question::newOption('10 minutos'),
            question::newOption('15 minutos'),
            question::newOption('20 minutos'),
            question::newOption('Mas de 30 minutos')
        ]
    ),

    # 7
    question::create(
        question: "Indique en cuales de los siguientes servicios fue atendido",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('Medicina general'),
            question::newOption('Farmacia'),
            question::newOption('Laboratorío clínico'),
            question::newOption('Odontología'),
            question::newOption('PyP')

        ]
    ),

    # 8
    question::create(
        question: "Cómo califica la higiene en la IPS",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 9
    question::create(
        question: "¿Considera que la IPS asignada cumple con sus necesidades?",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 10
    question::create(
        question: "Califique el servicio de la  IPS  en general",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    )
];
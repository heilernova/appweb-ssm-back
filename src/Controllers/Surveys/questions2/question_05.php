<?php
/***
 * Preguntas de LABORATORIO
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
        question: "Considera que el horario establecido para la atención es",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 3
    question::create(
        question: "La atención de la persona que lo recibió fue",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 4
    question::create(
        question: "'Usted  considera que la información suministrada para la recolección de  la  muestra  y  la preparación del  paciente fue",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 5
    question::create(
        question: "Indique el tiempo en sala espera para la toma del exámen",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('Inmediato'),
            question::newOption('1 hora'),
            question::newOption('2 horas'),
            question::newOption('Mas de 3 horas'),
        ]
    ),

    # 6
    question::create(
        question: "Las condiciones para realizar el examen en cuanto a la comodidad e higiene son",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 7
    question::create(
        question: "Califique el trato del profesional al tomar las muestras",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    ),

    # 8
    question::create(
        question: "Luego realizar el examen del laboratorio, le entregaron  los resultados",
        type: question::TYPE_RADIO_BUTTON,
        options: [
            question::newOption('El mismo día'),
            question::newOption('A los 2 días'),
            question::newOption('A los 5 días'),
            question::newOption('A los 8 días')
        ]
    ),

    # 9
    question::create(
        question: "Está conforme  con el tiempo  de entrega de los resultados",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 10
    question::create(
        question: "Califique su satisfacción  con la atención  brindada  en el laboratorio clínico",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_OKEY_REGULAR_BAB
    )
];
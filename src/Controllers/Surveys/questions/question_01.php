<?php
/***
 * Preguntas de IPS
 */


require_once __DIR__ . '/question.php';

return [
    # 1
    question::create('Nombre de la EPS', question::TYPE_INPUT),

    # 2
    question::create(
        question:  '¿Cuáles de las siguientes personas lo recibió?',
        type: question::TYPE_RADIO_BUTTON_MAS,
        options: [
            question::newOption('Vigilante'),
            question::newOption('Promotor'),
            question::newOption('Recepcionista')
        ]
    ),
    
    # 3
    question::create(
        question: "¿La atención de la persona que lo recibió fue amable y oportuna?",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_YES_NO
    ),

    # 4
    question::create(
        question: "Adecuación de la sede de la EAPB",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5
    ),

    # 5
    question::create(
        question: "Procesos de difusión, canales de atención y capacitación de usuarios y alianzas.",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5
    ),

    # 6
    question::create(
        question: "Procesos de afiliación, reportes de nacimientos, novedades, portabilidad, movilidad y traslado",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5
    ),

    # 7
    question::create(
        question: "Procesos de direccionamiento y demanda inducida (P y P)",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5
    ),

    # 8
    question::create(
        question: "Procesos de atención para la prestación de servicios en la red",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5
    ),

    # 9
    question::create(
        question: "Procesos de autorizaciones",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5
    ),

    # 10
    question::create(
        question: "Proceso de referencia a otro departamento",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5
    ),

    # 11
    question::create(
        question: "Proceso de quejas, reclamos y solución de inconveniente",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5
    ),

    # 12 
    question::create(
        question: "Como califica la gestión del promotor y el asesor de servicios",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5,
        subquestions: [
            # 12.1
            question::create(
                question: "xxxxx",
                type: question::TYPE_RADIO_BUTTON,
                options: question::OPTIONS_SCORE_1_TO_5
            ),

            # 12.2
            question::create(
                question: "Gestión frente a la comunidad",
                type: question::TYPE_RADIO_BUTTON,
                options: question::OPTIONS_SCORE_1_TO_5
            )
        ]
    ),

    # 13 
    question::create(
        question: "La gestión que realiza la EAPB en beneficio a los usuarios es",
        type: question::TYPE_RADIO_BUTTON,
        options: question::OPTIONS_SCORE_1_TO_5
    )
];
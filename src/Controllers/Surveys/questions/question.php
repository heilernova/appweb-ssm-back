<?php

class question{

    public const TYPE_INPUT = 1;
    public const TYPE_RADIO_BUTTON = 2;
    public const TYPE_RADIO_BUTTON_MAS = 3;

    public const OPTIONS_YES_NO = [ [ 'code' => 'Si', 'text' => 'Si' ], [ 'code' => 'No', 'text' => 'No' ] ];
    public const OPTIONS_OKEY_REGULAR_BAB = [ ['code' => 'Bueno', 'text' => 'Bueno'], ['code' => 'Regular', 'text' => 'Regular'], ['code' => 'Malo', 'text' => 'Malo'] ];
    public const OPTIONS_SCORE_1_TO_5 = [ ['code' => 1, 'text' => '1'], ['code' => 2, 'text' => '2'], ['code' => 3, 'text' => '3'], ['code' => 4, 'text' => '4'], ['code' => 5, 'text' => '5']];

    static function create(
        string $question,
        int $type,
        ?array $options = null,
        array $subquestions = null,
        array $style = null
    ){
        
        $re['question'] = $question;
        $re['answer']['type'] = $type;

        if ( $options ) $re['answer']['options'] = $options;
        if ( $style ) $re['answer']['style'] = $style;
        if ( $subquestions ) $re['subquestions'] = $subquestions;

        return $re;
    }

    static function newOption(string|int $code, string $text = null):array{
        return [
            'code' => $code,
            'text' => $text ?? $code
        ];
    }
}
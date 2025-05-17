<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Liñas de Linguaxe de Validación
    |--------------------------------------------------------------------------
    |
    | As seguintes liñas de linguaxe conteñen as mensaxes de erro por defecto
    | empregadas pola clase de validación. Algunhas regras teñen múltiples versións
    | (como as regras de tamaño). Siéntete libre de modificar cada unha destas mensaxes.
    |
    */

    'accepted'             => 'O campo :attribute debe ser aceptado.',
    'active_url'           => 'O campo :attribute non é unha URL válida.',
    'after'                => 'O campo :attribute debe ser unha data posterior a :date.',
    'after_or_equal'       => 'O campo :attribute debe ser unha data posterior ou igual a :date.',
    'alpha'                => 'O campo :attribute só pode conter letras.',
    'alpha_dash'           => 'O campo :attribute só pode conter letras, números, guións e subguións.',
    'alpha_num'            => 'O campo :attribute só pode conter letras e números.',
    'array'                => 'O campo :attribute debe ser un conxunto.',
    'before'               => 'O campo :attribute debe ser unha data anterior a :date.',
    'before_or_equal'      => 'O campo :attribute debe ser unha data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O campo :attribute debe estar entre :min e :max.',
        'file'    => 'O campo :attribute debe ter entre :min e :max kilobytes.',
        'string'  => 'O campo :attribute debe ter entre :min e :max caracteres.',
        'array'   => 'O campo :attribute debe ter entre :min e :max elementos.',
    ],
    'boolean'              => 'O campo :attribute debe ser verdadeiro ou falso.',
    'confirmed'            => 'A confirmación de :attribute non coincide.',
    'date'                 => 'O campo :attribute non é unha data válida.',
    'date_equals'          => 'O campo :attribute debe ser unha data igual a :date.',
    'date_format'          => 'O campo :attribute non se corresponde co formato :format.',
    'different'            => 'O campo :attribute e :other deben ser diferentes.',
    'digits'               => 'O campo :attribute debe ter :digits díxitos.',
    'digits_between'       => 'O campo :attribute debe ter entre :min e :max díxitos.',
    'dimensions'           => 'O campo :attribute ten dimensións de imaxe non válidas.',
    'distinct'             => 'O campo :attribute ten un valor duplicado.',
    'email'                => 'O campo :attribute debe ser unha dirección de correo válida.',
    'ends_with'            => 'O campo :attribute debe acabar con un dos seguintes: :values.',
    'exists'               => 'O campo :attribute seleccionado non é válido.',
    'file'                 => 'O campo :attribute debe ser un ficheiro.',
    'filled'               => 'O campo :attribute é obrigaorio.',
    'gt'                   => [
        'numeric' => 'O campo :attribute debe ser maior que :value.',
        'file'    => 'O campo :attribute debe ser maior que :value kilobytes.',
        'string'  => 'O campo :attribute debe ter máis de :value caracteres.',
        'array'   => 'O campo :attribute debe ter máis de :value elementos.',
    ],
    'gte'                  => [
        'numeric' => 'O campo :attribute debe ser maior ou igual a :value.',
        'file'    => 'O campo :attribute debe ser maior ou igual a :value kilobytes.',
        'string'  => 'O campo :attribute debe ter :value caracteres ou máis.',
        'array'   => 'O campo :attribute debe ter :value elementos ou máis.',
    ],
    'image'                => 'O campo :attribute debe ser unha imaxe.',
    'in'                   => 'O campo :attribute é inválido.',
    'in_array'             => 'O campo :attribute non existe en :other.',
    'integer'              => 'O campo :attribute debe ser un número enteiro.',
    'ip'                   => 'O campo :attribute debe ser unha dirección IP válida.',
    'ipv4'                 => 'O campo :attribute debe ser unha dirección IPv4 válida.',
    'ipv6'                 => 'O campo :attribute debe ser unha dirección IPv6 válida.',
    'json'                 => 'O campo :attribute debe ser unha cadea JSON válida.',
    'lt'                   => [
        'numeric' => 'O campo :attribute debe ser menor que :value.',
        'file'    => 'O campo :attribute debe ser menor que :value kilobytes.',
        'string'  => 'O campo :attribute debe ter menos de :value caracteres.',
        'array'   => 'O campo :attribute debe ter menos de :value elementos.',
    ],
    'lte'                  => [
        'numeric' => 'O campo :attribute debe ser menor ou igual que :value.',
        'file'    => 'O campo :attribute debe ser menor ou igual que :value kilobytes.',
        'string'  => 'O campo :attribute debe ter :value caracteres ou menos.',
        'array'   => 'O campo :attribute non debe ter máis de :value elementos.',
    ],
    'max'                  => [
        'numeric' => 'O campo :attribute non pode ser maior que :max.',
        'file'    => 'O campo :attribute non pode ser maior que :max kilobytes.',
        'string'  => 'O campo :attribute non pode ter máis de :max caracteres.',
        'array'   => 'O campo :attribute non pode ter máis de :max elementos.',
    ],
    'mimes'                => 'O campo :attribute debe ser un ficheiro do tipo: :values.',
    'mimetypes'            => 'O campo :attribute debe ser un ficheiro do tipo: :values.',
    'min'                  => [
        'numeric' => 'O campo :attribute debe ter polo menos :min.',
        'file'    => 'O campo :attribute debe ter polo menos :min kilobytes.',
        'string'  => 'O campo :attribute debe ter polo menos :min caracteres.',
        'array'   => 'O campo :attribute debe ter polo menos :min elementos.',
    ],
    'not_in'               => 'O campo :attribute seleccionado é inválido.',
    'not_regex'            => 'O formato do campo :attribute é inválido.',
    'numeric'              => 'O campo :attribute debe ser un número.',
    'password'             => 'A contrasinal é incorrecta.',
    'present'              => 'O campo :attribute debe estar presente.',
    'regex'                => 'O formato do campo :attribute é inválido.',
    'required'             => 'O campo :attribute é obligatorio.',
    'required_if'          => 'O campo :attribute é obligatorio cando :other é :value.',
    'required_unless'      => 'O campo :attribute é obligatorio a non ser que :other estea en :values.',
    'required_with'        => 'O campo :attribute é obligatorio cando :values está presente.',
    'required_with_all'    => 'O campo :attribute é obligatorio cando :values están presentes.',
    'required_without'     => 'O campo :attribute é obligatorio cando :values non está presente.',
    'required_without_all' => 'O campo :attribute é obligatorio cando ningún de :values está presente.',
    'same'                 => 'O campo :attribute e :other deben coincidir.',
    'size'                 => [
        'numeric' => 'O campo :attribute debe ser :size.',
        'file'    => 'O campo :attribute debe ter :size kilobytes.',
        'string'  => 'O campo :attribute debe ter :size caracteres.',
        'array'   => 'O campo :attribute debe conter :size elementos.',
    ],
    'starts_with'          => 'O campo :attribute debe comezar con un dos seguintes: :values',
    'string'               => 'O campo :attribute debe ser unha cadea de texto.',
    'timezone'             => 'O campo :attribute debe ser unha zona horaria válida.',
    'unique'               => 'O campo :attribute xa foi usado.',
    'uploaded'             => 'O campo :attribute fallou ao subir.',
    'url'                  => 'O formato do campo :attribute é inválido.',
    'uuid'                 => 'O campo :attribute debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Linhas Personalizadas de Linguaxe de Validación
    |--------------------------------------------------------------------------
    |
    | Aquí podes especificar mensaxes de validación personalizadas para atributos
    | usando a convención "attribute.rule" para nomear as liñas. Isto facilita
    | especificar unha mensaxe de linguaxe persoalizada para unha regra de atributo.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atributos de Validación Personalizados
    |--------------------------------------------------------------------------
    |
    | As seguintes liñas serán usadas para substituír os place-holders dos atributos
    | por nomes máis amigables. Por exemplo, en vez de mostrar "check_in" no
    | mensaxe de erro, mostrará "hora de entrada".
    |
    */

    'attributes' => [
        'check_in'            => 'Hora de entrada',
        'check_out'           => 'Hora de saída',
        'pause_start'         => 'Inicio da pausa',
        'pause_end'           => 'Fin da pausa',
        'ordinary_hours'      => 'Horas ordinarias',
        'complementary_hours' => 'Horas complementarias',
        'overtime_hours'      => 'Horas extraordinarias',
        'pause_minutes'       => 'Minutos da pausa',
        'modification_reason' => 'Motivo da modificación',
    ],

];

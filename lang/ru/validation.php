<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Значение должно быть принято.',
    'accepted_if' => 'Значение должно быть принято, если :other равно :value.',
    'active_url' => 'Значение должно быть действительным URL.',
    'after' => 'Значение должно быть датой после :date.',
    'after_or_equal' => 'Значение должно быть датой после или равной :date.',
    'alpha' => 'Значение должно содержать только буквы',
    'alpha_dash' => 'Значение должно содержать только буквы, цифры, тире и символы подчеркивания',
    'alpha_num' => 'Значение должно содержать только буквы и цифры',
    'array' => 'Значение должно быть массивом',
    'ascii' => 'Значение должно содержать только однобайтовые алфавитно-цифровые символы и знаки.',
    'before' => 'Значение должно быть датой, предшествующей :date.',
    'before_or_equal' => 'Значение должно быть датой, предшествующей или равной :date.',
    'between' => [
        'array' => 'Значение должно иметь от :min до :max элементов.',
        'file' => 'Значение должно иметь размер от :min до :max килобайт.',
        'numeric' => 'Значение должно находиться в диапазоне от :min до :max.',
        'string' => 'Значение должно содержать от :min до :max символов.',
    ],
    'boolean' => 'Значение должно быть true или false.',
    'can' => 'Значение содержит неавторизовано.',
    'confirmed' => 'Подтверждение поля не совпадает.',
    'current_password' => 'Пароль неверен.',
    'date' => 'Значение должно быть действительной датой.',
    'date_equals' => 'Значение должно быть датой, равной :date.',
    'date_format' => 'Значение должно соответствовать формату :format.',
    'decimal' => 'Значение должно иметь :decimal знаков после запятой.',
    'declined' => 'Значение должно быть отклонено.',
    'declined_if' => 'Значение должно быть отклонено, если :other равно :value.',
    'different' => 'Значение и :other должны быть разными.',
    'digits' => 'Значение должно иметь :digits цифр.',
    'digits_between' => 'Значение должно быть между :min и :max цифрами.',
    'dimensions' => 'Значение имеет недопустимые размеры изображения.',
    'distinct' => 'Значение имеет дублирующее значение.',
    'doesnt_end_with' => 'Значение не должно заканчиваться одним из следующих значений: :values.',
    'doesnt_start_with' => 'Значение не должно начинаться с одного из следующих слов: :values.',
    'email' => 'Значение должно быть действительным адресом электронной почты.',
    'ends_with' => 'Значение должно заканчиваться одним из следующих значений: :values.',
    'enum' => 'Выбранное значение недействительно.',
    'exists' => 'Выбранное значение не существует.',
    'extensions' => 'Значение должно иметь одно из следующих расширений: :values.',
    'file' => 'Значение должно быть файлом.',
    'filled' => 'Значение должно иметь значение.',
    'gt' => [
        'array' => 'Значение должно иметь больше элементов, чем :value.',
        'file' => 'Значение должно быть больше, чем :value килобайт.',
        'numeric' => 'Значение должно быть больше, чем :value.',
        'string' => 'Значение должно быть больше, чем :value символов.',
    ],
    'gte' => [
        'array' => 'Значение должно иметь :value элементов или более.',
        'file' => 'Значение должно быть больше или равно :value килобайт.',
        'numeric' => 'Значение должно быть больше или равно :value.',
        'string' => 'Значение должно быть больше или равно :value символам.',
    ],
    'hex_color' => 'Значение должно быть правильным шестнадцатеричным цветом.',
    'image' => 'Значение должно быть изображением.',
    'in' => 'Выбранное значение недействительно.',
    'in_array' => 'Значение должно существовать в :other.',
    'integer' => 'Значение должно быть целым числом.',
    'ip' => 'Значение должно быть действительным IP-адресом.',
    'ipv4' => 'Значение должно быть действительным IPv4-адресом',
    'ipv6' => 'Значение должно быть действительным IPv6-адресом.',
    'json' => 'Значение должно быть корректной строкой JSON.',
    'lowercase' => 'Значение должно быть в нижнем регистре.',
    'lt' => [
        'array' => 'Значение должно иметь меньше :value элементов.',
        'file' => 'Значение должно быть меньше :value килобайт.',
        'numeric' => 'Значение должно быть меньше, чем :value.',
        'string' => 'Значение должно быть меньше, чем :value символов.',
    ],
    'lte' => [
        'array' => 'Значение не должно иметь больше элементов, чем :value.',
        'file' => 'Значение должно быть меньше или равно :value килобайт.',
        'numeric' => 'Значение должно быть меньше или равно :value.',
        'string' => 'Значение должно быть меньше или равно :value символам.',
    ],
    'mac_address' => 'Значение должно быть действительным MAC-адресом.',
    'max' => [
        'array' => 'Значение не должно иметь более :max элементов.',
        'file' => 'Значение не должно быть больше, чем :max килобайт.',
        'numeric' => 'Значение не должно быть больше, чем :max.',
        'string' => 'Значение не должно быть больше, чем :max символов.',
    ],
    'max_digits' => 'Значение не должно содержать более :max цифр.',
    'mimes' => 'Значение должно быть файлом типа: :values.',
    'mimetypes' => 'Значение должно быть файлом типа: :values.',
    'min' => [
        'array' => 'Значение должно иметь не менее :min элементов.',
        'file' => 'Значение должно быть не менее :min килобайт.',
        'numeric' => 'Значение должно быть не меньше :min.',
        'string' => 'Значение должно содержать не менее :min символов.',
    ],
    'min_digits' => 'Значение должно содержать не менее :min цифр.',
    'missing' => 'Значение должно отсутствовать.',
    'missing_if' => 'Значение должно отсутствовать, если :other равно :value.',
    'missing_unless' => 'Значение должно отсутствовать, если :other не равно :value.',
    'missing_with' => 'Значение должно отсутствовать, если присутствует :values.',
    'missing_with_all' => 'Значение должно отсутствовать, если присутствуют :values.',
    'multiple_of' => 'Значение должно быть кратно :value.',
    'not_in' => 'Выбранный :атрибут недействителен.',
    'not_regex' => 'Формат поля недействителен.',
    'numeric' => 'Значение должно быть числом',
    'password' => [
        'letters' => 'Значение должно содержать хотя бы одну букву',
        'mixed' => 'Значение должно содержать как минимум одну заглавную и одну строчную букву.',
        'numbers' => 'Значение должно содержать хотя бы одно число',
        'symbols' => 'Значение должно содержать хотя бы один символ',
        'uncompromised' => 'Данное значение оказалось в утечке данных. Пожалуйста, выберите другой.',
    ],
    'present' => 'Значение должно присутствовать.',
    'present_if' => 'Значение должно присутствовать, если :other равно :value.',
    'present_unless' => 'Значение должно присутствовать, если :other не является :value.',
    'present_with' => 'Значение должно присутствовать, если присутствует :values.',
    'present_with_all' => 'Значение должно присутствовать, когда присутствуют :values.',
    'prohibited' => 'Значение запрещено.',
    'prohibited_if' => 'Значение запрещено, если :other равно :value.',
    'prohibited_unless' => 'Значение запрещено, если в :values не указано :other.',
    'prohibits' => 'Значение запрещает присутствие :other.',
    'regex' => 'Формат поля недействителен.',
    'required' => 'Значение является обязательным.',
    'required_array_keys' => 'Значение должно содержать записи для: :values.',
    'required_if' => 'Значение обязательно, если :other равно :value.',
    'required_if_accepted' => 'Значение требуется, если принято :other.',
    'required_unless' => 'Значение обязательно, если в :values не указано :other.',
    'required_with' => 'Значение обязательно для заполнения, если присутствует :values.',
    'required_with_all' => 'Значение обязательно для заполнения, если присутствуют :values.',
    'required_without' => 'Значение обязательно для заполнения, если отсутствует :values.',
    'required_without_all' => 'Значение обязательно для заполнения, если ни одно из :values не присутствует.',
    'same' => 'Значение должно совпадать с полем :other.',
    'sand' => 'Значение должно содержать только буквы, цифры и тире.',
    'size' => [
        'array' => 'Значение должно содержать :size элементов.',
        'file' => 'Значение должно быть :size килобайт.',
        'numeric' => 'Значение должно быть :size.',
        'string' => 'Значение должно содержать :size символов.',
    ],
    'starts_with' => 'Значение должно начинаться с одного из следующих слов: :values.',
    'string' => 'Значение должно быть строкой.',
    'timezone' => 'Значение должно быть действительным часовым поясом.',
    'unique' => 'Значение занят',
    'uploaded' => 'Данные не загружены.',
    'uppercase' => 'Значение должно быть в верхнем регистре.',
    'url' => 'Значение должно быть действительным URL.',
    'ulid' => 'Значение должно быть действительным ULID.',
    'uuid' => 'Значение должно быть действительным UUID.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];

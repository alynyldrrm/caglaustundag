<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Doğrulama Dil İfadeleri
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil ifadeleri, doğrulayıcı sınıfı tarafından kullanılan varsayılan hata iletilerini içerir.
    | Bazı kuralların boyut kuralları gibi birden fazla versiyonu bulunabilir.
    | Bu ifadeleri istediğiniz gibi düzenleyebilirsiniz.
    |
    */

    'accepted' => ':attribute alanı kabul edilmelidir.',
    'accepted_if' => ':attribute alanı, :other :value olduğunda kabul edilmelidir.',
    'active_url' => ':attribute alanı geçerli bir URL olmalıdır.',
    'after' => ':attribute alanı, :date tarihinden sonra bir tarih olmalıdır.',
    'after_or_equal' => ':attribute alanı, :date tarihinden sonra veya ona eşit bir tarih olmalıdır.',
    'alpha' => ':attribute alanı yalnızca harfler içerebilir.',
    'alpha_dash' => ':attribute alanı yalnızca harfler, rakamlar, tireler ve alt çizgiler içerebilir.',
    'alpha_num' => ':attribute alanı yalnızca harfler ve rakamlar içerebilir.',
    'array' => ':attribute alanı bir dizi olmalıdır.',
    'ascii' => ':attribute alanı yalnızca tek baytlık alfasayısal karakterler ve semboller içerebilir.',
    'before' => ':attribute alanı, :date tarihinden önce bir tarih olmalıdır.',
    'before_or_equal' => ':attribute alanı, :date tarihinden önce veya ona eşit bir tarih olmalıdır.',
    'between' => [
        'array' => ':attribute alanı :min ile :max arasında öğe içermelidir.',
        'file' => ':attribute alanı :min ile :max kilobayt arasında olmalıdır.',
        'numeric' => ':attribute alanı :min ile :max arasında olmalıdır.',
        'string' => ':attribute alanı :min ile :max karakter arasında olmalıdır.',
    ],
    'boolean' => ':attribute alanı true veya false olmalıdır.',
    'can' => ':attribute alanı yetkisiz bir değer içeriyor.',
    'confirmed' => ':attribute alanı onay eşleşmiyor.',
    'current_password' => 'Parola geçersiz.',
    'date' => ':attribute alanı geçerli bir tarih olmalıdır.',
    'date_equals' => ':attribute alanı, :date tarihine eşit bir tarih olmalıdır.',
    'date_format' => ':attribute alanı, :format formatına uymalıdır.',
    'decimal' => ':attribute alanı :decimal ondalık basamağa sahip olmalıdır.',
    'declined' => ':attribute alanı reddedilmelidir.',
    'declined_if' => ':attribute alanı, :other :value olduğunda reddedilmelidir.',
    'different' => ':attribute alanı ve :other farklı olmalıdır.',
    'digits' => ':attribute alanı :digits basamaklı olmalıdır.',
    'digits_between' => ':attribute alanı en az :min en fazla :max basamaklı olmalıdır.',
    'dimensions' => ':attribute alanının geçersiz resim boyutları var.',
    'distinct' => ':attribute alanının yinelenen bir değeri var.',
    'doesnt_end_with' => ':attribute alanı şunlardan biriyle bitmemelidir: :values.',
    'doesnt_start_with' => ':attribute alanı şunlardan biriyle başlamamalıdır: :values.',
    'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
    'ends_with' => ':attribute alanı şunlardan biriyle bitmelidir: :values.',
    'enum' => 'Seçilen :attribute geçerli değil.',
    'exists' => 'Seçilen :attribute geçerli değil.',
    'file' => ':attribute alanı bir dosya olmalıdır.',
    'filled' => ':attribute alanı bir değere sahip olmalıdır.',
    'gt' => [
        'array' => ':attribute alanı :value öğeden daha fazla öğe içermelidir.',
        'file' => ':attribute alanı :value kilobayttan daha büyük olmalıdır.',
        'numeric' => ':attribute alanı :value değerinden daha büyük olmalıdır.',
        'string' => ':attribute alanı :value karakterden daha fazla karakter içermelidir.',
    ],
    'gte' => [
        'array' => ':attribute alanı en az :value öğe içermelidir.',
        'file' => ':attribute alanı en az :value kilobayt olmalıdır.',
        'numeric' => ':attribute alanı :value değerine eşit veya daha büyük olmalıdır.',
        'string' => ':attribute alanı :value karaktere eşit veya daha fazla olmalıdır.',
    ],
    'image' => ':attribute alanı bir resim olmalıdır.',
    'in' => 'Seçilen :attribute geçerli değil.',
    'in_array' => ':attribute alanı :other içinde bulunmalıdır.',
    'integer' => ':attribute alanı bir tam sayı olmalıdır.',
    'ip' => ':attribute alanı geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute alanı geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute alanı geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute alanı geçerli bir JSON dizesi olmalıdır.',
    'lowercase' => ':attribute alanı küçük harflerden oluşmalıdır.',
    'lt' => [
        'array' => ':attribute alanı :value öğeden daha az öğe içermelidir.',
        'file' => ':attribute alanı :value kilobayttan daha küçük olmalıdır.',
        'numeric' => ':attribute alanı :value değerinden daha küçük olmalıdır.',
        'string' => ':attribute alanı :value karakterden daha az karakter içermelidir.',
    ],
    'lte' => [
        'array' => ':attribute alanı en fazla :value öğe içermelidir.',
        'file' => ':attribute alanı en fazla :value kilobayt olmalıdır.',
        'numeric' => ':attribute alanı :value değerine eşit veya daha küçük olmalıdır.',
        'string' => ':attribute alanı :value karaktere eşit veya daha az olmalıdır.',
    ],
    'mac_address' => ':attribute alanı geçerli bir MAC adresi olmalıdır.',
    'max' => [
        'array' => ':attribute alanı en fazla :max öğe içermelidir.',
        'file' => ':attribute alanı :max kilobayttan daha büyük olmamalıdır.',
        'numeric' => ':attribute alanı :max değerinden daha büyük olmamalıdır.',
        'string' => ':attribute alanı :max karakterden fazla olmamalıdır.',
    ],
    'max_digits' => ':attribute alanı en fazla :max basamak içermelidir.',
    'mimes' => ':attribute alanı :values türünde bir dosya olmalıdır.',
    'mimetypes' => ':attribute alanı :values türünde bir dosya olmalıdır.',
    'min' => [
        'array' => ':attribute alanı en az :min öğe içermelidir.',
        'file' => ':attribute alanı en az :min kilobayt olmalıdır.',
        'numeric' => ':attribute alanı en az :min olmalıdır.',
        'string' => ':attribute alanı en az :min karakter olmalıdır.',
    ],
    'min_digits' => ':attribute alanı en az :min basamak içermelidir.',
    'missing' => ':attribute alanı eksik olmalıdır.',
    'missing_if' => ':other :value olduğunda :attribute alanı eksik olmalıdır.',
    'missing_unless' => ':other :value değilse :attribute alanı eksik olmalıdır.',
    'missing_with' => ':values mevcutsa :attribute alanı eksik olmalıdır.',
    'missing_with_all' => ':values mevcutsa :attribute alanı eksik olmalıdır.',
    'multiple_of' => ':attribute alanı :value değerinin katlarından olmalıdır.',
    'not_in' => 'Seçilen :attribute geçerli değil.',
    'not_regex' => ':attribute alan biçimi geçerli değil.',
    'numeric' => ':attribute alanı bir sayı olmalıdır.',
    'password' => [
        'letters' => ':attribute alanı en az bir harf içermelidir.',
        'mixed' => ':attribute alanı en az bir büyük harf ve bir küçük harf içermelidir.',
        'numbers' => ':attribute alanı en az bir sayı içermelidir.',
        'symbols' => ':attribute alanı en az bir sembol içermelidir.',
        'uncompromised' => 'Verilen :attribute bir veri sızıntısında göründü. Lütfen farklı bir :attribute seçin.',
    ],
    'present' => ':attribute alanı mevcut olmalıdır.',
    'prohibited' => ':attribute alanı yasaklanmıştır.',
    'prohibited_if' => ':other :value olduğunda :attribute alanı yasaklanmıştır.',
    'prohibited_unless' => ':other :values içinde bulunmadığı sürece :attribute alanı yasaklanmıştır.',
    'prohibits' => ':attribute alanı :other varlığını engeller.',
    'regex' => ':attribute alan biçimi geçerli değil.',
    'required' => ':attribute alanı gereklidir.',
    'required_array_keys' => ':attribute alanı için şunlar içermelidir: :values.',
    'required_if' => ':other :value olduğunda :attribute alanı gereklidir.',
    'required_if_accepted' => ':other kabul edildiğinde :attribute alanı gereklidir.',
    'required_unless' => ':other :values içinde bulunmadığı sürece :attribute alanı gereklidir.',
    'required_with' => ':values mevcutsa :attribute alanı gereklidir.',
    'required_with_all' => ':values mevcutsa :attribute alanı gereklidir.',
    'required_without' => ':values mevcut değilse :attribute alanı gereklidir.',
    'required_without_all' => ':values hiçbiri mevcut değilse :attribute alanı gereklidir.',
    'same' => ':attribute alanı ile :other eşleşmelidir.',
    'size' => [
        'array' => ':attribute alanı :size öğe içermelidir.',
        'file' => ':attribute alanı :size kilobayt olmalıdır.',
        'numeric' => ':attribute alanı :size olmalıdır.',
        'string' => ':attribute alanı :size karakter olmalıdır.',
    ],
    'starts_with' => ':attribute alanı şunlardan biriyle başlamalıdır: :values.',
    'string' => ':attribute alanı bir metin olmalıdır.',
    'timezone' => ':attribute alanı geçerli bir saat dilimi olmalıdır.',
    'unique' => ':attribute zaten alınmıştır.',
    'uploaded' => ':attribute yüklenemedi.',
    'uppercase' => ':attribute alanı büyük harf olmalıdır.',
    'url' => ':attribute alanı geçerli bir URL olmalıdır.',
    'ulid' => ':attribute alanı geçerli bir ULID olmalıdır.',
    'uuid' => ':attribute alanı geçerli bir UUID olmalıdır.',

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Dil İfadeleri
    |--------------------------------------------------------------------------
    |
    | Burada, öznitelik kuralları için özel dil iletileri belirtebilirsiniz.
    |
    */

    'custom' => [
        'öznitelik-adı' => [
            'kural-adı' => 'özel-ileti',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Öznitelikleri
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil ifadeleri, öznitelik yer tutucumuzu daha anlatıcı hale getirmemize yardımcı olur.
    |
    */

    'attributes' => [
        "text" => "Dil Adı",
        "key" => "Key",
        "is_default" => "Varsayılan",
        "role" => "Rol",
        "name" => "Ad",
        "email" => "E-Mail",
        "phone" => "Telefon",
        "role" => "Rol",
        "address" => "Adres",
        "password" => "Şifre",
        "imagePath" => "Resim",
        "filePath" => "Dosya",
        "single_name" => "Tekil Ad",
        "multiple_name" => "Çoğul Ad",
        "model" => "Model",
        "rendered_view" => "Render Edilecek View",
        "is_hidden" => "Gizlimi",
    ],

];

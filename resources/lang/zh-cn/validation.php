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

    "alert_message"         => "请正确填写表单内容",
    "accepted"         => "必须接受 :attribute.",
    "active_url"       => ":attribute 不是一个有效的URL.",
    "after"            => ":attribute 必须是一个在 :date 之后的日期.",
    "alpha"            => ":attribute 只能由字母组成.",
    "alpha_dash"       => ":attribute 只能由字母、数字和中划线组成.",
    "alpha_num"        => ":attribute 只能由字母和数字组成.",
    "array"            => ":attribute 必须是一个数组.",
    "before"           => ":attribute 必须是一个在 :date 之前的日期.",
    "between"          => array(
        "numeric" => ":attribute 必须介于 :min - :max 之间.",
        'file'    => ':attribute 大小必须在 :min 和 :max Kb 之间.',
        'string'  => ':attribute 字符数必须在 :min 和 :max 之间.',
        'array'   => ':attribute 条目数必须在 :min 和 :max 之间.',
    ),
    'boolean'          => ':attribute 字段必须为 true(真) 或 false(假).',
    'confirmed'        => ':attribute 与确认输入不一致.',
    "date"             => ":attribute 不是一个有效的日期.",
    'date_format'      => ':attribute 格式与 :format 不匹配.',
    "different"        => ":attribute 和 :other 必须不同.",
    "digits"           => ":attribute 必须是 :digits 位的数字.",
    "digits_between"   => ":attribute 必须是介于 :min 和 :max 位的数字.",
    'dimensions'           => ':attribute 是一个无效的图片尺寸.',
    'distinct'             => ':attribute 字段有重复的数值.',
    'email'                => ':attribute 必须为有效的 Email 地址.',
    "exists"           => ":attribute 已经存在.",
    'file'                 => ':attribute 必须是一个文件.',
    'filled'               => ':attribute 字段必须输入.',
    "image"            => ":attribute 必须是一张图片.",
    "in"               => "已选的属性 :attribute 非法.",
    'in_array'             => ':attribute 字段并不在 :other 之中.',
    "integer"          => ":attribute 必须是一个整数.",
    "ip"               => ":attribute 必须是一个有效的IP地址.",
    'json'                 => ':attribute 必须为有效的 JSON 字符串.',
    'max'                  => [
        'numeric' => ':attribute 不能大于 :max.',
        'file'    => ':attribute 不能大于 :max Kb.',
        'string'  => ':attribute 不能多于 :max 个字符.',
        'array'   => ':attribute 不能多于 :max 个条目.',
    ],
    "mimes"            => ":attribute 必须是一个 :values 类型的文件.",
    'min'                  => [
        'numeric' => ':attribute 不能小于 :min.',
        'file'    => ':attribute 不能小于 :min Kb.',
        'string'  => ':attribute 至少要 :min 个字符.',
        'array'   => ':attribute 至少要 :min 个条目.',
    ],
    "not_in"           => "已选的属性 :attribute 无效.",
    "numeric"          => ":attribute 必须是一个数字.",
    'present'              => ':attribute 字段必须存在.',
    "regex"            => ":attribute 格式不正确.",
    "required"         => ":attribute 不能为空.",
    "required_if"      => "当 :other 为 :value 时 :attribute 不能为空.",
    'required_unless'      => ':attribute 字段为必需, 除非 :other 在 :values 之中.',
    "required_with"    => "当 :values 存在时 :attribute 不能为空.",
    "required_with_all" => " 当 :values 存在时 :attribute 不能为空.",
    "required_without" => "当 :values 不存在时 :attribute 不能为空.",
    "required_without_all" => "当 :values 都不存在时 :attribute 不能为空.",
    "same"             => ":attribute 和 :other 必须匹配.",
    'size'                 => [
        'numeric' => ':attribute 必须为 :size.',
        'file'    => ':attribute 必须为 :size Kb.',
        'string'  => ':attribute 必须为 :size 个字符.',
        'array'   => ':attribute 必须含有 :size 个条目.',
    ],
    'string'               => ':attribute 必须为字符串.',
    "timezone"         => ":attribute 必须是一个合法的时区值.",
    "unique"           => ":attribute 已经存在.",
    'uploaded'             => ':attribute 上传失败.',
    "url"              => ":attribute 不是一个合法的URL.",

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
            'rule-name' => '自定义信息',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => include(__DIR__ . '/field.php'),

];

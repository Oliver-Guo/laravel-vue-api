<?php

return [
    'timestamps'        => '20180611',
    'validatorMessages' => ['required' => ':attribute的欄位是必填的。',
        'max'                              => ':attribute的最大值是:max。',
        'min'                              => ':attribute的最小值是:min',
        'integer'                          => ':attribute的欄位是整數的。',
        'mimes'                            => ':attribute的檔案類型必須是:jpeg,png。',
        'after'                            => ':attribute日期必須大於開始日期',
        'required_if'                      => ':attribute的欄位是必填的',
        'unique'                           => ':attribute的欄位值已經存在',
        'confirmed'                        => ':attribute的欄位值不相等',
    ],
];

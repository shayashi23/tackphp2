<?php

// バリデーションテスト用
class SickmanController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($message = "Hello")
    {

        $validation_errors = self::execValidation(Request::getParams("GET"));
        if (!empty($validation_errors)) {
            $this->error($validation_errors);
        }

        $this->render();

    }

    // 特定のコントローラだけで使うバリデーションルールは分けて定義できる
    protected static function setValidationRules()
    {

        parent::setValidationRules();

        /* バリデーションルールはこちらに追加してください */

        self::$validation->add('page', 'ページ')
            ->addRule('required_param')
            ->addRule('required_form')
            ->addRule('valid_string', ['numeric']);

        self::$validation->add('email', 'メールアドレス')
            ->addRule('valid_email');

    }

}

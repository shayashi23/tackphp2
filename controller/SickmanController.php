<?php

// バリデーションテスト
class SickmanController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        self::setValidationRules();

        // GETパラメータに対し、バリデーションを実行
        $v_errors = self::execValidation(Request::getParams("GET"));
        if (!empty($v_errors)) $this->error($v_errors);

    }

    public function index($message = "Hello")
    {
        self::set('article_list', [1,2,3]);
    }

    /**
     * コントローラ固有のバリデーションルールを定義
     */
    protected static function setValidationRules()
    {

        /**
         * 親コントローラの定義を継承
         * （同じルールを再定義した場合、ルールは上書きされます）
         */
        parent::setValidationRules();

        /** バリデーションルール */
        self::$validation->add('page', 'ページ')
            ->addRule('required_param')
            ->addRule('required_form')
            ->addRule('valid_string', ['numeric']);

        self::$validation->add('api', 'APIキー')
            ->addRule('valid_string', ['alpha', 'numeric']);

    }
}

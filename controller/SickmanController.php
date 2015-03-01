<?php

// バリデーションテスト
class SickmanController extends BaseController
{

    protected $validation2;

    public function __construct()
    {
        parent::__construct();
        $this->setValidationRules();

        // GETパラメータに対し、バリデーションを実行
        $this->validation_errors = $this->runValidation($this->validation, Request::getParams("GET"));
        if (!empty($this->validation_errors)) $this->error($this->validation_errors);

    }

    public function index($message = "Hello")
    {

        /*
        $this->validation2 = new Validation();
        $this->validation2->add('page2', 'ページ2')
            ->addRule('required_param')
            ->addRule('required_form')
            ->addRule('valid_string', ['numeric']);
        $v_errors = $this->runValidation($this->validation2, ['page2'=>'aあ']);
        if (!empty($v_errors)) $this->error($v_errors);
        */

        self::set('article_list', [1,2,3]);

    }

    /**
     * コントローラ固有のバリデーションルールを定義
     */
    protected function setValidationRules()
    {

        /**
         * 親コントローラの定義を継承
         * （同じルールを再定義した場合、ルールは上書きされます）
         */
        parent::setValidationRules();

        /** バリデーションルール */
        $this->validation->add('page', 'ページ')
            ->addRule('required_param')
            ->addRule('required_form')
            ->addRule('valid_string', ['numeric']);

        $this->validation->add('api', 'APIキー')
            ->addRule('valid_string', ['alpha', 'numeric']);

    }
}

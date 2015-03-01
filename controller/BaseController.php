<?php

class BaseController extends Controller
{

    protected static $is_api;
    protected $validation;

    public function __construct()
    {
        parent::__construct();
        $this->validation = new Validation();
        $this->setValidationRules();
        self::$is_api = (!empty($_GET["api"]) && $_GET["api"] == API_KEY);
        self::set('server_info', BaseModel::getServerInfo());
    }

    public function before()
    {
    }

    public function after()
    {
        (self::$is_api) ? JsonApi::output() : $this->render();
    }


    /**
     * 共通で使用するバリデーションルールを定義
     */
    protected function setValidationRules()
    {

        /** バリデーションルール */
        $this->validation->add('page', 'ページ')
            ->addRule('required')
            ->addRule('min_length', 1)
            ->addRule('max_length', 3)
            ->addRule('valid_string', ['numeric']);

        $this->validation->add('limit', '表示件数')
            ->addRule('required')
            ->addRule('numeric_min', 1)
            ->addRule('numeric_max', 100)
            ->addRule('valid_string', ['numeric']);

        $this->validation->add('ip', 'IPアドレス')
            ->addRule('required_param')
            ->addRule('valid_ip');

        $this->validation->add('url', 'URL')
            ->addRule('valid_url');

    }

    protected function runValidation($rule_set, $params)
    {
        $error_messages = (!$rule_set->run($params)) ? $rule_set->showErrors() : null;
        if (empty($error_messages)) {
            return false;
        }

        // TODO エラー文を配列で受け取ってくれないっぽいので、とりあえず平文に。
        $tackphp_error_message = "";
        foreach ($error_messages as $error_message) {
            $tackphp_error_message .= $error_message . "<br>";
        }

        return $tackphp_error_message;
    }
}

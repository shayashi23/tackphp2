<?php

class BaseController extends Controller
{

    protected static $is_api;
    protected static $validation;

    public function __construct()
    {
        parent::__construct();
        self::$validation = new Validation();
        self::setValidationRules();
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
    protected static function setValidationRules()
    {

        /** バリデーションルール */
        self::$validation->add('page', 'ページ')
            ->addRule('required')
            ->addRule('min_length', 1)
            ->addRule('max_length', 3)
            ->addRule('valid_string', ['numeric']);

        self::$validation->add('limit', '表示件数')
            ->addRule('required')
            ->addRule('numeric_min', 1)
            ->addRule('numeric_max', 100)
            ->addRule('valid_string', ['numeric']);

        self::$validation->add('ip', 'IPアドレス')
            ->addRule('required_param')
            ->addRule('valid_ip');
        self::$validation->add('url', 'URL')
            ->addRule('valid_url');

    }

    protected function execValidation($params)
    {
        $error_messages = (!self::$validation->run($params)) ? self::$validation->showErrors() : null;
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

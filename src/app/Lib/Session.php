<?php

namespace App\Lib;

/**
 * セッション情報の操作をするシングルトンクラス
 */
final class Session
{
    /**
     * 任意キーの設定
     */
    private const ERROR_KEY = 'errors';
    private const FROM_INPUTS_KEY = 'formInputs';
    private const MESSAGE_KEY = 'message';
    private static $instance;

    /**
     *  シングルトンクラスはnewさせないからprivate
     */
    private function __construct()
    {
    }


    /**
     *  1回目なら自信のインスタンスを生成し返す。
     *  セッションの開始。
     *  セッション処理が開始されてなければ開始する
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        self::start();
        return self::$instance;
    }


    /**
     * @return void
     */
    private static function start(): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }


    /**
     * セッションにエラーを追加
     *
     * @param string $errorMessage エラー文
     * @return void
     */
    public function appendError(string $errorMessage): void
    {
        $_SESSION[self::ERROR_KEY][] = $errorMessage;
    }


    /**
     * セッションに追加されてるエラーを返す
     * pop : 取り出す
     *
     * @return array
     */
    public function popAllErrors(): array
    {
        $errors = $_SESSION[self::ERROR_KEY] ?? [];
        $this->clear(self::ERROR_KEY);
        return $errors;
    }


    /** セッションにエラーがあったらtrue、なかったらfalse返す
     * @return bool
     */
    public function existsErrors(): bool
    {
        return !empty($_SESSION[self::MESSAGE_KEY]);
    }


    /** 引数で受け取ったキーのセッションのデータを削除
     *
     * @param string $sessionKey セッションキー
     * @return void
     */
    public function clear(string $sessionKey): void
    {
        unset($_SESSION[$sessionKey]);
    }


    /**
     * 入力されたフォームデータをセッションへ
     *
     * @param array formInputs フォーム入力した値
     * @return void
     */
    public function setFormInputs(array $formInputs): void
    {
        foreach ($formInputs as $key => $formInput) {
            $_SESSION[self::FROM_INPUTS_KEY][$key] = $formInput;
        }
    }


    /**
     * セッションのフォームデータを返す
     *
     * @return array
     */
    public function getFormInputs(): array
    {
        return $_SESSION[self::FROM_INPUTS_KEY] ?? [];
    }


    /**
     * セッションのメッセージデータを保存
     *
     * @param string $message セッションのメッセージキー
     * @return void
     */
    public function setMessage(string $message): void
    {
        $_SESSION[self::MESSAGE_KEY] = $message;
    }


    /**
     * セッションのメッセーデータを返す
     *
     * @return string
     */
    public function getMessage(): string
    {
        $message = $_SESSION[self::MESSAGE_KEY] ?? '';
        $this->clear(self::MESSAGE_KEY);
        return $message;
    }
}

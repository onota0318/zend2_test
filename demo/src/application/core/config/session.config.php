<?php
/*****************************************************/
/*    S E S S I O N   C O U N F I G U R A T I O N    */
/*****************************************************/

use Onota0318\Library\UserAgentNavigator;

return array(
    /**
     * @var string
     * 使用されるセッション名を指定
     */
    'name' => $env->session_name,

    /**
     * @var integer 
     * キャッシュされたセッションの存続期間を分数で指定
     */
    'cache_expire' => 10,

    /**
     * @var string
     * セッションクッキーに設定するドメインを指定
     */
    'cookie_domain' => $env->session_cookie_domain,

    /**
     * @var boolean
     * HTTPでのみアクセス可能なクッキーをマーク
     */
    'cookie_httponly' => true,

    /**
     * @var integer
     * ブラウザに送信されるクッキーの存続期間を秒数で指定
     */
    'cookie_lifetime' => 0,

    /**
     * @var string
     * セッションクッキーに設定するパスを指定
     */
    'cookie_path' => "/",

    /**
     * @var boolean
     * セキュアなクッキーとして扱うか指定
     * SSL配下である場合のみ有効にしておく
     */
    'cookie_secure' => $env->isHttps(),

    /**
     * @var boolean
     * クッキーを使用するか指定
     * ガラケー以外はtrueにしておく
     */
    'use_cookies' => !UserAgentNavigator::isFeaturePhone(),

    /**
     * @var string
     * セッションページに使用するcache-controllを指定
     */
    'cache_limiter' => "",

    /**
     * @var stirng 
     * セッションIDを生成するアルゴリズムを指定
     * hash_algos()で取得できるハッシュアルゴリズムの一覧にあればOK
     * @see http://php.net/manual/ja/function.hash-algos.php
     */
    'hash_function' => "sha256",

    /**
     * @var integer
     * entropy_fileで指定されたファイルから読み込まれたバイト数を指定
     */
//    'entropy_length' => 0,

    /**
     * @var string
     * 追加で使用する外部リソースへのパスを指定
     */
//    'entropy_file' => "",

    /**
     * @var integer
     * データが不要になるまでの秒数を指定
     */
    'gc_maxlifetime' => 86400,

    /**
     * @var integer
     * どの位の頻度でGCを起動させるのか、の割合を指定
     */
    'gc_divisor' => 20,

    /**
     * @var integer
     * どの位の頻度でGCを起動させるのか、の確率を指定
     */
//    'gc_probability' => 100,

    /**
     * @var integer
     * バイナリのハッシュデータを扱う際のビット数を指定
     */
//    'hash_bits_per_character' => 10,

    /**
     * @var integer
     * データをクリアする前に。セッションを保持しておく期間を指定
     */
    'remember_me_seconds' => (24 * 60 * 60 * 60),

    /**
     * @var string
     * 保存ハンドラに渡される引数を指定
     */
//    'save_path' => "",

    /**
     * @var string 
     * PHP組み込みのsave_handlerの名前を指定
     */
//    'php_save_handler' => "",

    /**
     * @var string
     * データのシリアライズに使用されるハンドラ名を指定
     */
//    'serialize_handler' => "",

    /**
     * @var string 
     * セッションIDを含むように書き換えるHTMLタグを指定
     */
//    'url_rewrite_tags' => "",

    /**
     * @var boolean
     * SID(PHPSESSIDというキー名)を隠すことが可能かどうか指定
     * trueの場合、nameで指定したキーになる
     * ※PHPであることを隠す為にもココはtrue固定※
     */
    'use_trans_sid' => true,
);

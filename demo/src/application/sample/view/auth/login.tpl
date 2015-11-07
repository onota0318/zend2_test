<html>
<head>
    <content-type="text/html charset='UTF-8'">
    <title>Sampleフォーム ログイン</title>
</head>
<body>
    {include $GlobalScreenHolder->header}
    <h1>Sampleフォーム ログイン</h1>
{if $this->errors()->has("auth")}
    <font color="red">{$this->errors()->show("auth")}</font>
{/if}
    <form action="/demo/sample/auth/authenticate" method="POST">
        <dl>
            <dd>ID</dd>
            <dd><input type="text" name="login_id" value=""></dd>
            <dd>&nbsp;</dd>
            <dd>パスワード</dd>
            <dd><input type="password" name="login_pw" value=""></dd>
            <dd>&nbsp;</dd>
            <dd><input type="submit" value="　ログイン　"></dd>
        </dl>
    </form>
    {include $GlobalScreenHolder->footer}
</body>

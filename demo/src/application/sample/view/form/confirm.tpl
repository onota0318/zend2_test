<html>
<head>
    <content-type="text/html charset='UTF-8'">
    <title>Sampleフォーム 確認画面</title>
</head>
<body>
    {include $GlobalScreenHolder->header}
    <h1>Sampleフォーム 確認画面</h1>

    <dl>
        <dd>苗字：{$SampleFormScreenHolder->first_name}</dd>
        <dd>&nbsp;</dd>
        <dd>名前：{$SampleFormScreenHolder->last_name}</dd>
        <dd>&nbsp;</dd>
        <dd>性別：{$SampleFormScreenHolder->getGenderType()->toName()}</dd>
        <dd>&nbsp;</dd>
        <dd>都道府県：{$SampleFormScreenHolder->getPrefType()->toName()}</dd>
        <dd>&nbsp;</dd>
        <dd><input type="button" value="　登録　"><input type="button" value="　変更　" onClick="javascript:location.href='/demo/sample/form/input'"></dd>
    </dl>
    {include $GlobalScreenHolder->footer}
</body>

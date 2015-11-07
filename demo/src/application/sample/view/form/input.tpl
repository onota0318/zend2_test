<html>
<head>
    <content-type="text/html charset='UTF-8'">
    <title>Sampleフォーム 入力画面</title>
</head>
<body>
    {include $GlobalScreenHolder->header}
    <h1>Sampleフォーム 入力画面</h1>

    {if $this->errors()->exists()}
    <div style="color:red;">
        <p>※エラー※</p>
        {if $this->errors()->has('first_name')}
            <p>{$this->errors()->show('first_name')}</p>
        {/if}
        {if $this->errors()->has('last_name')}
            <p>{$this->errors()->show('last_name')}</p>
        {/if}
        {if $this->errors()->has('gender')}
            <p>{$this->errors()->show('gender')}</p>
        {/if}
        {if $this->errors()->has('pref')}
            <p>{$this->errors()->show('pref')}</p>
        {/if}
    </div>
    {/if}

    <form action="/demo/sample/form/confirm" method="POST">
        <dl>
            <dd>苗字</dd>
            <dd><input type="text" name="first_name" value="{$SampleFormScreenHolder->first_name}"></dd>
            <dd>&nbsp;</dd>
            <dd>名前</dd>
            <dd><input type="text" name="last_name" value="{$SampleFormScreenHolder->last_name}"></dd>
            <dd>&nbsp;</dd>
            <dd>性別</dd>
            <dd>{foreach from=$SampleFormScreenHolder->gender_list key=k item=v}
                <input type="radio" name="gender" value="{$k}"{if $k eq $SampleFormScreenHolder->gender} checked {/if}>{$v} 
                {/foreach}
            </dd>
            <dd>&nbsp;</dd>
            <dd>都道府県</dd>
            <dd>
                <select name="pref">
                    {foreach from=$SampleFormScreenHolder->pref_list key=k item=v}
                    <option value="{$k}"{if $k eq $SampleFormScreenHolder->pref} selected{/if}>{$v}</option>
                    {/foreach}
                </select>
            </dd>
            <dd>&nbsp;</dd>
            <dd><input type="submit" value="　送信　"></dd>
        </dl>
    </form>
    {include $GlobalScreenHolder->footer}
</body>

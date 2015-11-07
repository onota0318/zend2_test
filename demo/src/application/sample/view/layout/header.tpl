<div>
    ヘッダだよー
    {if $GlobalScreenHolder->isLogin == true}
    <dl>
        <dd>
            ようこそ {$GlobalScreenHolder->identity->login_id} さん 
            <a href="/demo/sample/auth/logout">ログアウト</a>
        </dd>
    </dl>
    {/if}
</div>

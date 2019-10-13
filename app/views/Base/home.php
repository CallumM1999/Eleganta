<h1>Home page</h1>

<p><strong>Methods to test</strong></p>
<p>(get with controller works)</p>

<ul>
    <li>
        <form action="<?= URLROOT ?>/post" method="post">
            <input type="submit" value="Post method">
        </form>
    </li>
    <li><a href="<?= URLROOT ?>/match">Match</a></li>
    <li><a href="<?= URLROOT ?>/any">Any</a></li>
    <li><a href="<?= URLROOT ?>/view">View</a></li>
    <li><a href="<?= URLROOT ?>/redirect">Redirect</a></li>
    <li><a href="<?= URLROOT ?>/middleware">Middleware</a></li>
    <li><a href="<?= URLROOT ?>/func">Inline function route</a></li>
    <li><a href="<?= URLROOT ?>/sfsdifalsgdfh">Undefined route ( Route::any('*') )</a></li>
</ul>
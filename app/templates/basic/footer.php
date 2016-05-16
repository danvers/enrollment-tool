<?php
/**
 * Sample layout
 */

use Helpers\Hooks;

$hooks = Hooks::get();
?>
</div>
<footer class="footer">
    <div class="container">
        <p class="text-muted text-right">Made with
            <a href="http://http://novaframework.com/php-framework">Nova Framework</a> and
            <a href="http://getbootstrap.com/">Bootstrap</a> by
            <a href="https://pixelspace.org">pixelspace.org</a></p>
    </div>
</footer>
<?php
$hooks->run('footer');
?>
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(["setCookieDomain", "*.pixelspace.org"]);
    _paq.push(["setDomains", ["*.pixelspace.org"]]);
    _paq.push(['trackPageView']);
    _paq.push(['trackAllContentImpressions']);
    _paq.push(['enableLinkTracking']);
    (function () {
        var u = "//art3mis.de/piwik/";
        _paq.push(['setTrackerUrl', u + 'piwik.php']);
        _paq.push(['setSiteId', 17]);
        var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
        g.type = 'text/javascript';
        g.async = true;
        g.defer = true;
        g.src = u + 'piwik.js';
        s.parentNode.insertBefore(g, s);
    })();
</script>
</body>
</html>

			</div><!-- col-12 -->
		</div><!-- container -->
	</div>
</main>
<footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p class="copy"><small>&copy; 2016 – 2017. ГК ЭЛЕКТРОПОМПА. Все права защищены.</small></p>
        </div>
      </div>
    </div>
    
  </footer>

  <div class="modal fade bs-call-back-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="row">
          <div class="col-xl-12">
            <form action="mail.php" method="POST" name="call-back" class="call-back">
              <input type="text" placeholder="Введите имя" name="name">
              <input type="tel" placeholder="Номер телефона" name="phone">
              <input type="submit" class="button" value="Отправить заявку">
            </form>
            <div class="result text-xl-center"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

<a id="to-top" href="#top"></a>

<?php wp_footer(); ?>
<script type="text/javascript">
(function ($) {
    $(function () {
        $("a[href^='#']").click(function () {
            var _href = $(this).attr("href");
            $("html, body").animate({scrollTop: $(_href).offset().top + "px"});
            return false;
        });
    });
})(jQuery)
</script>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45831759 = new Ya.Metrika({ id:45831759, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45831759" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
	<!-- BEGIN JIVOSITE CODE {literal} -->
	<script type='text/javascript'>
      (function(){ var widget_id = 'hcljCcOjNu';var d=document;var w=window;function l(){
          var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
	<!-- {/literal} END JIVOSITE CODE -->
	
</body>
</html>
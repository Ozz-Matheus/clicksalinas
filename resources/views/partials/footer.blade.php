<footer class="footer container-fluid">
  <div class="footer__area-primary">
    <div class="footer__row row">
      <div class="col isotipo">
      </div>
    </div>
  </div>
  <div class="footer__area-secondary">
    <div class="footer__row row justify-content-between align-items-center">
      <div class="col-lg-4 order-lg-2 footer__column text-center">
        <a href="{{ route('privacy.policy') }}">Privacy Policy</a> |
        <a href="{{ route('terms') }}">Terms & Conditions</a>
      </div>
      <div class="col-lg-4 order-lg-3 footer__column text-right">
        <section class="widget widget_cassio_menu_inline">
          <small>All rights reserved Cartagena de Indias - Colombia</small>
        </section>
      </div>
      <div class="col-lg-4 order-lg-1 footer__column text-left">
        <section class="widget widget_cassio_copyright">
          <small class="copyright">{{config('app.name' )}} © <?php echo date ("Y"); ?> </small>
        </section>
      </div>
    </div>
  </div>
</footer>
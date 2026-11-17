<script>
(function () {
  var root = document.documentElement;
  var saved = localStorage.getItem('g7kaih-theme');
  if (saved === 'dark') root.setAttribute('data-theme', 'dark');
  var btn = document.getElementById('themeToggle');
  if (btn) {
    btn.addEventListener('click', function () {
      var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      if (next === 'dark') root.setAttribute('data-theme', 'dark');
      else root.removeAttribute('data-theme');
      localStorage.setItem('g7kaih-theme', next);
    });
  }
  var navLinks = document.querySelectorAll('.main-nav a[href^="#"]');
  navLinks.forEach(function (link) {
    link.addEventListener('click', function () {
      navLinks.forEach(function (a) { a.classList.remove('is-active'); a.removeAttribute('aria-current'); });
      link.classList.add('is-active');
      link.setAttribute('aria-current', 'page');
    });
  });
})();
</script>

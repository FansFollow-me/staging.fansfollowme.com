/**
 * UseBasin form submit — never show raw JSON.
 * Posts via fetch, then redirects to the branded FFM thank-you page.
 */
(function () {
  function thanksUrl(form) {
    var type = form.getAttribute('data-thanks-type') || 'contact';
    var base = form.getAttribute('data-thanks-url') || '/form-thanks';
    return base + (base.indexOf('?') >= 0 ? '&' : '?') + 'type=' + encodeURIComponent(type);
  }

  function bindForm(form) {
    if (form.getAttribute('data-ffm-bound') === '1') return;
    form.setAttribute('data-ffm-bound', '1');

    // Prefer server-side redirect target if UseBasin honors _redirect
    var type = form.getAttribute('data-thanks-type') || 'contact';
    var existing = form.querySelector('input[name="_redirect"]');
    if (!existing) {
      var hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = '_redirect';
      hidden.value = thanksUrl(form);
      form.appendChild(hidden);
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = form.querySelector('[type="submit"]');
      var original = btn ? btn.textContent : '';
      if (btn) {
        btn.disabled = true;
        btn.textContent = 'Sending…';
      }

      fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { Accept: 'application/json' },
        redirect: 'follow'
      })
        .then(function (res) {
          return res.text().then(function (text) {
            var data = {};
            try { data = JSON.parse(text); } catch (_) { /* non-JSON body */ }
            // Success if HTTP ok, or JSON success flag true
            var ok = res.ok && data.success !== false;
            if (ok) {
              var dest = data.redirect_url && String(data.redirect_url).indexOf('usebasin.com') >= 0
                ? thanksUrl(form) // never leave user on usebasin JSON/partial pages
                : (form.getAttribute('data-thanks-url') || thanksUrl(form));
              if (data.success === true || res.ok) {
                window.location.href = thanksUrl(form);
                return;
              }
            }
            throw new Error('submit_failed');
          });
        })
        .catch(function () {
          if (btn) {
            btn.disabled = false;
            btn.textContent = original;
          }
          var err = form.querySelector('.ffm-form-error');
          if (!err) {
            err = document.createElement('div');
            err.className = 'ffm-form-error';
            err.style.cssText = 'margin-top:.75rem;padding:.75rem 1rem;border-radius:10px;background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.3);color:#fca5a5;font-size:.85rem;';
            form.appendChild(err);
          }
          err.textContent = 'Sorry — we could not send that just now. Please try again in a moment.';
        });
    });
  }

  function scan() {
    var forms = document.querySelectorAll('form[action*="usebasin.com"]');
    for (var i = 0; i < forms.length; i++) bindForm(forms[i]);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', scan);
  } else {
    scan();
  }
})();

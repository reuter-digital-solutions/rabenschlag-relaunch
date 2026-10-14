/* Elektrotechnik Rabenschlag – Interaktion & Animation (ohne Abhängigkeiten) */
(() => {
  'use strict';

  const $ = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => [...c.querySelectorAll(s)];
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const fine = matchMedia('(pointer: fine)').matches;
  const root = document.documentElement;

  /* ---------- Headlines Wort für Wort ---------- */
  $$('[data-split]').forEach((el) => {
    let i = 0;
    const walk = (node) => {
      [...node.childNodes].forEach((n) => {
        if (n.nodeType === 3) {
          const frag = document.createDocumentFragment();
          n.textContent.split(/(\s+)/).forEach((part) => {
            if (!part) return;
            if (/^\s+$/.test(part)) { frag.append(' '); return; }
            const w = document.createElement('span');
            w.className = 'w';
            const inner = document.createElement('span');
            inner.style.setProperty('--i', i++);
            inner.textContent = part;
            w.append(inner);
            frag.append(w);
          });
          n.replaceWith(frag);
        } else if (n.nodeType === 1 && n.tagName !== 'BR') {
          walk(n);
        }
      });
    };
    walk(el);
    el.classList.add('split-words');
    el.setAttribute('data-reveal', 'words');
  });

  /* ---------- Einblenden beim Scrollen ---------- */
  // Elemente mit clip-path meldet der IntersectionObserver nie als sichtbar –
  // für sie wird deshalb das Elternelement beobachtet.
  const targets = new Map();
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      (targets.get(e.target) || [e.target]).forEach((el) => el.classList.add('in'));
      io.unobserve(e.target);
    });
  }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });
  $$('[data-reveal]').forEach((el) => {
    const t = el.dataset.reveal === 'clip' ? el.parentElement : el;
    if (!targets.has(t)) targets.set(t, []);
    targets.get(t).push(el);
    io.observe(t);
  });

  /* Gruppen: Kinder automatisch staffeln */
  $$('[data-stagger]').forEach((g) => {
    [...g.children].forEach((c, i) => {
      if (!c.hasAttribute('data-reveal')) c.setAttribute('data-reveal', g.dataset.stagger || '');
      c.style.setProperty('--d', i);
      io.observe(c);
    });
  });

  /* ---------- Zähler ---------- */
  const countIO = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      const el = e.target;
      const to = parseFloat(el.dataset.count);
      const from = parseFloat(el.dataset.from || 0);
      const dur = 1600;
      const t0 = performance.now();
      const tick = (t) => {
        const p = Math.min(1, (t - t0) / dur);
        const eased = 1 - Math.pow(1 - p, 4);
        el.textContent = Math.round(from + (to - from) * eased);
        if (p < 1) requestAnimationFrame(tick);
      };
      reduce ? (el.textContent = to) : requestAnimationFrame(tick);
      countIO.unobserve(el);
    });
  }, { threshold: 0.6 });
  $$('[data-count]').forEach((el) => countIO.observe(el));

  /* ---------- Scroll: Header, Fortschritt, Parallax, Ablauf ---------- */
  const steps = $('[data-steps]');
  const parallax = $$('[data-parallax]');
  const dock = $('.dock');
  let lastY = 0;
  let ticking = false;

  const onScroll = () => {
    const y = scrollY;
    const h = document.body.scrollHeight - innerHeight;
    root.style.setProperty('--sp', h > 0 ? (y / h).toFixed(4) : 0);
    document.body.classList.toggle('is-scrolled', y > 40);
    const menuOpen = document.body.classList.contains('menu-open');
    document.body.classList.toggle('is-hidden-header', !menuOpen && y > 500 && y > lastY + 4);
    if (y < lastY - 4) document.body.classList.remove('is-hidden-header');
    if (dock) dock.classList.toggle('show', y > innerHeight * 0.6);

    if (!reduce) {
      parallax.forEach((el) => {
        const r = el.parentElement.getBoundingClientRect();
        if (r.bottom < 0 || r.top > innerHeight) return;
        const p = (r.top + r.height / 2 - innerHeight / 2) / innerHeight;
        el.style.transform = `translate3d(0, ${(p * -parseFloat(el.dataset.parallax || 40)).toFixed(1)}px, 0)`;
      });
    }

    if (steps) {
      const r = steps.getBoundingClientRect();
      const p = Math.min(1, Math.max(0, (innerHeight * 0.75 - r.top) / (r.height + innerHeight * 0.25)));
      steps.style.setProperty('--p', p.toFixed(3));
      const items = $$('.step', steps);
      items.forEach((s, i) => s.classList.toggle('on', p >= (i + 0.5) / items.length || reduce));
    }
    lastY = y;
    ticking = false;
  };
  addEventListener('scroll', () => { if (!ticking) { requestAnimationFrame(onScroll); ticking = true; } }, { passive: true });
  addEventListener('resize', onScroll);
  onScroll();

  /* ---------- Navigations-Indikator (gleitende Pille) ---------- */
  const pill = $('.navpill');
  if (pill) {
    const ind = $('.navpill-indicator', pill);
    const move = (a) => {
      ind.style.width = a.offsetWidth + 'px';
      ind.style.transform = `translateX(${a.offsetLeft}px)`;
      ind.style.opacity = 1;
    };
    $$('.nl', pill).forEach((a) => a.addEventListener('mouseenter', () => move(a)));
    pill.addEventListener('mouseleave', () => (ind.style.opacity = 0));
  }

  /* ---------- Mobilmenü ---------- */
  const burger = $('.burger');
  const mnav = $('#mnav');
  if (burger && mnav) {
    const setOpen = (open) => {
      burger.setAttribute('aria-expanded', open);
      burger.setAttribute('aria-label', open ? 'Menü schließen' : 'Menü öffnen');
      mnav.classList.toggle('open', open);
      mnav.toggleAttribute('hidden', false);
      document.body.classList.toggle('menu-open', open);
      if (open) setTimeout(() => $('a', mnav)?.focus({ preventScroll: true }), 350);
    };
    burger.addEventListener('click', () => setOpen(burger.getAttribute('aria-expanded') !== 'true'));
    $$('a', mnav).forEach((a) => a.addEventListener('click', () => setOpen(false)));
    addEventListener('keydown', (e) => { if (e.key === 'Escape' && mnav.classList.contains('open')) { setOpen(false); burger.focus(); } });
    matchMedia('(min-width: 1001px)').addEventListener('change', (m) => m.matches && setOpen(false));
  }

  /* ---------- Spotlight & Magnet (nur Maus) ---------- */
  if (fine && !reduce) {
    $$('.spot').forEach((el) => {
      el.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        el.style.setProperty('--mx', `${e.clientX - r.left}px`);
        el.style.setProperty('--my', `${e.clientY - r.top}px`);
      });
    });
    $$('.mag').forEach((el) => {
      el.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        el.style.setProperty('--tx', `${((e.clientX - r.left) / r.width - 0.5) * 10}px`);
        el.style.setProperty('--ty', `${((e.clientY - r.top) / r.height - 0.5) * 8}px`);
      });
      el.addEventListener('pointerleave', () => { el.style.setProperty('--tx', '0px'); el.style.setProperty('--ty', '0px'); });
    });
  }

  /* ---------- Datei-Upload (Drag & Drop, Liste, Entfernen) ---------- */
  const fmtSize = (b) => (b / 1048576).toFixed(b < 104858 ? 2 : 1).replace('.', ',') + ' MB';
  $$('.drop').forEach((zone) => {
    const input = $('input[type=file]', zone);
    const list = zone.parentElement.querySelector('.files');
    const render = () => {
      list.innerHTML = '';
      [...input.files].forEach((f, idx) => {
        const li = document.createElement('li');
        li.innerHTML = `<svg class="ico" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2.5H7A2.5 2.5 0 0 0 4.5 5v14A2.5 2.5 0 0 0 7 21.5h10a2.5 2.5 0 0 0 2.5-2.5V8z"/><path d="M14 2.5V8h5.5"/></svg><span></span><small>${fmtSize(f.size)}</small><button type="button" aria-label="Datei entfernen"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>`;
        $('span', li).textContent = f.name;
        $('button', li).addEventListener('click', () => {
          const dt = new DataTransfer();
          [...input.files].forEach((x, j) => j !== idx && dt.items.add(x));
          input.files = dt.files;
          render();
        });
        list.append(li);
      });
      zone.closest('.field')?.classList.remove('invalid');
    };
    input.addEventListener('change', render);
    ['dragenter', 'dragover'].forEach((t) => zone.addEventListener(t, (e) => { e.preventDefault(); zone.classList.add('drag'); }));
    ['dragleave', 'drop'].forEach((t) => zone.addEventListener(t, () => zone.classList.remove('drag')));
    zone.addEventListener('drop', (e) => {
      e.preventDefault();
      const dt = new DataTransfer();
      if (input.multiple) [...input.files].forEach((f) => dt.items.add(f));
      [...e.dataTransfer.files].slice(0, input.multiple ? 10 : 1).forEach((f) => dt.items.add(f));
      input.files = dt.files;
      render();
    });
  });

  /* ---------- Formulare: Validierung + Versand per fetch ---------- */
  const messages = {
    valueMissing: 'Bitte füllen Sie dieses Feld aus.',
    typeMismatch: 'Bitte geben Sie eine gültige E-Mail-Adresse an.',
    tooShort: 'Bitte etwas ausführlicher (mind. 10 Zeichen).',
  };
  const setError = (form, name, msg) => {
    const el = form.elements[name];
    const field = (el?.length && !el.tagName ? el[0] : el)?.closest('.field');
    if (!field) return;
    field.classList.toggle('invalid', !!msg);
    const err = $('.err', field);
    if (err) err.textContent = msg || '';
  };

  $$('form[data-form]').forEach((form) => {
    const status = $('.form-status', form);
    const btn = $('button[type=submit]', form);

    form.addEventListener('input', (e) => {
      const f = e.target.closest('.field');
      if (f?.classList.contains('invalid') && e.target.checkValidity()) { f.classList.remove('invalid'); $('.err', f).textContent = ''; }
    });

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      status.textContent = '';
      status.classList.remove('ok');
      let first = null;
      $$('input, textarea, select', form).forEach((el) => {
        if (!el.name || el.type === 'radio' || el.type === 'hidden' || el.closest('.hp')) return;
        let msg = '';
        if (!el.checkValidity()) {
          const v = el.validity;
          msg = el.type === 'checkbox' ? 'Bitte stimmen Sie der Datenschutzerklärung zu.'
            : el.type === 'file' ? 'Bitte laden Sie Ihren Lebenslauf hoch.'
            : el.tagName === 'SELECT' ? 'Bitte wählen Sie eine Position aus.'
            : v.valueMissing ? messages.valueMissing : v.typeMismatch ? messages.typeMismatch : v.tooShort ? messages.tooShort : el.validationMessage;
          first = first || el;
        }
        if (el.type === 'file' && el.files.length) {
          const big = [...el.files].find((f) => f.size > 5 * 1048576);
          if (big) { msg = `„${big.name}“ ist größer als 5 MB.`; first = first || el; }
        }
        setError(form, el.name, msg);
      });
      if (first) {
        first.closest('.field')?.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'center' });
        setTimeout(() => first.focus({ preventScroll: true }), 300);
        status.textContent = 'Bitte prüfen Sie die markierten Felder.';
        return;
      }

      btn.classList.add('is-loading');
      $('.btn-label', btn).dataset.label ??= $('.btn-label', btn).textContent;
      $('.btn-label', btn).textContent = 'Wird gesendet …';
      // Statische Demo (GitHub Pages): kein Backend, Erfolg wird simuliert
      if (form.hasAttribute('data-demo')) {
        await new Promise((r) => setTimeout(r, 1200));
        btn.classList.remove('is-loading');
        $('.btn-label', btn).textContent = $('.btn-label', btn).dataset.label;
        form.classList.add('sent');
        $('.form-success', form).hidden = false;
        $('.form-success p', form).textContent += ' (Demo – es wurde keine E-Mail versendet.)';
        return;
      }
      try {
        const res = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { Accept: 'application/json' } });
        const data = await res.json().catch(() => ({ ok: false, message: 'Unerwartete Antwort vom Server.' }));
        if (data.ok) {
          form.classList.add('sent');
          $('.form-success', form).hidden = false;
          form.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'center' });
        } else {
          Object.entries(data.errors || {}).forEach(([k, v]) => setError(form, k, v));
          status.textContent = data.message || 'Bitte prüfen Sie Ihre Eingaben.';
        }
      } catch {
        status.textContent = 'Verbindung fehlgeschlagen. Bitte versuchen Sie es erneut oder rufen Sie uns an.';
      } finally {
        btn.classList.remove('is-loading');
        $('.btn-label', btn).textContent = $('.btn-label', btn).dataset.label;
      }
    });
  });

  /* Stelle aus Link vorauswählen (karriere#bewerbung?stelle=…) */
  $$('[data-pick]').forEach((a) => a.addEventListener('click', () => {
    const sel = $('#b-position');
    if (sel) { sel.value = a.dataset.pick; sel.dispatchEvent(new Event('input', { bubbles: true })); }
  }));
  const pre = new URLSearchParams(location.search).get('stelle');
  if (pre && $('#b-position')) $('#b-position').value = pre;
})();

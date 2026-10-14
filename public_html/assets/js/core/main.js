(() => {
  const topBtn = document.querySelector('.backtop');
  const syncBacktop = () => {
    topBtn?.classList.toggle('show', window.scrollY > 650);
  };

  addEventListener('scroll', syncBacktop, { passive: true });
  syncBacktop();

  topBtn?.addEventListener('click', () => scrollTo({ top: 0, behavior: 'smooth' }));

  const menuBtn = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.nav');
  const compactNavQuery = matchMedia('(max-width: 1080px)');
  const navDropdowns = [...nav?.querySelectorAll('.nav-dropdown') || []];
  let menuRestoreFocus = null;

  const menuFocusables = () => [
    menuBtn,
    ...nav?.querySelectorAll('a[href], button:not([disabled]), summary') || [],
  ].filter(element => element instanceof HTMLElement && element.getClientRects().length > 0);

  const setMenuState = (open, restoreFocus = true) => {
    const wasOpen = menuBtn?.getAttribute('aria-expanded') === 'true';
    if (open && !wasOpen) {
      menuRestoreFocus = document.activeElement instanceof HTMLElement ? document.activeElement : menuBtn;
    }

    menuBtn?.setAttribute('aria-expanded', String(open));
    menuBtn?.setAttribute('aria-label', open ? 'Menü schließen' : 'Menü öffnen');
    nav?.classList.toggle('open', open);
    document.body.classList.toggle('menu-lock', open);
    if (!open) navDropdowns.forEach(dropdown => { dropdown.open = false; });
    syncBacktop();

    if (open && !wasOpen) {
      const enterNavigation = () => {
        if (!nav?.classList.contains('open')) return;
        // The first animation frame can precede the visibility style update.
        const target = nav.querySelector('a[href], button:not([disabled]), summary');
        if (target && getComputedStyle(target).visibility !== 'visible') { requestAnimationFrame(enterNavigation); return; }
        target?.focus();
      };
      requestAnimationFrame(enterNavigation);
    } else if (!open && wasOpen && restoreFocus) {
      (menuRestoreFocus || menuBtn)?.focus();
      menuRestoreFocus = null;
    }
  };
  const closeMenu = (restoreFocus = true) => setMenuState(false, restoreFocus);

  menuBtn?.addEventListener('click', () => {
    setMenuState(menuBtn.getAttribute('aria-expanded') !== 'true');
  });
  // Native details/summary exposes the dropdown state without manual ARIA.
  navDropdowns.forEach(dropdown => {
    dropdown.addEventListener('mouseenter', () => {
      if (!compactNavQuery.matches) dropdown.open = true;
    });
    dropdown.addEventListener('mouseleave', () => {
      if (!compactNavQuery.matches && !dropdown.contains(document.activeElement)) dropdown.open = false;
    });
    dropdown.addEventListener('focusout', () => {
      requestAnimationFrame(() => {
        if (!compactNavQuery.matches && !dropdown.contains(document.activeElement) && !dropdown.matches(':hover')) {
          dropdown.open = false;
        }
      });
    });
  });
  document.addEventListener('keydown', event => {
    const menuOpen = menuBtn?.getAttribute('aria-expanded') === 'true';
    const activeDropdown = navDropdowns.find(dropdown => dropdown.open && dropdown.contains(document.activeElement));
    if (event.key === 'Escape' && activeDropdown) {
      event.preventDefault();
      activeDropdown.open = false;
      activeDropdown.querySelector('summary')?.focus();
      return;
    }
    if (event.key === 'Escape' && menuOpen) {
      event.preventDefault();
      closeMenu();
      return;
    }

    if (event.key !== 'Tab' || !menuOpen || !compactNavQuery.matches) return;
    const focusables = menuFocusables();
    if (!focusables.length) return;
    const first = focusables[0];
    const last = focusables[focusables.length - 1];
    const active = document.activeElement;

    if (event.shiftKey && active === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && active === last) {
      event.preventDefault();
      first.focus();
    }
  });
  document.querySelectorAll('.nav a').forEach(link => link.addEventListener('click', () => {
    if (compactNavQuery.matches) closeMenu();
  }));

  compactNavQuery.addEventListener('change', event => {
    navDropdowns.forEach(dropdown => { dropdown.open = false; });
    if (!event.matches) {
      closeMenu(false);
    }
  });

  document.querySelectorAll('input[data-min-today]').forEach(input => {
    const now = new Date();
    const localDate = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
    input.min = localDate;
  });

  const footer = document.querySelector('.site-footer');
  if (footer && 'IntersectionObserver' in window) {
    const footerObserver = new IntersectionObserver(entries => {
      const visible = entries.some(entry => entry.isIntersecting);
      if (visible && document.activeElement?.matches('.whatsapp-chat')) footer.querySelector('a[href^="tel:"]')?.focus({ preventScroll: true });
      document.body.classList.toggle('footer-visible', visible);
    }, { threshold: 0.08 });
    footerObserver.observe(footer);
  }

  const setStatus = (form, message, type = '') => {
    const status = form.querySelector('.form-status');
    if (!status) return null;
    status.textContent = message;
    status.className = `form-status${type ? ` ${type}` : ''}${message ? ' is-visible' : ''}`;
    status.tabIndex = -1;
    return status;
  };

  document.querySelectorAll('form[data-ajax]').forEach(form => {
    window.KEMForms.init(form);
    form.addEventListener('submit', async event => {
      event.preventDefault();
      if (form.dataset.submitting === 'true') return;
      const invalid = window.KEMForms.validate(form);
      if (invalid) { setStatus(form, 'Bitte prüfen Sie die markierten Angaben.', 'error'); window.KEMForms.focus(form, invalid); return; }
      const body = new FormData(form);
      const submit = form.querySelector('[type="submit"]');
      const originalLabel = submit?.textContent || '';
      const locked = [...form.querySelectorAll('.form-step, .field, .form-actions')].map(node => [node, node.inert]);
      form.dataset.submitting = 'true';
      form.setAttribute('aria-busy', 'true');
      locked.forEach(([node]) => { node.inert = true; });
      if (submit) { submit.disabled = true; submit.textContent = 'Wird gesendet …'; }
      setStatus(form, 'Ihre Anfrage wird gesendet …');
      let focusTarget = null;
      try {
        const response = await fetch(form.action, { method: 'POST', body, headers: { Accept: 'application/json' } });
        if (!(response.headers.get('content-type') || '').includes('application/json')) throw new Error('Der Server hat eine unerwartete Antwort geliefert. Bitte versuchen Sie es später erneut.');
        const data = await response.json();
        if (!data || typeof data !== 'object') throw new Error('Die Antwort konnte nicht verarbeitet werden. Bitte versuchen Sie es erneut.');
        if (!response.ok || data.ok !== true) {
          const errors = data.errors && typeof data.errors === 'object' ? data.errors : {};
          Object.entries(errors).forEach(([name, message]) => {
            const field = window.KEMForms.resolve(form, name);
            if (field) { window.KEMForms.showError(field, String(message)); focusTarget ||= field; }
          });
          const status = setStatus(form, typeof data.message === 'string' ? data.message : 'Die Anfrage konnte nicht gesendet werden.', 'error');
          focusTarget ||= status;
        } else {
          const message = typeof data.message === 'string' && data.message ? data.message : 'Vielen Dank! Ihre Anfrage wurde übermittelt.';
          window.KEMForms.reset(form);
          form.dispatchEvent(new CustomEvent('form:success', { detail: { message } }));
          if (!form.hasAttribute('data-offer-form')) focusTarget = setStatus(form, message, 'ok');
        }
      } catch (error) {
        focusTarget = setStatus(form, error instanceof Error ? error.message : 'Beim Senden ist ein Fehler aufgetreten.', 'error');
      } finally {
        delete form.dataset.submitting;
        form.removeAttribute('aria-busy');
        locked.forEach(([node, inert]) => { node.inert = inert; });
        if (submit) { submit.disabled = false; submit.textContent = originalLabel; }
        if (focusTarget) window.KEMForms.focus(form, focusTarget);
      }
    });
  });
})();

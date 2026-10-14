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
      requestAnimationFrame(() => nav?.querySelector('a[href], button:not([disabled]), summary')?.focus());
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
      document.body.classList.toggle('footer-visible', entries.some(entry => entry.isIntersecting));
    }, { threshold: 0.08 });
    footerObserver.observe(footer);
  }

  const ensureFieldError = field => {
    if (!field.name || field.type === 'hidden') return null;
    if (!field.id) {
      const baseId = `field-${field.name.replace(/[^a-zA-Z0-9_-]/g, '-')}`;
      let fieldId = baseId;
      let suffix = 2;
      while (document.getElementById(fieldId)) fieldId = `${baseId}-${suffix++}`;
      field.id = fieldId;
    }

    const errorId = `${field.id}-error`;
    let error = document.getElementById(errorId);
    if (!error) {
      error = document.createElement('p');
      error.id = errorId;
      error.className = 'field-error';
      error.setAttribute('aria-live', 'polite');
      const wrapper = field.closest('.field');
      (wrapper || field.parentElement)?.append(error);
    }

    const describedBy = new Set((field.getAttribute('aria-describedby') || '').split(/\s+/).filter(Boolean));
    describedBy.add(errorId);
    field.setAttribute('aria-describedby', [...describedBy].join(' '));
    return error;
  };

  const clearFieldError = field => {
    field.removeAttribute('aria-invalid');
    const error = field.id ? document.getElementById(`${field.id}-error`) : null;
    if (error) error.textContent = '';
  };

  const clearFormErrors = form => {
    form.querySelectorAll('[aria-invalid="true"]').forEach(clearFieldError);
    form.querySelectorAll('.field-error').forEach(error => { error.textContent = ''; });
  };

  const showFieldError = (field, message) => {
    const error = ensureFieldError(field);
    field.setAttribute('aria-invalid', 'true');
    if (error) error.textContent = message;
  };

  const setStatus = (form, message, type = '') => {
    const status = form.querySelector('.form-status');
    if (!status) return;
    status.textContent = message;
    status.className = `form-status${type ? ` ${type}` : ''}${message ? ' is-visible' : ''}`;
    status.setAttribute('tabindex', '-1');
  };

  document.querySelectorAll('form[data-ajax] input, form[data-ajax] select, form[data-ajax] textarea').forEach(field => {
    ensureFieldError(field);
    field.addEventListener('input', () => clearFieldError(field));
    field.addEventListener('change', () => clearFieldError(field));
  });

  document.querySelectorAll('form[data-ajax]').forEach(form => form.addEventListener('submit', async event => {
    event.preventDefault();
    clearFormErrors(form);

    if (!form.checkValidity()) {
      const firstInvalid = form.querySelector(':invalid');
      if (firstInvalid) {
        form.dispatchEvent(new CustomEvent('form:show-field', { detail: { field: firstInvalid } }));
        firstInvalid.reportValidity();
      }
      setStatus(form, 'Bitte prüfen Sie die markierten Pflichtfelder.', 'error');
      return;
    }

    const submit = form.querySelector('[type="submit"]');
    const originalLabel = submit?.textContent || '';
    if (submit) {
      submit.disabled = true;
      submit.textContent = 'Wird gesendet …';
    }
    setStatus(form, 'Ihre Anfrage wird gesendet …');

    try {
      const response = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { Accept: 'application/json' },
      });

      const contentType = response.headers.get('content-type') || '';
      if (!contentType.includes('application/json')) {
        throw new Error('Der Server hat eine unerwartete Antwort geliefert. Bitte versuchen Sie es später erneut.');
      }

      const data = await response.json();
      if (!response.ok || !data.ok) {
        const errors = data.errors && typeof data.errors === 'object' ? data.errors : {};
        let firstField = null;
        Object.entries(errors).forEach(([name, message]) => {
          const field = form.elements.namedItem(name);
          if (field instanceof HTMLElement) {
            showFieldError(field, String(message));
            if (!firstField) firstField = field;
          }
        });
        if (firstField) {
          form.dispatchEvent(new CustomEvent('form:show-field', { detail: { field: firstField } }));
        }
        throw new Error(data.message || 'Die Anfrage konnte nicht gesendet werden.');
      }

      form.reset();
      form.dispatchEvent(new CustomEvent('form:success'));
      setStatus(form, data.message, 'ok');
      form.querySelector('.form-status')?.focus();
    } catch (error) {
      setStatus(form, error instanceof Error ? error.message : 'Beim Senden ist ein Fehler aufgetreten.', 'error');
    } finally {
      if (submit) {
        submit.disabled = false;
        submit.textContent = originalLabel;
      }
    }
  }));
})();


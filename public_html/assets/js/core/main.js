(() => {
  const header = document.querySelector('.site-header');
  const topBtn = document.querySelector('.backtop');

  // This measurement only offsets anchors. Sticky positioning reserves the
  // header's real height in the layout, including an expanded mobile menu.
  const measureHeader = () => {
    if (header) document.documentElement.style.setProperty('--header-height', `${header.offsetHeight}px`);
  };
  measureHeader();
  if (header && 'ResizeObserver' in window) {
    new ResizeObserver(measureHeader).observe(header);
  } else {
    addEventListener('resize', measureHeader, { passive: true });
  }

  const syncBacktop = () => topBtn?.classList.toggle('show', window.scrollY > 650);
  addEventListener('scroll', syncBacktop, { passive: true });
  syncBacktop();
  topBtn?.addEventListener('click', () => scrollTo({ top: 0, behavior: 'smooth' }));

  const menuBtn = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.nav');
  const compactNavQuery = matchMedia('(max-width: 1080px)');
  const hoverQuery = matchMedia('(hover: hover) and (pointer: fine)');
  const dropdowns = [...document.querySelectorAll('.has-dropdown')];
  let menuRestoreFocus = null;
  let navigationHasFocus = false;
  let menuHasFocus = false;
  document.addEventListener('focusin', event => {
    navigationHasFocus = Boolean(nav?.contains(event.target));
    menuHasFocus = event.target === menuBtn;
  });

  const dropdownList = item => document.getElementById(item.querySelector('.drop-toggle')?.getAttribute('aria-controls'));
  const dropdownContains = (item, element) => item.contains(element) || dropdownList(item)?.contains(element);
  // A desktop disclosure uses the header's second grid row. On compact
  // layouts its list sits immediately below the controlling button.
  const placeDropdowns = () => dropdowns.forEach(item => {
    const list = dropdownList(item);
    if (list) (compactNavQuery.matches ? item : nav)?.append(list);
  });
  placeDropdowns();

  const setDropdownState = (item, open) => {
    item.classList.toggle('open', open);
    dropdownList(item)?.classList.toggle('open', open);
    item.querySelector('.drop-toggle')?.setAttribute('aria-expanded', String(open));
    measureHeader();
  };
  const closeDropdowns = () => dropdowns.forEach(item => setDropdownState(item, false));

  const menuFocusables = () => [
    menuBtn,
    ...nav?.querySelectorAll('a[href], button:not([disabled])') || [],
  ].filter(element => element instanceof HTMLElement && element.getClientRects().length && getComputedStyle(element).visibility !== 'hidden');

  const setMenuState = (open, restoreFocus = true) => {
    const wasOpen = menuBtn?.getAttribute('aria-expanded') === 'true';
    if (open && !wasOpen) {
      menuRestoreFocus = document.activeElement instanceof HTMLElement ? document.activeElement : menuBtn;
    }

    menuBtn?.setAttribute('aria-expanded', String(open));
    menuBtn?.setAttribute('aria-label', open ? 'Menü schließen' : 'Menü öffnen');
    nav?.classList.toggle('open', open);
    header?.classList.toggle('is-menu-open', open);
    document.body.classList.toggle('menu-lock', open);
    if (!open) closeDropdowns();
    measureHeader();

    if (open && !wasOpen) {
      requestAnimationFrame(() => nav?.querySelector('a[href], button:not([disabled])')?.focus());
    } else if (!open && wasOpen && restoreFocus) {
      (menuRestoreFocus || menuBtn)?.focus();
      menuRestoreFocus = null;
    }
  };
  const closeMenu = (restoreFocus = true) => setMenuState(false, restoreFocus);

  menuBtn?.addEventListener('click', () => {
    setMenuState(menuBtn.getAttribute('aria-expanded') !== 'true');
  });
  dropdowns.forEach(item => {
    const btn = item.querySelector('.drop-toggle');
    btn?.addEventListener('click', () => {
      setDropdownState(item, btn.getAttribute('aria-expanded') !== 'true');
    });
    btn?.addEventListener('keydown', event => {
      if (!compactNavQuery.matches && event.key === 'Tab' && !event.shiftKey && btn.getAttribute('aria-expanded') === 'true') {
        event.preventDefault();
        dropdownList(item)?.querySelector('a')?.focus();
        return;
      }
      if (!['ArrowDown', 'ArrowUp'].includes(event.key)) return;
      event.preventDefault();
      setDropdownState(item, true);
      const links = dropdownList(item)?.querySelectorAll('a') || [];
      (event.key === 'ArrowUp' ? links[links.length - 1] : links[0])?.focus();
    });
    item.addEventListener('pointerenter', () => {
      if (!compactNavQuery.matches && hoverQuery.matches) setDropdownState(item, true);
    });
    const onFocusOut = event => {
      if (!compactNavQuery.matches && !dropdownContains(item, event.relatedTarget)) setDropdownState(item, false);
    };
    item.addEventListener('focusout', onFocusOut);
    dropdownList(item)?.addEventListener('focusout', onFocusOut);
    dropdownList(item)?.addEventListener('keydown', event => {
      if (compactNavQuery.matches || event.key !== 'Tab') return;
      const links = [...dropdownList(item).querySelectorAll('a')];
      if (event.shiftKey && document.activeElement === links[0]) {
        event.preventDefault();
        btn?.focus();
      } else if (!event.shiftKey && document.activeElement === links[links.length - 1]) {
        event.preventDefault();
        item.nextElementSibling?.querySelector('a, button')?.focus();
      }
    });
  });
  header?.addEventListener('pointerleave', () => {
    if (!compactNavQuery.matches) dropdowns.forEach(item => {
      if (!dropdownContains(item, document.activeElement)) setDropdownState(item, false);
    });
  });
  document.addEventListener('click', event => {
    if (!event.target.closest('.has-dropdown, .dropdown')) closeDropdowns();
  });
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
      const activeDropdown = dropdowns.find(item => item.classList.contains('open') && dropdownContains(item, document.activeElement));
      if (activeDropdown) {
        event.preventDefault();
        setDropdownState(activeDropdown, false);
        activeDropdown.querySelector('.drop-toggle')?.focus();
        return;
      }
      if (menuBtn?.getAttribute('aria-expanded') === 'true') {
        event.preventDefault();
        closeMenu();
      } else {
        closeDropdowns();
      }
      return;
    }

    if (event.key !== 'Tab' || menuBtn?.getAttribute('aria-expanded') !== 'true' || !compactNavQuery.matches) return;
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
    else closeDropdowns();
  }));

  compactNavQuery.addEventListener('change', event => {
    const navHadFocus = nav?.contains(document.activeElement) || navigationHasFocus;
    const menuHadFocus = document.activeElement === menuBtn || menuHasFocus;
    closeMenu(false);
    placeDropdowns();
    if (event.matches && navHadFocus) menuBtn?.focus();
    else if (!event.matches && menuHadFocus) nav?.querySelector('a[href]')?.focus();
    measureHeader();
  });

  document.querySelectorAll('input[data-min-today]').forEach(input => {
    const now = new Date();
    const localDate = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
    input.min = localDate;
  });

  const footer = document.querySelector('.site-footer-region') || document.querySelector('.site-footer');
  if (footer && 'IntersectionObserver' in window) {
    const footerObserver = new IntersectionObserver(entries => {
      document.body.classList.toggle('footer-visible', entries.some(entry => entry.isIntersecting));
    }, { threshold: 0.08 });
    footerObserver.observe(footer);
  }

  const ensureFieldError = field => {
    if (!field.name || field.type === 'hidden') return null;
    if (!field.id) field.id = `field-${field.name}`;

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


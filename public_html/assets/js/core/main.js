(() => {
  const topBtn = document.querySelector('.backtop');
  const syncBacktop = () => {
    topBtn?.classList.toggle('show', window.scrollY > 650);
  };

  addEventListener('scroll', syncBacktop, { passive: true });
  syncBacktop();

  topBtn?.addEventListener('click', () => scrollTo({
    top: 0,
    behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth',
  }));

  const menuBtn = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.nav');
  const compactNavQuery = matchMedia('(max-width: 67.5em)');
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

  const radioGroup = field => {
    if (!(field instanceof HTMLInputElement) || field.type !== 'radio' || !field.name || !field.form) return [field];
    const item = field.form.elements.namedItem(field.name);
    return item instanceof RadioNodeList ? [...item].filter(input => input instanceof HTMLInputElement && input.type === 'radio') : [field];
  };

  const ensureFieldError = field => {
    if (!field.name || field.type === 'hidden') return null;
    const group = radioGroup(field);
    const owner = group[0];
    if (!owner.id) {
      const baseId = `field-${owner.name.replace(/[^a-zA-Z0-9_-]/g, '-')}`;
      let fieldId = baseId;
      let suffix = 2;
      while (document.getElementById(fieldId)) fieldId = `${baseId}-${suffix++}`;
      owner.id = fieldId;
    }

    const errorId = `${owner.id}-error`;
    let error = document.getElementById(errorId);
    if (!error) {
      error = document.createElement('p');
      error.id = errorId;
      error.className = 'field-error';
      error.setAttribute('aria-live', 'polite');
      const wrapper = owner.type === 'radio' ? owner.closest('fieldset') || owner.closest('.appointment-choice-grid') || owner.closest('.field') : owner.closest('.field');
      (wrapper || owner.parentElement)?.append(error);
    }

    group.forEach(input => {
      const describedBy = new Set((input.getAttribute('aria-describedby') || '').split(/\s+/).filter(Boolean));
      describedBy.add(errorId);
      input.setAttribute('aria-describedby', [...describedBy].join(' '));
    });
    return error;
  };

  const clearFieldError = field => {
    const group = radioGroup(field);
    group.forEach(input => input.removeAttribute('aria-invalid'));
    const error = group[0]?.id ? document.getElementById(`${group[0].id}-error`) : null;
    if (error) error.textContent = '';
  };

  const clearFormErrors = form => {
    form.querySelectorAll('[aria-invalid="true"]').forEach(clearFieldError);
    form.querySelectorAll('.field-error').forEach(error => { error.textContent = ''; });
  };

  const showFieldError = (field, message) => {
    const error = ensureFieldError(field);
    radioGroup(field).forEach(input => input.setAttribute('aria-invalid', 'true'));
    if (error) error.textContent = message;
  };

  const setStatus = (form, message, type = '') => {
    const status = form.querySelector('.form-status');
    if (!status) return;
    status.textContent = message;
    status.className = `form-status${type ? ` ${type}` : ''}${message ? ' is-visible' : ''}`;
    status.setAttribute('tabindex', '-1');
  };

  const errorControl = field => (field instanceof HTMLInputElement || field instanceof HTMLSelectElement || field instanceof HTMLTextAreaElement)
    && !field.matches(':disabled') && field.type !== 'hidden' && !field.hidden;

  const resolveErrorField = (form, name) => {
    let item = form.elements.namedItem(name);
    if (!item && (name === 'photos' || name === 'photos[]')) item = form.elements.namedItem(name === 'photos' ? 'photos[]' : 'photos');
    const fields = (item instanceof RadioNodeList ? [...item] : [item]).filter(errorControl);
    return fields.find(field => field instanceof HTMLInputElement && field.type === 'radio' && field.checked) || fields[0] || null;
  };

  const focusField = (form, field) => {
    form.dispatchEvent(new CustomEvent('form:show-field', { detail: { field } }));
    field.focus();
  };
  const unexpectedResponse = 'Der Server hat eine unerwartete Antwort geliefert. Bitte versuchen Sie es später erneut.';
  const inFlight = new WeakSet();
  const completedOffers = new WeakSet();

  document.querySelectorAll('form[data-ajax] input, form[data-ajax] select, form[data-ajax] textarea').forEach(field => {
    ensureFieldError(field);
    field.addEventListener('input', () => clearFieldError(field));
    field.addEventListener('change', () => clearFieldError(field));
  });

  document.querySelectorAll('form[data-ajax]').forEach(form => {
    const isOffer = form.hasAttribute('data-offer-form');
    form.addEventListener('form:new-request', () => {
      if (!isOffer || inFlight.has(form)) return;
      completedOffers.delete(form);
      clearFormErrors(form);
      setStatus(form, '');
    });

    form.addEventListener('submit', async event => {
      event.preventDefault();
      if (inFlight.has(form) || (isOffer && (completedOffers.has(form) || form.dataset.offerState === 'success'))) return;
      clearFormErrors(form);

      if (!form.checkValidity()) {
        const firstInvalid = [...form.elements].find(field => field.willValidate && !field.checkValidity());
        setStatus(form, 'Bitte prüfen Sie die markierten Pflichtfelder.', 'error');
        if (firstInvalid) {
          focusField(form, firstInvalid);
          firstInvalid.reportValidity();
        } else {
          form.querySelector('.form-status')?.focus();
        }
        return;
      }

      const submit = form.querySelector('[type="submit"]');
      const originalLabel = submit instanceof HTMLInputElement ? submit.value : submit?.textContent || '';
      const setSubmitLabel = label => {
        if (submit instanceof HTMLInputElement) submit.value = label;
        else if (submit) submit.textContent = label;
      };
      let restoreControls = () => {};
      let firstField = null;
      inFlight.add(form);

      try {
        // Disabled controls are omitted from FormData, so capture before freezing.
        const body = new FormData(form);
        const states = [...form.elements].filter(field => 'disabled' in field).map(field => [field, field.disabled]);
        const originalBusy = form.getAttribute('aria-busy');
        let restored = false;
        restoreControls = () => {
          if (restored) return;
          restored = true;
          states.forEach(([field, disabled]) => { field.disabled = disabled; });
          setSubmitLabel(originalLabel);
          if (originalBusy === null) form.removeAttribute('aria-busy');
          else form.setAttribute('aria-busy', originalBusy);
        };
        states.forEach(([field]) => { field.disabled = true; });
        form.setAttribute('aria-busy', 'true');
        setSubmitLabel('Wird gesendet …');
        setStatus(form, 'Ihre Anfrage wird gesendet …');

        let response;
        try {
          response = await fetch(form.action, { method: 'POST', body, headers: { Accept: 'application/json' } });
        } catch {
          throw new Error('Die Verbindung ist fehlgeschlagen. Bitte prüfen Sie Ihre Internetverbindung und versuchen Sie es erneut.');
        }
        const contentType = response.headers.get('content-type') || '';
        if (!contentType.toLowerCase().includes('application/json')) throw new Error(unexpectedResponse);
        let data;
        try {
          data = await response.json();
        } catch {
          throw new Error(unexpectedResponse);
        }
        if (!data || typeof data !== 'object' || Array.isArray(data) || typeof data.ok !== 'boolean') throw new Error(unexpectedResponse);

        // Presentation and offer cleanup must see the real relevance/disabled state.
        restoreControls();
        if (!response.ok || data.ok !== true) {
          const errors = data.errors && typeof data.errors === 'object' && !Array.isArray(data.errors) ? data.errors : {};
          Object.entries(errors).forEach(([name, message]) => {
            if (typeof message !== 'string') return;
            const field = resolveErrorField(form, name);
            if (!field) return;
            showFieldError(field, message);
            if (!firstField) firstField = field;
          });
          if (firstField) focusField(form, firstField);
          throw new Error(typeof data.message === 'string' && data.message.trim() ? data.message : 'Die Anfrage konnte nicht gesendet werden.');
        }

        const message = typeof data.message === 'string' && data.message.trim() ? data.message : 'Vielen Dank. Ihre Anfrage wurde übermittelt.';
        if (isOffer) {
          completedOffers.add(form);
          setStatus(form, '');
          form.dispatchEvent(new CustomEvent('form:success', { detail: { message } }));
        } else {
          form.reset();
          form.dispatchEvent(new CustomEvent('form:success', { detail: { message } }));
          setStatus(form, message, 'ok');
          form.querySelector('.form-status')?.focus();
        }
      } catch (error) {
        restoreControls();
        setStatus(form, error instanceof Error ? error.message : 'Beim Senden ist ein Fehler aufgetreten.', 'error');
        if (!firstField) form.querySelector('.form-status')?.focus();
      } finally {
        restoreControls();
        inFlight.delete(form);
      }
    });
  });
})();

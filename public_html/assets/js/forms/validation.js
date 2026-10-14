(() => {
  const controls = scope => [...scope.querySelectorAll('input, select, textarea')].filter(field => !field.closest('.hp'));
  const group = field => field.closest('[data-service-choice-group]') || (field.type === 'radio' ? field.closest('fieldset') : null);
  const resolve = (form, name) => {
    const value = form.elements.namedItem(name);
    if (value instanceof RadioNodeList) return [...value].find(field => !field.disabled) || value[0] || null;
    return value instanceof HTMLElement && value.type !== 'hidden' ? value : null;
  };
  const errorNode = field => {
    const parent = group(field);
    const target = parent || field;
    if (!target.id) target.id = `form-control-${(parent ? parent.querySelector('input')?.name : field.name || 'field').replace(/[^a-z0-9_-]/gi, '-')}`;
    const id = `${target.id}-error`;
    let error = document.getElementById(id);
    if (!error && parent?.matches('[data-service-choice-group]')) error = parent.querySelector('[data-service-choice-error]');
    if (!error) {
      error = document.createElement('p');
      error.className = 'field-error';
      (parent || field.closest('.field') || field.parentElement).append(error);
    }
    error.id = id;
    error.dataset.validationError = '';
    return error;
  };
  const related = field => group(field) ? [...group(field).querySelectorAll('input')] : [field];
  const showError = (field, message) => {
    const error = errorNode(field);
    error.textContent = message;
    related(field).forEach(control => {
      control.setAttribute('aria-invalid', 'true');
      const ids = new Set((control.getAttribute('aria-describedby') || '').split(/\s+/).filter(Boolean));
      ids.add(error.id);
      control.setAttribute('aria-describedby', [...ids].join(' '));
    });
  };
  const clearError = field => {
    related(field).forEach(control => control.removeAttribute('aria-invalid'));
    const target = group(field) || field;
    const error = target.id ? document.getElementById(`${target.id}-error`) : null;
    if (error?.hasAttribute('data-validation-error')) error.textContent = '';
  };
  const rules = field => {
    if (field.disabled) return;
    if (field.dataset.minTrim) {
      const length = [...field.value.trim()].length;
      const min = Number(field.dataset.minTrim);
      field.setCustomValidity(length && length < min ? `Bitte geben Sie mindestens ${min} Zeichen ein.` : field.required && !length ? 'Bitte füllen Sie dieses Feld aus.' : '');
    }
    if (field.hasAttribute('data-count')) field.setCustomValidity(field.value && !/^\d{1,4}$/.test(field.value) ? 'Bitte geben Sie eine ganze Anzahl zwischen 0 und 9999 ein.' : '');
  };
  const summary = form => {
    let node = form.querySelector('[data-form-error-summary]');
    if (!node) {
      node = document.createElement('p');
      node.className = 'form-error-summary';
      node.dataset.formErrorSummary = '';
      node.setAttribute('role', 'alert');
      node.hidden = true;
      form.prepend(node);
    }
    return node;
  };
  const clear = form => {
    controls(form).forEach(clearError);
    form.querySelectorAll('[data-validation-error]').forEach(node => { node.textContent = ''; });
    const node = summary(form); node.textContent = ''; node.hidden = true;
  };
  const validate = (form, scope = form) => {
    const fields = controls(scope).filter(field => field.willValidate);
    let first = null;
    const invalidGroups = new Set();
    fields.forEach(field => {
      rules(field);
      if (!field.checkValidity()) {
        first ||= field;
        const key = group(field) || field;
        invalidGroups.add(key);
        showError(field, field.validationMessage || 'Bitte prüfen Sie Ihre Eingabe.');
      } else if (!invalidGroups.has(group(field) || field)) clearError(field);
    });
    const node = summary(form);
    node.textContent = first ? 'Bitte prüfen Sie die markierten Angaben.' : '';
    node.hidden = !first;
    return first;
  };
  const focus = (form, field) => {
    if (!field) return;
    let parent = field.parentElement;
    while (parent && parent !== form) { if (parent instanceof HTMLDetailsElement) parent.open = true; parent = parent.parentElement; }
    form.dispatchEvent(new CustomEvent('form:show-field', { detail: { field } }));
    field.focus();
  };
  const reset = form => {
    form.reset();
    controls(form).forEach(field => { field.setCustomValidity?.(''); clearError(field); });
    clear(form);
  };
  const init = form => {
    // No-JS forms retain native validation; enhanced forms use durable errors.
    form.noValidate = true;
    const changed = event => {
      const field = event.target;
      if (!field.matches('input,select,textarea')) return;
      const hadError = field.getAttribute('aria-invalid') === 'true';
      rules(field);
      if (field.checkValidity()) clearError(field);
      else if (hadError) showError(field, field.validationMessage || 'Bitte prüfen Sie Ihre Eingabe.');
    };
    form.addEventListener('input', changed);
    form.addEventListener('change', changed);
    summary(form);
  };
  window.KEMForms = { validate, resolve, showError, clearError, clear, focus, reset, init };
})();

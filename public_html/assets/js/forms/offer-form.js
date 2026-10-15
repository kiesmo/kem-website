(() => {
  document.querySelectorAll('[data-multistep]').forEach(form => {
    const steps = [...form.querySelectorAll('.form-step')];
    const dots = [...form.querySelectorAll('.step-dot')];
    const currentStep = form.querySelector('[data-offer-current-step]');
    let index = 0;

    const stepStatus = document.createElement('p');
    stepStatus.className = 'sr-only';
    stepStatus.setAttribute('aria-live', 'polite');
    form.querySelector('.offer-steps')?.insertAdjacentElement('afterend', stepStatus);

    steps.forEach(step => {
      const heading = step.querySelector('h2');
      heading?.setAttribute('tabindex', '-1');
    });

    const paint = ({ focus = false } = {}) => {
      if (form.dataset.offerState === 'success') return;
      steps.forEach((step, stepIndex) => {
        const active = stepIndex === index;
        step.classList.toggle('active', active);
        step.setAttribute('aria-hidden', String(!active));
      });
      dots.forEach((dot, dotIndex) => {
        const current = dotIndex === index;
        const complete = dotIndex < index;
        dot.classList.toggle('is-current', current);
        dot.classList.toggle('is-complete', complete);
        dot.classList.toggle('is-upcoming', dotIndex > index);
        if (current) dot.setAttribute('aria-current', 'step');
        else dot.removeAttribute('aria-current');
        const number = dot.querySelector('.step-index');
        if (number) number.textContent = complete ? '✓' : String(dotIndex + 1);
        const state = dot.querySelector('[data-step-state]');
        if (state) state.textContent = current ? 'Aktuell' : complete ? 'Abgeschlossen' : 'Noch offen';
      });
      if (currentStep) currentStep.textContent = `Schritt ${index + 1} von ${steps.length}: ${dots[index]?.dataset.stepLabel || ''}`;

      const heading = steps[index]?.querySelector('h2');
      const headingText = heading?.textContent?.trim() || `Schritt ${index + 1}`;
      stepStatus.textContent = `Schritt ${index + 1} von ${steps.length}: ${headingText.replace(/^\d+\.\s*/, '')}`;
      if (focus) heading?.focus();
    };

    const showField = (field, focus = true) => {
      if (form.dataset.offerState === 'success') return;
      const targetStep = field?.closest('.form-step');
      const targetIndex = targetStep ? steps.indexOf(targetStep) : -1;
      if (targetIndex >= 0) {
        index = targetIndex;
        paint();
      }
      if (focus) field?.focus();
    };

    form.querySelectorAll('[data-next]').forEach(button => button.addEventListener('click', () => {
      if (form.dataset.offerState === 'success') return;
      const fields = [...steps[index].querySelectorAll('input, select, textarea')].filter(field => field.willValidate);
      const firstInvalid = fields.find(field => !field.checkValidity());
      if (firstInvalid) {
        showField(firstInvalid);
        firstInvalid.reportValidity();
        return;
      }
      index = Math.min(index + 1, steps.length - 1);
      paint({ focus: true });
    }));

    form.querySelectorAll('[data-prev]').forEach(button => button.addEventListener('click', () => {
      if (form.dataset.offerState === 'success') return;
      index = Math.max(0, index - 1);
      paint({ focus: true });
    }));

    form.addEventListener('form:show-field', event => showField(event.detail?.field));
    form.addEventListener('form:go-step', event => {
      if (form.dataset.offerState === 'success') return;
      const nextIndex = Number(event.detail?.index);
      if (!Number.isInteger(nextIndex) || nextIndex < 0 || nextIndex >= steps.length) return;
      index = nextIndex;
      paint({ focus: true });
    });
    form.addEventListener('form:new-request', () => {
      index = 0;
      paint({ focus: true });
    });

    paint();
  });

})();

(() => {
  const form = document.querySelector('[data-offer-form]');
  if (!form) return;

  let policy;
  try {
    policy = JSON.parse(form.dataset.offerPolicy || '{}');
  } catch {
    return;
  }
  const servicePolicy = policy.services || {};
  const shell = form.closest('.offer-builder-shell');
  const intro = shell?.querySelector('[data-offer-intro]');
  const help = shell?.querySelector('[data-offer-help]');
  const successPanel = shell?.querySelector('[data-offer-success]');
  const successHeading = successPanel?.querySelector('#offer-success-title');
  const successMessage = successPanel?.querySelector('[data-offer-success-message]');
  const newRequest = successPanel?.querySelector('[data-offer-new-request]');
  const serviceChecks = [...form.querySelectorAll('[data-cleaning-type]')];
  const servicePanels = [...form.querySelectorAll('[data-service-panel]')];
  const serviceEmpty = form.querySelector('[data-service-detail-empty]');
  const serviceFieldset = form.querySelector('[data-service-choice-group]');
  const serviceError = form.querySelector('[data-service-choice-error]');
  const serviceValue = form.querySelector('#cleaning_types');
  const cleaningCity = form.querySelector('#cleaning_city');
  const contextCityNote = form.querySelector('[data-offer-context-city]');
  const contextCityValue = form.querySelector('[data-offer-context-city-value]');
  const optionalGroups = [...form.querySelectorAll('[data-offer-optional-field]')];
  const objectCompany = form.querySelector('#cleaning_company');
  const customerCompany = form.querySelector('#company');
  const copyCompanyButton = form.querySelector('[data-copy-object-company]');
  const objectCompanyPreview = form.querySelector('[data-object-company-preview]');
  const objectCompanyValue = form.querySelector('[data-object-company-value]');
  const review = form.querySelector('[data-offer-review]');
  const fileInput = form.querySelector('#photos');
  const dropzone = form.querySelector('[data-upload-dropzone]');
  const fileList = form.querySelector('[data-upload-file-list]');
  const previewUrls = new Set();
  const exactDateFields = form.querySelector('[data-exact-date-fields]');
  const appointmentRadios = [...form.querySelectorAll('input[name="appointment_preference"]')];
  const estimateChecks = [...form.querySelectorAll('[data-estimate-for]')];
  const estimateValue = 'Bitte vor Ort einschätzen';

  const serviceLabels = Object.fromEntries(Object.entries(servicePolicy).map(([key, service]) => [key, service.label]));

  const detailFields = {
    office: [
      ['Fläche', 'office_area', ' m²'], ['Turnus', 'office_frequency'], ['Räume / Bereiche', 'office_rooms'],
      ['Verschmutzung', 'office_soiling'], ['Hinweise', 'office_notes'],
    ],
    general: [
      ['Fläche', 'general_area', ' m²'], ['Anlass', 'general_reason'], ['Verschmutzung', 'general_soiling'], ['Hinweise', 'general_notes'],
    ],
    window: [
      ['Maximale Höhe', 'window_max_height'], ['Fenster / Flügel', 'window_sashes'], ['Reinigungswunsch', 'window_scope'],
      ['Verschmutzung', 'window_soiling'], ['Hinweise', 'window_notes'],
    ],
    carpet: [
      ['Lose Teppiche', 'carpet_loose_count'], ['Fläche lose Teppiche', 'carpet_loose_area', ' m²'],
      ['Festverlegte Fläche', 'carpet_fitted_area', ' m²'], ['Reinigungswunsch', 'carpet_scope'],
      ['Verschmutzung', 'carpet_soiling'], ['Hinweise', 'carpet_notes'],
    ],
    upholstery: [
      ['2-Sitzer', 'upholstery_two_seater'], ['3-Sitzer', 'upholstery_three_seater'], ['Ecksofa klein', 'upholstery_corner_small'],
      ['Ecksofa groß', 'upholstery_corner_large'], ['Sessel', 'upholstery_armchair'], ['Hocker', 'upholstery_stool'],
      ['Polsterstuhl ohne Lehne', 'upholstery_chair_seat'], ['Polsterstuhl mit Lehne', 'upholstery_chair_back'],
      ['Individuelles Sofa / Sitzflächen', 'upholstery_custom_seats'], ['Reinigungswunsch', 'upholstery_scope'],
      ['Verschmutzung', 'upholstery_soiling'], ['Hinweise', 'upholstery_notes'],
    ],
    graffiti: [
      ['Fläche', 'graffiti_area', ' m²'], ['Untergrund', 'graffiti_surface'], ['Reinigungswunsch', 'graffiti_scope'], ['Hinweise', 'graffiti_notes'],
    ],
    solar: [
      ['Module', 'solar_modules'], ['Fläche', 'solar_area', ' m²'], ['Zugänglichkeit', 'solar_access'],
      ['Verschmutzung', 'solar_soiling'], ['Hinweise', 'solar_notes'],
    ],
    clearance: [
      ['Objektfläche', 'clearance_area', ' m²'], ['Volumen', 'clearance_volume'],
      ['Aufzug', 'clearance_elevator'], ['Umfang', 'clearance_scope'], ['Hinweise', 'clearance_notes'],
    ],
    other: [['Beschreibung', 'other_details']],
  };

  const selectedServiceKeys = () => serviceChecks
    .filter(field => field.checked)
    .map(field => field.dataset.cleaningType)
    .filter(Boolean);

  const syncContextCity = () => {
    const city = cleaningCity?.value.trim() || '';
    if (contextCityValue) contextCityValue.textContent = city;
    if (contextCityNote) contextCityNote.hidden = !city;
  };

  cleaningCity?.addEventListener('input', syncContextCity);
  cleaningCity?.addEventListener('change', syncContextCity);

  const syncCompanyCopy = () => {
    const source = objectCompany?.value.trim() || '';
    const available = Boolean(source) && !customerCompany?.value.trim();
    if (objectCompanyValue) objectCompanyValue.textContent = source;
    if (objectCompanyPreview) objectCompanyPreview.hidden = !available;
    if (copyCompanyButton) copyCompanyButton.hidden = !available;
  };

  [objectCompany, customerCompany].forEach(field => {
    field?.addEventListener('input', syncCompanyCopy);
    field?.addEventListener('change', syncCompanyCopy);
  });
  copyCompanyButton?.addEventListener('click', () => {
    const source = objectCompany?.value.trim() || '';
    if (!source || !customerCompany || customerCompany.value.trim()) return;
    customerCompany.value = source;
    customerCompany.dispatchEvent(new Event('input', { bubbles: true }));
    customerCompany.focus();
  });

  const clearHiddenFieldError = field => {
    field.removeAttribute('aria-invalid');
    field.setCustomValidity('');
    const error = field.id ? document.getElementById(`${field.id}-error`) : null;
    if (error) error.textContent = '';
  };

  const syncServicePanels = () => {
    const selected = selectedServiceKeys();
    const hasSelection = selected.length > 0;
    const first = serviceChecks[0];

    if (first) first.setCustomValidity(hasSelection ? '' : 'Bitte wählen Sie mindestens eine Reinigungsart aus.');
    if (hasSelection) {
      if (serviceError) serviceError.textContent = '';
      serviceFieldset?.classList.remove('has-error');
      if (first) clearHiddenFieldError(first);
    }
    if (serviceValue) serviceValue.value = selected.map(key => serviceLabels[key] || key).join(' | ');
    if (serviceEmpty) serviceEmpty.hidden = hasSelection;

    servicePanels.forEach(panel => {
      const key = panel.dataset.servicePanel;
      const active = selected.includes(key);
      const fields = new Set(servicePolicy[key]?.fields || []);
      const required = new Set(Object.keys(servicePolicy[key]?.required || {}));
      panel.hidden = !active;
      panel.querySelectorAll('input, select, textarea').forEach(field => {
        const applicable = active && fields.has(field.name || field.dataset.estimateFor);
        field.disabled = !applicable;
        field.required = applicable && required.has(field.name);
        if (!applicable) clearHiddenFieldError(field);
      });
    });

    optionalGroups.forEach(group => {
      const name = group.dataset.offerOptionalField;
      const applicable = (policy.optional_fields?.[name] || []).some(key => selected.includes(key));
      group.hidden = !applicable;
      group.querySelectorAll('input, select, textarea').forEach(field => {
        field.disabled = !applicable;
        field.required = false;
        if (!applicable) clearHiddenFieldError(field);
      });
    });
  };

  const validateServiceChoice = () => {
    const valid = selectedServiceKeys().length > 0;
    serviceFieldset?.classList.toggle('has-error', !valid);
    if (serviceError) serviceError.textContent = valid ? '' : 'Bitte wählen Sie mindestens eine Reinigungsart aus.';
    return valid;
  };

  serviceChecks[0]?.addEventListener('invalid', validateServiceChoice);
  serviceChecks.forEach(check => check.addEventListener('change', () => {
    syncServicePanels();
    validateServiceChoice();
    updateReview();
  }));

  const estimateFieldFor = check => {
    const id = check.dataset.estimateFor || '';
    return id ? form.querySelector(`#${id}`) : null;
  };

  const setEstimateState = (check, restorePrevious = false, refreshReview = true) => {
    const field = estimateFieldFor(check);
    if (!(field instanceof HTMLInputElement)) return;

    if (check.checked) {
      if (field.value !== estimateValue) check.dataset.previousValue = field.value;
      field.value = estimateValue;
      field.readOnly = true;
      field.setAttribute('aria-readonly', 'true');
      field.setCustomValidity('');
    } else {
      field.readOnly = false;
      field.removeAttribute('aria-readonly');
      if (restorePrevious && field.value === estimateValue) field.value = check.dataset.previousValue || '';
    }
    if (refreshReview) updateReview();
  };

  estimateChecks.forEach(check => {
    check.addEventListener('change', () => setEstimateState(check, !check.checked));
    setEstimateState(check, false, false);
  });

  const selectedAppointment = () => appointmentRadios.find(radio => radio.checked)?.value || '';
  const syncAppointment = () => {
    if (!exactDateFields) return;
    const visible = selectedAppointment() === 'Konkreter Termin';
    exactDateFields.hidden = !visible;
    exactDateFields.querySelectorAll('input, select, textarea').forEach(field => {
      field.disabled = !visible;
      if (field.hasAttribute('data-required-when-visible')) field.required = visible;
      if (!visible) clearHiddenFieldError(field);
    });
  };
  appointmentRadios.forEach(radio => radio.addEventListener('change', () => {
    syncAppointment();
    updateReview();
  }));

  const formatBytes = bytes => {
    if (bytes < 1024 * 1024) return `${Math.max(1, Math.round(bytes / 1024))} KB`;
    return `${(bytes / (1024 * 1024)).toFixed(1).replace('.', ',')} MB`;
  };

  const removeFileAt = index => {
    if (!fileInput || fileInput.disabled || form.getAttribute('aria-busy') === 'true') return;
    const transfer = new DataTransfer();
    [...fileInput.files].forEach((file, fileIndex) => {
      if (fileIndex !== index) transfer.items.add(file);
    });
    fileInput.files = transfer.files;
    syncFiles();
    const remaining = [...fileList.querySelectorAll('.upload-remove')];
    (remaining[Math.min(index, remaining.length - 1)] || fileInput).focus();
  };

  const releasePreviewUrl = url => {
    if (!previewUrls.delete(url)) return;
    URL.revokeObjectURL(url);
  };

  const clearPreviewUrls = () => {
    [...previewUrls].forEach(releasePreviewUrl);
  };

  const syncFiles = () => {
    if (!fileInput || !fileList) return;
    if (form.dataset.offerState === 'success') return;
    const files = [...fileInput.files];
    const allowed = ['image/jpeg', 'image/png', 'image/webp'];
    let error = '';
    if (files.length > 5) error = 'Bitte wählen Sie höchstens 5 Fotos aus.';
    if (!error && files.some(file => file.size > 5 * 1024 * 1024)) error = 'Jede Datei darf höchstens 5 MB groß sein.';
    if (!error && files.reduce((sum, file) => sum + file.size, 0) > 15 * 1024 * 1024) error = 'Die Fotos dürfen zusammen höchstens 15 MB groß sein.';
    if (!error && files.some(file => !allowed.includes(file.type))) error = 'Erlaubt sind ausschließlich JPG-, PNG- und WebP-Dateien.';
    fileInput.setCustomValidity(error);

    clearPreviewUrls();
    fileList.replaceChildren();
    files.forEach((file, index) => {
      const item = document.createElement('li');
      item.className = 'upload-preview-item';
      const image = document.createElement('img');
      image.alt = '';
      const previewUrl = URL.createObjectURL(file);
      previewUrls.add(previewUrl);
      image.src = previewUrl;
      image.addEventListener('load', () => releasePreviewUrl(previewUrl), { once: true });
      image.addEventListener('error', () => releasePreviewUrl(previewUrl), { once: true });
      const meta = document.createElement('span');
      meta.className = 'upload-preview-meta';
      const name = document.createElement('b');
      name.textContent = file.name;
      const size = document.createElement('small');
      size.textContent = formatBytes(file.size);
      meta.append(name, size);
      const remove = document.createElement('button');
      remove.type = 'button';
      remove.className = 'upload-remove';
      remove.setAttribute('aria-label', `${file.name} entfernen`);
      remove.textContent = 'Entfernen';
      remove.addEventListener('click', () => removeFileAt(index));
      item.append(image, meta, remove);
      fileList.append(item);
    });
    if (error) {
      const item = document.createElement('li');
      item.className = 'field-error';
      item.textContent = error;
      fileList.append(item);
    }
    updateReview();
  };

  fileInput?.addEventListener('change', syncFiles);
  if (dropzone && fileInput) {
    ['dragenter', 'dragover'].forEach(type => dropzone.addEventListener(type, event => {
      event.preventDefault();
      if (fileInput.disabled || form.getAttribute('aria-busy') === 'true') return;
      dropzone.classList.add('is-dragging');
    }));
    ['dragleave', 'drop'].forEach(type => dropzone.addEventListener(type, event => {
      event.preventDefault();
      dropzone.classList.remove('is-dragging');
    }));
    dropzone.addEventListener('drop', event => {
      event.preventDefault();
      if (fileInput.disabled || form.getAttribute('aria-busy') === 'true') return;
      if (!event.dataTransfer?.files?.length) return;
      const transfer = new DataTransfer();
      [...event.dataTransfer.files].slice(0, 5).forEach(file => transfer.items.add(file));
      fileInput.files = transfer.files;
      syncFiles();
    });
  }

  const getValue = name => {
    const field = form.elements.namedItem(name);
    if (field instanceof RadioNodeList) {
      const selected = [...field].find(input => !input.disabled && input.checked);
      return String(selected?.value || '').trim();
    }
    if (!(field instanceof HTMLElement) || field.matches(':disabled')) return '';
    if (field instanceof HTMLSelectElement) return field.value ? field.selectedOptions[0]?.textContent?.trim() || '' : '';
    if (field instanceof HTMLInputElement && field.type === 'checkbox') return field.checked ? 'Ja' : '';
    return 'value' in field ? String(field.value).trim() : '';
  };

  const formatDate = value => {
    if (!/^\d{4}-\d{2}-\d{2}$/.test(value)) return value;
    const [year, month, day] = value.split('-');
    return `${day}.${month}.${year}`;
  };

  const serviceEntries = key => (detailFields[key] || []).map(([label, name, suffix = '']) => {
    const value = getValue(name);
    if (!value) return [label, ''];
    return [label, value === estimateValue ? value : `${value}${suffix}`];
  });

  function updateReview() {
    if (!review) return;
    review.replaceChildren();
    if (form.dataset.offerState === 'success') return;

    const addSection = (title, entries, stepIndex) => {
      const visibleEntries = entries.filter(([, value]) => value && value !== 'Bitte auswählen');
      if (!visibleEntries.length) return;
      const section = document.createElement('section');
      section.className = 'review-section';
      const header = document.createElement('div');
      header.className = 'review-section-heading';
      const heading = document.createElement('h3');
      heading.textContent = title;
      const edit = document.createElement('button');
      edit.type = 'button';
      edit.className = 'review-edit';
      edit.textContent = 'Ändern';
      edit.setAttribute('aria-label', `Abschnitt ${title} ändern`);
      edit.addEventListener('click', () => form.dispatchEvent(new CustomEvent('form:go-step', { detail: { index: stepIndex } })));
      header.append(heading, edit);
      const list = document.createElement('dl');
      list.className = 'review-list';
      visibleEntries.forEach(([label, value]) => {
        const term = document.createElement('dt');
        const detail = document.createElement('dd');
        term.textContent = label;
        detail.textContent = value;
        list.append(term, detail);
      });
      section.append(header, list);
      review.append(section);
    };

    addSection('Gewählte Leistungen', [
      ['Reinigungsarten', selectedServiceKeys().map(key => serviceLabels[key]).join(', ')],
    ], 0);

    addSection('Objekt und Einsatzort', [
      ['Firma / Objektbezeichnung am Einsatzort', getValue('cleaning_company')],
      ['Adresse', [getValue('cleaning_street'), `${getValue('cleaning_postcode')} ${getValue('cleaning_city')}`.trim()].filter(Boolean).join(', ')],
      ['Objektart', getValue('object_type')],
      ['Etage / Zugang zum Einsatzort', getValue('floor')],
      ['Möblierung', getValue('furnishing')],
    ], 1);

    selectedServiceKeys().forEach(key => {
      addSection(serviceLabels[key], serviceEntries(key), 1);
    });

    const appointment = selectedAppointment();
    const dateValue = appointment === 'Konkreter Termin'
      ? [formatDate(getValue('desired_date')), getValue('desired_time')].filter(Boolean).join(' · ')
      : '';
    addSection('Termin und Fotos', [
      ['Terminwunsch', appointment],
      ['Wunschdatum', dateValue],
      ['Hinweis', getValue('appointment_notes')],
      ['Fotos', fileInput?.files?.length ? `${fileInput.files.length} Foto(s) ausgewählt` : 'Keine Fotos ausgewählt'],
    ], 2);

    const fullName = [getValue('salutation'), getValue('first_name'), getValue('last_name')].filter(Boolean).join(' ');
    addSection('Kontakt', [
      ['Name', fullName],
      ['Firma des Auftraggebers', getValue('company')],
      ['E-Mail', getValue('email')],
      ['Telefon', getValue('phone')],
    ], 3);
  }

  form.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('input', updateReview);
    field.addEventListener('change', updateReview);
  });
  form.querySelectorAll('[data-next]').forEach(button => button.addEventListener('click', () => {
    if (button.closest('.form-step')?.querySelector('[data-service-choice-group]')) validateServiceChoice();
    setTimeout(updateReview, 0);
  }));

  const scrubOfferData = () => {
    clearPreviewUrls();
    form.querySelectorAll('input, select, textarea').forEach(field => {
      if (field.name === 'form_type') return;
      if (field instanceof HTMLSelectElement) {
        [...field.options].forEach((option, index) => { option.defaultSelected = index === 0; });
        field.selectedIndex = 0;
      } else if (field instanceof HTMLInputElement && ['checkbox', 'radio'].includes(field.type)) {
        field.defaultChecked = false;
        field.checked = false;
      } else {
        field.defaultValue = '';
        field.value = '';
      }
      if (field instanceof HTMLInputElement) {
        field.readOnly = false;
        field.removeAttribute('aria-readonly');
      }
      clearHiddenFieldError(field);
    });
    estimateChecks.forEach(check => {
      delete check.dataset.previousValue;
    });
    form.querySelectorAll('.field-error').forEach(error => { error.textContent = ''; });
    form.querySelectorAll('.has-error').forEach(element => element.classList.remove('has-error'));
    const status = form.querySelector('.form-status');
    if (status) {
      status.textContent = '';
      status.className = 'form-status';
    }
    fileList?.replaceChildren();
    dropzone?.classList.remove('is-dragging');
    review?.replaceChildren();
    if (contextCityValue) contextCityValue.textContent = '';
    if (contextCityNote) contextCityNote.hidden = true;
    if (objectCompanyValue) objectCompanyValue.textContent = '';
    if (objectCompanyPreview) objectCompanyPreview.hidden = true;
    if (copyCompanyButton) copyCompanyButton.hidden = true;
  };

  const showSuccess = ({ focus = false } = {}) => {
    form.hidden = true;
    if (intro) intro.hidden = true;
    if (help) help.hidden = true;
    if (successPanel) successPanel.hidden = false;
    if (focus) successHeading?.focus();
  };

  form.addEventListener('form:success', event => {
    form.dataset.offerState = 'success';
    scrubOfferData();
    if (successMessage) successMessage.textContent = event.detail?.message || 'Vielen Dank. Ihre Angebotsanfrage wurde erfolgreich gesendet.';
    showSuccess({ focus: true });
  });

  newRequest?.addEventListener('click', () => {
    if (form.dataset.offerState !== 'success') return;
    form.reset();
    scrubOfferData();
    form.dataset.offerState = 'editing';
    form.hidden = false;
    if (intro) intro.hidden = false;
    if (help) help.hidden = false;
    if (successPanel) successPanel.hidden = true;
    if (successMessage) successMessage.textContent = '';
    syncServicePanels();
    estimateChecks.forEach(check => setEstimateState(check, false, false));
    syncAppointment();
    syncFiles();
    syncContextCity();
    syncCompanyCopy();
    updateReview();
    form.dispatchEvent(new CustomEvent('form:new-request'));
  });

  window.addEventListener('pageshow', () => {
    if (form.dataset.offerState === 'success') {
      scrubOfferData();
      showSuccess();
      return;
    }
    if (form.getAttribute('aria-busy') === 'true') return;
    syncServicePanels();
    estimateChecks.forEach(check => setEstimateState(check, false, false));
    syncAppointment();
    syncFiles();
    syncContextCity();
    syncCompanyCopy();
    updateReview();
  });

  syncServicePanels();
  syncAppointment();
  syncFiles();
  syncContextCity();
  syncCompanyCopy();
  updateReview();
})();

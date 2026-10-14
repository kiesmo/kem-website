(() => {
  document.querySelectorAll('[data-multistep]').forEach(form => {
    const steps = [...form.querySelectorAll('.form-step')];
    const dots = [...form.querySelectorAll('.step-dot')];
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
      steps.forEach((step, stepIndex) => {
        const active = stepIndex === index;
        step.classList.toggle('active', active);
        step.setAttribute('aria-hidden', String(!active));
      });
      dots.forEach((dot, dotIndex) => dot.classList.toggle('active', dotIndex <= index));

      const heading = steps[index]?.querySelector('h2');
      const headingText = heading?.textContent?.trim() || `Schritt ${index + 1}`;
      stepStatus.textContent = `Schritt ${index + 1} von ${steps.length}: ${headingText.replace(/^\d+\.\s*/, '')}`;
      if (focus) heading?.focus();
    };

    const showField = (field, focus = true) => {
      const targetStep = field?.closest('.form-step');
      const targetIndex = targetStep ? steps.indexOf(targetStep) : -1;
      if (targetIndex >= 0) {
        index = targetIndex;
        paint();
      }
      if (focus) field?.focus();
    };

    form.querySelectorAll('[data-next]').forEach(button => button.addEventListener('click', () => {
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
      index = Math.max(0, index - 1);
      paint({ focus: true });
    }));

    form.addEventListener('form:show-field', event => showField(event.detail?.field));
    form.addEventListener('form:go-step', event => {
      const nextIndex = Number(event.detail?.index);
      if (!Number.isInteger(nextIndex) || nextIndex < 0 || nextIndex >= steps.length) return;
      index = nextIndex;
      paint({ focus: true });
    });
    form.addEventListener('form:success', () => {
      index = 0;
      paint({ focus: true });
    });

    paint();
  });

})();

(() => {
  const form = document.querySelector('[data-offer-form]');
  if (!form) return;

  const serviceChecks = [...form.querySelectorAll('[data-cleaning-type]')];
  const servicePanels = [...form.querySelectorAll('[data-service-panel]')];
  const serviceEmpty = form.querySelector('[data-service-detail-empty]');
  const serviceFieldset = form.querySelector('[data-service-choice-group]');
  const serviceError = form.querySelector('[data-service-choice-error]');
  const serviceValue = form.querySelector('#cleaning_types');
  const review = form.querySelector('[data-offer-review]');
  const fileInput = form.querySelector('#photos');
  const dropzone = form.querySelector('[data-upload-dropzone]');
  const fileList = form.querySelector('[data-upload-file-list]');
  const exactDateFields = form.querySelector('[data-exact-date-fields]');
  const appointmentRadios = [...form.querySelectorAll('input[name="appointment_preference"]')];
  const estimateChecks = [...form.querySelectorAll('[data-estimate-for]')];
  const estimateValue = 'Bitte vor Ort einschätzen';

  const serviceLabels = {
    office: 'Büro- und Gewerberaumreinigung',
    window: 'Glas- und Fensterreinigung',
    general: 'Grund- und Spezialreinigung',
    carpet: 'Teppichreinigung',
    upholstery: 'Polsterreinigung',
    clearance: 'Entrümpelung',
    graffiti: 'Fassaden- und Graffitireinigung',
    solar: 'Solar- und Photovoltaikanlagenreinigung',
    other: 'Sonstige Leistung',
  };

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
      ['Objektfläche', 'clearance_area', ' m²'], ['Volumen', 'clearance_volume'], ['Etage / Zugang', 'clearance_floor'],
      ['Aufzug', 'clearance_elevator'], ['Umfang', 'clearance_scope'], ['Hinweise', 'clearance_notes'],
    ],
    other: [['Beschreibung', 'other_details']],
  };

  const selectedServiceKeys = () => serviceChecks
    .filter(field => field.checked)
    .map(field => field.dataset.cleaningType)
    .filter(Boolean);

  const syncServicePanels = () => {
    const selected = selectedServiceKeys();
    const hasSelection = selected.length > 0;
    const first = serviceChecks[0];

    if (first) first.setCustomValidity(hasSelection ? '' : 'Bitte wählen Sie mindestens eine Reinigungsart aus.');
    if (hasSelection && serviceError) serviceError.textContent = '';
    if (serviceValue) serviceValue.value = selected.map(key => serviceLabels[key] || key).join(' | ');
    if (serviceEmpty) serviceEmpty.hidden = hasSelection;

    servicePanels.forEach(panel => {
      const active = selected.includes(panel.dataset.servicePanel);
      panel.hidden = !active;
      panel.querySelectorAll('input, select, textarea').forEach(field => {
        field.disabled = !active;
        if (field.hasAttribute('data-required-when-active')) field.required = active;
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
    if (!fileInput) return;
    const transfer = new DataTransfer();
    [...fileInput.files].forEach((file, fileIndex) => {
      if (fileIndex !== index) transfer.items.add(file);
    });
    fileInput.files = transfer.files;
    syncFiles();
  };

  const syncFiles = () => {
    if (!fileInput || !fileList) return;
    const files = [...fileInput.files];
    const allowed = ['image/jpeg', 'image/png', 'image/webp'];
    let error = '';
    if (files.length > 5) error = 'Bitte wählen Sie höchstens 5 Fotos aus.';
    if (!error && files.some(file => file.size > 5 * 1024 * 1024)) error = 'Jede Datei darf höchstens 5 MB groß sein.';
    if (!error && files.reduce((sum, file) => sum + file.size, 0) > 15 * 1024 * 1024) error = 'Die Fotos dürfen zusammen höchstens 15 MB groß sein.';
    if (!error && files.some(file => !allowed.includes(file.type))) error = 'Erlaubt sind ausschließlich JPG-, PNG- und WebP-Dateien.';
    fileInput.setCustomValidity(error);

    fileList.replaceChildren();
    files.forEach((file, index) => {
      const item = document.createElement('li');
      item.className = 'upload-preview-item';
      const image = document.createElement('img');
      image.alt = '';
      image.src = URL.createObjectURL(file);
      image.addEventListener('load', () => URL.revokeObjectURL(image.src), { once: true });
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
      dropzone.classList.add('is-dragging');
    }));
    ['dragleave', 'drop'].forEach(type => dropzone.addEventListener(type, event => {
      event.preventDefault();
      dropzone.classList.remove('is-dragging');
    }));
    dropzone.addEventListener('drop', event => {
      if (!event.dataTransfer?.files?.length) return;
      const transfer = new DataTransfer();
      [...event.dataTransfer.files].slice(0, 5).forEach(file => transfer.items.add(file));
      fileInput.files = transfer.files;
      syncFiles();
    });
  }

  const getValue = name => {
    const field = form.elements.namedItem(name);
    if (field instanceof RadioNodeList) return String(field.value || '').trim();
    if (!(field instanceof HTMLElement)) return '';
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
      ['Objekt / Firma', getValue('cleaning_company')],
      ['Adresse', [getValue('cleaning_street'), `${getValue('cleaning_postcode')} ${getValue('cleaning_city')}`.trim()].filter(Boolean).join(', ')],
      ['Objektart', getValue('object_type')],
      ['Etage', getValue('floor')],
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
      ['Firma', getValue('company')],
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

  form.addEventListener('form:success', () => {
    estimateChecks.forEach(check => {
      delete check.dataset.previousValue;
      setEstimateState(check, false);
    });
    syncServicePanels();
    syncAppointment();
    syncFiles();
    updateReview();
  });

  const contextNote = form.querySelector('[data-offer-context-note]');
  try {
    const options = JSON.parse(form.dataset.offerOptions || '{}');
    const initial = JSON.parse(form.dataset.offerContext || '{}');
    const params = new URLSearchParams(location.search);
    const candidate = key => params.has(key)
      ? (params.getAll(key).length === 1 ? params.get(key) : null)
      : initial[key];
    const service = candidate('service');
    const city = candidate('city');
    const chosen = (options.services || []).includes(service) ? serviceChecks.find(check => check.dataset.cleaningType === service) : null;
    if (chosen) chosen.checked = true;
    const cityLabel = Object.prototype.hasOwnProperty.call(options.cities || {}, city) ? options.cities[city] : '';
    if (cityLabel) form.elements.namedItem('cleaning_city').value = cityLabel;
    if (contextNote && (chosen || cityLabel)) {
      contextNote.textContent = `Vorschlag: ${[chosen ? serviceLabels[service] : '', cityLabel].filter(Boolean).join(' · ')}. Sie können Leistung und Ort jederzeit ändern.`;
      contextNote.hidden = false;
    }
  } catch (_) { /* Ignore malformed hints; ordinary selection remains available. */ }
  form.addEventListener('form:success', () => { if (contextNote) contextNote.hidden = true; });

  syncServicePanels();
  syncAppointment();
  syncFiles();
  updateReview();
})();

/**
 * Falcon Configurations Tab
 *
 * Reads spec data from data-config attribute on .falcon-configurations elements.
 * Handles both multi-toggle products (FSB, FSB56, FSB60) and static single-config
 * products (FSB84) without any inline scripts or onclick attributes.
 *
 * Inch marks in values use U+2033 (″) to avoid JSON/HTML quoting conflicts.
 */
(function () {
  document.addEventListener('DOMContentLoaded', function () {
    var sections = document.querySelectorAll('.falcon-configurations[data-config]');
    sections.forEach(initSection);
  });

  function initSection(section) {
    var config;
    try {
      config = JSON.parse(section.getAttribute('data-config'));
    } catch (e) {
      console.error('Falcon config: failed to parse data-config JSON', e);
      return;
    }

    var prefix = config.prefix;

    if (config.static) {
      renderTables(prefix, config.data.default || config.data);
      return;
    }

    var state = {};
    var toggleGroups = config.toggles;

    toggleGroups.forEach(function (group) {
      state[group.key] = group['default'];
    });

    renderTables(prefix, config.data[buildKey(toggleGroups, state)]);

    section.addEventListener('click', function (e) {
      var pill = e.target.closest('.toggle-pill');
      if (!pill) return;

      var pillsContainer = pill.closest('.toggle-pills');
      if (!pillsContainer) return;

      var groupKey = pillsContainer.getAttribute('data-group');
      var value = pill.getAttribute('data-value');
      if (!groupKey || !value) return;

      state[groupKey] = value;

      pillsContainer.querySelectorAll('.toggle-pill').forEach(function (b) {
        b.classList.remove('active');
      });
      pill.classList.add('active');

      var key = buildKey(toggleGroups, state);
      if (config.data[key]) {
        renderTables(prefix, config.data[key]);
      }
    });
  }

  function buildKey(toggleGroups, state) {
    return toggleGroups.map(function (g) { return state[g.key]; }).join('-');
  }

  function renderTables(prefix, data) {
    data = data || {};
    setTable(prefix + '-body-dims', data.body);
    setTable(prefix + '-side-ref',  data.side);
    setTable(prefix + '-rear-ref',  data.rear);
  }

  function setTable(id, rows) {
    var el = document.getElementById(id);
    if (!el) return;
    var section = el.closest('.spec-section');
    if (!rows || !rows.length) {
      el.innerHTML = '';
      if (section) section.style.display = 'none';
      return;
    }
    if (section) section.style.display = '';
    el.innerHTML = rowsHTML(rows);
  }

  function rowsHTML(rows) {
    return rows.map(function (r) {
      return '<tr><td>' + r[0] + '</td><td>' + r[1] + '</td></tr>';
    }).join('');
  }
})();

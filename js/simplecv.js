document.addEventListener('DOMContentLoaded', function () {
  function toggleFieldState(container, checkboxSelector, targetSelector) {
      const checkbox = container.querySelector(checkboxSelector);
      const target = container.querySelector(targetSelector);
      if (checkbox && target) {
          if (checkbox.checked) {
              target.value = '';
              target.disabled = true;
          } else {
              target.disabled = false;
          }
      }
  }

  function initToggle() {
      const groups = document.querySelectorAll('.cmb-repeatable-group');

      groups.forEach(group => {
          toggleFieldState(group, '[id$="still_working"]', '[id$="end_date"]');
          toggleFieldState(group, '[id$="still_reading"]', '[id$="end_date"]');

          const workCheckbox = group.querySelector('[id$="still_working"]');
          const readCheckbox = group.querySelector('[id$="still_reading"]');

          if (workCheckbox) {
              workCheckbox.addEventListener('change', () => {
                  toggleFieldState(group, '[id$="still_working"]', '[id$="end_date"]');
              });
          }

          if (readCheckbox) {
              readCheckbox.addEventListener('change', () => {
                  toggleFieldState(group, '[id$="still_reading"]', '[id$="end_date"]');
              });
          }
      });
  }

  // Initialize on page load
  initToggle();

  // Re-initialize on new group row added
  document.addEventListener('cmb2_add_row', function () {
      // Delay slightly to allow DOM update
      setTimeout(initToggle, 50);
  });
});

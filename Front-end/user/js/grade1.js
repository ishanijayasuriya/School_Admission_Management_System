 
//great1//
// Calculate age based on date of birth
document.getElementById('dob').addEventListener('change', function() {
    const dob = new Date(this.value);
    const cutoffDate = new Date('2025-02-31');
    
    if (dob && cutoffDate) {
        let years = cutoffDate.getFullYear() - dob.getFullYear();
        let months = cutoffDate.getMonth() - dob.getMonth();
        let days = cutoffDate.getDate() - dob.getDate();
        
        if (days < 0) {
            months--;
            days += new Date(
                cutoffDate.getFullYear(), 
                cutoffDate.getMonth(), 
                0
            ).getDate();
        }
        
        if (months < 0) {
            years--;
            months += 12;
        }
        
        document.getElementById('ageYears').value = years;
        document.getElementById('ageMonths').value = months;
        document.getElementById('ageDays').value = days;
    }
});

// Form validation before submission
document.getElementById('admissionForm').addEventListener('submit', function(e) {
    // Validate at least one category is selected
    const checkedCategories = document.querySelectorAll('input[name="categories[]"]:checked');
    if (checkedCategories.length === 0) {
        alert('Please select at least one category under Section 01.');
        e.preventDefault();
        return;
    }
    
    // Additional validation can be added here
});   





document.addEventListener('DOMContentLoaded', function() {
  // Show/hide category sections based on checkbox selection
  const categoryCheckboxes = document.querySelectorAll('input[name="categories[]"]');
  const categorySections = document.querySelectorAll('.category-section');
  
  categoryCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      // Hide all category sections first
      categorySections.forEach(section => {
        section.style.display = 'none';
      });
      
      // Show only the selected category sections
      categoryCheckboxes.forEach(cb => {
        if (cb.checked) {
          const sectionId = `section${cb.value.replace('.', '_')}`;
          const section = document.getElementById(sectionId);
          if (section) {
            section.style.display = 'block';
          }
        }
      });
    });
  });
  
  // Calculate age based on date of birth
  const dobInput = document.getElementById('dob');
  const ageYearsInput = document.getElementById('ageYears');
  const ageMonthsInput = document.getElementById('ageMonths');
  const ageDaysInput = document.getElementById('ageDays');
  
  if (dobInput && ageYearsInput && ageMonthsInput && ageDaysInput) {
    dobInput.addEventListener('change', function() {
      const dob = new Date(this.value);
      const cutoffDate = new Date('2025-02-31'); // February 31st will be treated as March 3rd
      
      let years = cutoffDate.getFullYear() - dob.getFullYear();
      let months = cutoffDate.getMonth() - dob.getMonth();
      let days = cutoffDate.getDate() - dob.getDate();
      
      if (days < 0) {
        months--;
        // Get the last day of the previous month
        const lastDayOfMonth = new Date(
          cutoffDate.getFullYear(),
          cutoffDate.getMonth(),
          0
        ).getDate();
        days += lastDayOfMonth;
      }
      
      if (months < 0) {
        years--;
        months += 12;
      }
      
      ageYearsInput.value = years;
      ageMonthsInput.value = months;
      ageDaysInput.value = days;
    });
  }
  
  // Add more guardianship years
  const addGuardianshipYearBtn = document.getElementById('addGuardianshipYear');
  if (addGuardianshipYearBtn) {
    addGuardianshipYearBtn.addEventListener('click', function() {
      const guardianshipYears = document.querySelector('.guardianship-years');
      const firstYear = document.querySelector('.guardianship-year');
      
      if (firstYear) {
        const newYear = firstYear.cloneNode(true);
        // Clear all input values in the cloned section
        newYear.querySelectorAll('input, textarea').forEach(input => {
          input.value = '';
        });
        guardianshipYears.insertBefore(newYear, addGuardianshipYearBtn);
      }
    });
  }
  
  // Save draft functionality
  const saveDraftBtn = document.getElementById('saveDraft');
  if (saveDraftBtn) {
    saveDraftBtn.addEventListener('click', function() {
      const formData = new FormData(document.getElementById('admissionForm'));
      
      // Convert form data to JSON
      const jsonData = {};
      formData.forEach((value, key) => {
        if (!jsonData[key]) {
          jsonData[key] = value;
        } else {
          if (!Array.isArray(jsonData[key])) {
            jsonData[key] = [jsonData[key]];
          }
          jsonData[key].push(value);
        }
      });
      
      // Save to localStorage
      localStorage.setItem('admissionFormDraft', JSON.stringify(jsonData));
      alert('Draft saved successfully!');
    });
  }
  
  // Load draft if exists
  const loadDraft = () => {
    const draft = localStorage.getItem('admissionFormDraft');
    if (draft) {
      if (confirm('A saved draft was found. Do you want to load it?')) {
        const formData = JSON.parse(draft);
        const form = document.getElementById('admissionForm');
        
        for (const key in formData) {
          const elements = form.elements[key];
          const value = formData[key];
          
          if (elements) {
            if (Array.isArray(elements)) {
              elements.forEach((element, index) => {
                if (Array.isArray(value)) {
                  element.value = value[index] || '';
                } else {
                  element.value = value || '';
                }
              });
            } else {
              if (elements.type === 'checkbox') {
                elements.checked = value === 'on';
              } else if (elements.type === 'file') {
                // Can't set file input value for security reasons
              } else {
                elements.value = value || '';
              }
            }
          }
        }
      }
    }
  };
  
  // Load draft on page load
  loadDraft();
  
  // Form validation before submission
  const admissionForm = document.getElementById('admissionForm');
  if (admissionForm) {
    admissionForm.addEventListener('submit', function(e) {
      // Check if at least one category is selected
      const checkedCategories = document.querySelectorAll('input[name="categories[]"]:checked');
      if (checkedCategories.length === 0) {
        e.preventDefault();
        alert('Please select at least one category under Section 01.');
        return;
      }
      
      // Check if all required fields are filled
      const requiredFields = document.querySelectorAll('[required]');
      let isValid = true;
      
      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          field.style.borderColor = '#e74c3c';
          isValid = false;
        } else {
          field.style.borderColor = '';
        }
      });
      
      if (!isValid) {
        e.preventDefault();
        alert('Please fill all required fields marked with red borders.');
      }
    });
  }
});
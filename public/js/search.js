// Search Enhancement Script
document.addEventListener('DOMContentLoaded', function () {
    // Auto-submit form when select changes (optional)
    const searchForm = document.querySelector('.search-form');
    const selectElements = searchForm?.querySelectorAll('select');

    if (selectElements) {
        selectElements.forEach(select => {
            select.addEventListener('change', function () {
                // Optional: Auto-submit on select change
                // Uncomment the line below if you want auto-submit
                // searchForm.submit();
            });
        });
    }

    // Search input enhancement
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        // Add search icon to input
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                searchForm?.submit();
            }
        });

        // Clear button functionality
        const clearBtn = document.querySelector('.btn-secondary');
        if (clearBtn) {
            clearBtn.addEventListener('click', function (e) {
                e.preventDefault();
                // Clear all form inputs
                searchForm?.querySelectorAll('input, select').forEach(input => {
                    if (input.type === 'text') {
                        input.value = '';
                    } else if (input.tagName === 'SELECT') {
                        input.selectedIndex = 0;
                    }
                });
                // Submit form to show all products
                window.location.href = this.href;
            });
        }
    }

    // Add loading state to search button
    const searchBtn = document.querySelector('.search-form button[type="submit"]');
    if (searchBtn) {
        searchForm?.addEventListener('submit', function () {
            searchBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            searchBtn.disabled = true;
        });
    }

    // Highlight search terms in results (optional)
    const searchTerm = new URLSearchParams(window.location.search).get('search');
    if (searchTerm) {
        highlightSearchTerms(searchTerm);
    }
});

function highlightSearchTerms(term) {
    if (!term) return;

    const productTitles = document.querySelectorAll('.product-item h4');
    productTitles.forEach(title => {
        const regex = new RegExp(`(${term})`, 'gi');
        title.innerHTML = title.innerHTML.replace(regex, '<mark>$1</mark>');
    });
}

// Advanced search toggle (for future enhancement)
function toggleAdvancedSearch() {
    const advancedSection = document.querySelector('.advanced-search');
    if (advancedSection) {
        advancedSection.style.display =
            advancedSection.style.display === 'none' ? 'block' : 'none';
    }
}
// Billiard Management System - Custom JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips and popovers
    initializeTooltips();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize booking filters
    initializeFilters();
});

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    const elements = document.querySelectorAll('[data-tooltip]');
    elements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.dataset.tooltip;
            tooltip.style.position = 'absolute';
            tooltip.style.background = '#333';
            tooltip.style.color = '#fff';
            tooltip.style.padding = '5px 10px';
            tooltip.style.borderRadius = '4px';
            tooltip.style.fontSize = '12px';
            tooltip.style.zIndex = '1000';
            tooltip.style.pointerEvents = 'none';
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
            tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
        });
    });
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const requiredFields = form.querySelectorAll('[required]');
        
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#ff6b6b';
                    field.style.backgroundColor = '#fff2f2';
                } else {
                    field.style.borderColor = '';
                    field.style.backgroundColor = '';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showNotification('Silakan isi semua field yang wajib diisi', 'error');
            }
        });
    });
}

/**
 * Initialize booking filters
 */
function initializeFilters() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            const items = document.querySelectorAll('[data-item]');
            
            items.forEach(item => {
                if (filter === 'all' || item.dataset.item === filter) {
                    item.style.display = '';
                    item.style.animation = 'fadeIn 0.3s ease-out';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

/**
 * Show notification
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.maxWidth = '400px';
    notification.style.zIndex = '2000';
    notification.style.animation = 'slideIn 0.3s ease-out';
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

/**
 * Format currency
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(amount);
}

/**
 * Format date
 */
function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

/**
 * Calculate booking duration
 */
function calculateDuration(startTime, endTime) {
    const start = new Date(`2000-01-01 ${startTime}`);
    const end = new Date(`2000-01-01 ${endTime}`);
    return Math.abs(end - start) / 36e5; // Convert milliseconds to hours
}

/**
 * Confirm action
 */
function confirmAction(message) {
    return confirm(message);
}

/**
 * Export table to CSV
 */
function exportTableToCSV(tableId, filename = 'export.csv') {
    const table = document.getElementById(tableId);
    let csv = [];
    
    // Get headers
    const headers = table.querySelectorAll('thead th');
    const headerRow = [];
    headers.forEach(header => {
        headerRow.push(header.textContent);
    });
    csv.push(headerRow.join(','));
    
    // Get rows
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowData = [];
        cells.forEach(cell => {
            rowData.push('"' + cell.textContent + '"');
        });
        csv.push(rowData.join(','));
    });
    
    // Download
    const csvContent = 'data:text/csv;charset=utf-8,' + csv.join('\n');
    const link = document.createElement('a');
    link.setAttribute('href', encodeURI(csvContent));
    link.setAttribute('download', filename);
    link.click();
}

/**
 * Print page
 */
function printPage() {
    window.print();
}

/**
 * Debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Throttle function
 */
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Export functions for global use
window.BilliardApp = {
    showNotification,
    formatCurrency,
    formatDate,
    calculateDuration,
    confirmAction,
    exportTableToCSV,
    printPage,
    debounce,
    throttle
};
